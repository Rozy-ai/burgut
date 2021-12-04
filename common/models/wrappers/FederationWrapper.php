<?php

namespace common\models\wrappers;

use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
use common\models\Album;
use common\models\Federation;
use common\models\FederationLang;
use common\models\Item;
use common\models\ItemLang;
use common\models\Music;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%tbl_federation}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $alias
 * @property integer $category_id
 * @property integer $parent_category_id
 * @property integer $visited_count
 * @property integer $sort_order
 * @property integer $status
 * @property integer $is_main
 * @property string $author
 * @property string $edited_username
 * @property string $create_username
 * @property string $date_added
 * @property string $date_modified
 */
class FederationWrapper extends Federation
{
    public $docs = [];
    public $cats= [];
    private $_url;

    public function getUrl($absolute = false)
    {
        if ($this->_url === null)
            $this->_url = Url::to(['federation/view', 'id' => $this->id]);
        return $this->_url;
    }


    public function rules()
    {
        return \yii\helpers\ArrayHelper::merge(parent::rules(), [
            [['title', 'description', 'content'], 'string'],
            [['title', 'description', 'content', 'address', 'title_ru', 'description_ru', 'address_ru', 'title_en', 'description_en'], 'safe'],
        ]);
    }


    public function attributeLabels()
    {
        return \yii\helpers\ArrayHelper::merge(parent::attributeLabels(), [
            'phone' => Yii::t('app', 'Phone'),
            'fax' => Yii::t('app', 'Fax'),
            'description' => Yii::t('app', 'Federation description'),
            'address' => Yii::t('app', 'Address'),
            'email' => Yii::t('app', 'Our email'),
        ]);
    }

    public function behaviors()
    {
        return [
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    [
                        'editableAttribute' => 'docs', // Editable attribute name
                        'name' => 'documents',
                    ],
                ],
            ],
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    [
                        'editableAttribute' => 'cats', // Editable attribute name
                        'name' => 'categories',
                    ],
                ],
            ],
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->urlManager->languages,
                //'languageField' => 'language',
                //'localizedPrefix' => '',
                //'requireTranslations' => false',
                //'dynamicLangClass' => true',
                'langClassName' => FederationLang::className(), // or namespace/for/a/class/PostLang
                'defaultLanguage' => Yii::$app->language,
                'langForeignKey' => 'federation_id',
                'tableName' => "{{%tbl_federation_lang}}",
                'attributes' => [
                    'title', 'description', 'content', 'address',
                ]
            ],
        ];
    }

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }


    public function getDocuments()
    {
        return $this->hasMany(DocumentWrapper::className(), ['id' => 'document_id'])
            ->viaTable('tbl_federation_to_document', ['federation_id' => 'id'])
            ->orderBy('type');
    }


    public function getCategories()
    {
        return $this->hasMany(CategoryWrapper::className(), ['id' => 'category_id'])
            ->viaTable('tbl_federation_to_category', ['federation_id' => 'id']);
    }


    public function getTranslations()
    {
        return $this->hasMany(FederationLang::className(), ['federation_id' => 'id']);
    }


    const STATUS_DISABLED = 0, STATUS_ENABLED = 1;

    public static function getStatusOptions()
    {
        return array(
            self::STATUS_DISABLED => Yii::t('app', 'STATUS_DISABLED'),
            self::STATUS_ENABLED => Yii::t('app', 'STATUS_ENABLED')
        );
    }

    public function getStatusText()
    {
        $statusOptions = $this->getStatusOptions();
        return isset($statusOptions[$this->status]) ? $statusOptions[$this->status] : '';
    }
}
