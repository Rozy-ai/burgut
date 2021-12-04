<?php

namespace common\models\wrappers;

use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
use common\models\Album;
use common\models\CategoryLang;
use common\models\Item;
use common\models\Category;
use common\models\Music;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%tbl_category}}".
 *
 * @property integer $id
 * @property string $alias
 * @property string $meta_description
 * @property string $meta_keyword
 * @property string $description
 * @property string $name
 * @property string $url_prefix
 * @property integer $related_category_id
 * @property integer $parent_id
 * @property string $code
 * @property integer $top
 * @property integer $column
 * @property integer $sort_order
 * @property integer $status
 * @property string $date_added
 * @property string $date_modified
 * @property string $edited_username
 * @property string $create_username
 */
class CategoryWrapper extends Category
{
    const TYPE_DETAILED = 1, TYPE_TEXT = 2, TYPE_RELATED = 3;
    const STATUS_DISABLED = 0, STATUS_ENABLED = 1;
    const IMAGE_SIZE1 = 1, IMAGE_SIZE2 = 2, IMAGE_SIZE3 = 3, IMAGE_SIZE_CART = 4;
    public $docs = [];
    private $_url;
    private $_item_url;
    private $urlPrefixValue;

//    private $_name;

    public function getUrl($absolute = false)
    {
        if ($this->_url === null) {
            $path = $this->getPath("/", true);
//            $path = explode('/', $path);
//            $controller = array_shift($path);
//            print_r(Url::home());
            $this->_url = rtrim(Url::to(['/']), '/') . '/' . $path;
//            $this->_url = Url::to([$controller . '/index', 'path' => implode($path)]);
//            if ($absolute == true)
//                $this->_url = Yii::app()->createAbsoluteUrl($this->_url);
        }

        return $this->_url;
    }


    public function getPath($separator = '/', $with_prefix = false)
    {
        $uri = array($this->alias);
        $this->urlPrefixValue = trim($this->url_prefix, $separator);

        $category = $this;

        $i = 10;

        while ($i-- && $category->parent) {
            $uri[] = $category->parent->alias;
            $parent = $category->parent;
            $childUrlPrefix = trim($category->url_prefix, $separator);
            $this->urlPrefixValue = trim($parent->url_prefix, $separator);

            if (isset($childUrlPrefix) && strlen(trim($childUrlPrefix)) > 0 && $childUrlPrefix !== $this->urlPrefixValue) {
                $this->urlPrefixValue = $childUrlPrefix;
            }

            $category = $parent;
        }

        if ($with_prefix == true)
            return $this->urlPrefixValue . $separator . implode(array_reverse($uri), $separator);
        return implode(array_reverse($uri), $separator);
    }


    public static function findByPath($path)
    {
        $domens = explode('/', trim($path, '/'));
        $model = null;

        if (count($domens) == 1) {
            $categoryLangModel = CategoryLangWrapper::find()->joinWith('category cat')->where(['alias' => $domens[0]])->andWhere(['OR', 'cat.parent_id is null', 'cat.parent_id=0'])->one();
            if (isset($categoryLangModel)) {
                $model = $categoryLangModel->category;
            }
        } else {

            $categoryLangModel = CategoryLangWrapper::find()->joinWith('category cat')->where(['alias' => $domens[0]])->andWhere(['OR', 'cat.parent_id is null', 'cat.parent_id=0'])->one();
            if (isset($categoryLangModel)) {
                $parent = $categoryLangModel->category;
            }

            if ($parent) {
                $domens = array_slice($domens, 1);
                foreach ($domens as $alias) {
                    $model = $parent->getChildByAlias($alias);
                    if (!$model) return null;
                    $parent = $model;
                }
            }
        }

        return $model;
    }

    protected function getChildByAlias($alias)
    {
        $childLangModel = CategoryLangWrapper::find()->joinWith('category cat')->where(['alias' => $alias, 'cat.parent_id' => $this->id])->one();
        if (isset($childLangModel)) {
            $model = $childLangModel->category;
        }
        return $model;
    }


    public function getBreadcrumbs($lastLink = false)
    {
        $breadcrumbs = [];
        if ($lastLink) {
            $breadcrumbs[] = array('label' => $this->name, 'url' => $this->url);
        } else {
            $breadcrumbs[] = array('label' => $this->name);
        }
        $page = $this;
        $i = 50;

        while ($i-- && $page->parent) {
            $parent = $page->parent;
            $breadcrumbs[] = array('label' => $parent->name, 'url' => $parent->url);
            $page = $parent;
        }

        return array_reverse($breadcrumbs);
    }

    public function rules()
    {
        return \yii\helpers\ArrayHelper::merge(parent::rules(), [
            [['name'], 'required'],
            [['name', 'description', 'alias', 'meta_description', 'meta_keyword'], 'string'],
            [['name', 'description', 'alias', 'meta_description', 'meta_keyword'], 'safe'],
//            [['name', 'description', 'alias','meta_description','meta_keyword',  'name_tm',  'name_ru', 'description_ru', 'name_en', 'description_en'], 'safe'],
        ]);
    }

    public function behaviors()
    {
        return [
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->urlManager->languages,
//                'languages' => [
//                    'tk' => 'Turkmen',
//                    'ru' => 'Russian',
//                    'en' => 'English',
//                ],
                //'languageField' => 'language',
                //'localizedPrefix' => '',
                //'requireTranslations' => false',
                //'dynamicLangClass' => true',
                'langClassName' => CategoryLangWrapper::className(), // or namespace/for/a/class/PostLang
                'defaultLanguage' => Yii::$app->language,
                'langForeignKey' => 'category_id',
                'tableName' => "{{%tbl_category_lang}}",
                'attributes' => [
                    'name', 'description', 'alias', 'meta_description', 'meta_keyword'
                ]
            ],
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    [
                        'editableAttribute' => 'docs', // Editable attribute name
                        'name' => 'documents',
                    ],
                ],
            ],
        ];
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!isset($this->alias) || strlen(trim($this->alias)) == 0) {
                $this->alias = preg_replace("/[^[:alnum:][:space:]]/u", '', strtolower($this->name));
            }
            return true;
        } else {
            return false;
        }
    }


    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }


    public function getTranslations()
    {
        return $this->hasMany(CategoryLang::className(), ['category_id' => 'id']);
    }


    public function getCategoryFields()
    {
        return $this->hasMany(CategoryFieldWrapper::className(), ['category_id' => 'id']);
    }


    public function getItemUrl($absolute = false)
    {
        if ($this->_item_url === null) {
            $path = $this->url_prefix . '/' . $this->alias;
            $this->_item_url = Url::to([$path]);
        }
        if ($absolute == true)
            $this->_item_url = Yii::app()->createAbsoluteUrl($this->_item_url);
        return $this->_item_url;
    }


    public function getParent()
    {
        return $this->hasOne(CategoryWrapper::className(), ['id' => 'parent_id']);
    }


    public function getChildren()
    {
        return $this->hasMany(CategoryWrapper::className(), ['parent_id' => 'id']);
    }

    public function getDocuments()
    {
        return $this->hasMany(DocumentWrapper::className(), ['id' => 'document_id'])
            ->viaTable('tbl_category_to_document', ['category_id' => 'id'])
            ->orderBy('type');
    }
}
