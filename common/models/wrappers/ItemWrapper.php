<?php

namespace common\models\wrappers;

use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
use common\components\DynamicFieldsBehavior;
use common\models\CategoryField;
use common\models\Item;
use common\models\ItemLang;
use dosamigos\taggable\Taggable;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\wrappers\TagWrapper;

/**
 * This is the model class for table "{{%tbl_item}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $icon
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
class ItemWrapper extends Item
{
    const TYPE_DETAILED = 1, TYPE_TEXT = 2, TYPE_RELATED = 3;
    const STATUS_DISABLED = 0, STATUS_ENABLED = 1;
    const IMAGE_SIZE1 = 1, IMAGE_SIZE2 = 2, IMAGE_SIZE3 = 3, IMAGE_SIZE_CART = 4;
    public $docs = [];
    public $calendar_date;
    private $_url;

    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }
//
    public static function getSizeByType($type)
    {
        $sizes = array(
            self::TYPE_TEXT => array(
                self::IMAGE_SIZE1 => array('width' => 365, 'height' => 215,),
                self::IMAGE_SIZE2 => array('data-width' => 380, 'data-height' => 480),
                self::IMAGE_SIZE3 => array('data-width' => 760, 'data-height' => 240),
            ),
            self::TYPE_DETAILED => array(
                self::IMAGE_SIZE_CART => array('width' => 365, 'height' => 215),
            ),
        );

        if (isset($sizes[$type]))
            return $sizes[$type];
        return null;
    }
//
    public function getUrl($absolute = false)
    {
        if ($this->_url === null)
            $this->_url = Url::to(['item/view', 'id' => $this->id]);

        return $this->_url;
    }

    public function getNewsUrl($absolute = false)
    {
        if ($this->_url === null)
            $this->_url = Url::to(['news/view', 'id' => $this->id]);

        return $this->_url;
    }
//
    public function rules()
    {
        return \yii\helpers\ArrayHelper::merge(parent::rules(), [
            [['title', 'description', 'content'], 'string'],
            [['tagNames', 'title', 'description', 'content', 'category_id', 'parent_category_id', 'title_ru', 'description_ru', 'title_en', 'description_en', 'icon'], 'safe'],
        ]);
    }
//
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
            'dynamicFields' => [
                'class' => DynamicFieldsBehavior::class,
                'fields' => $this->getDynamicFieldNames(),
            ],
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->urlManager->languages,
                //'languageField' => 'language',
                //'localizedPrefix' => '',
                //'requireTranslations' => false',
                //'dynamicLangClass' => true',
                'langClassName' => ItemLang::className(), // or namespace/for/a/class/PostLang
                'defaultLanguage' => Yii::$app->language,
                'langForeignKey' => 'item_id',
                'tableName' => "{{%tbl_item_lang}}",
                'attributes' => [
                    'title', 'description', 'content',
                ]
            ],
            [
                'class' => Taggable::className(),
            ],
        ];
    }
    public function getDynamicFieldNames($onlyRelated = false)
    {
        if (Yii::$app->controller->action->id == 'create'){
            $categoryFields = $this->getDynamicFields($onlyRelated);
            return array_keys(ArrayHelper::map($categoryFields, 'field_name', 'field_name'));

        } else{
            $categoryFields = $this->getDynamicFields($onlyRelated);
            $categoryFields = ArrayHelper::map($categoryFields, 'multilingual', 'field_name','id');
            $languages = Yii::$app->urlManager->languages;
            foreach ($categoryFields as $categoryField) {
                foreach ($categoryField as $key => $item){
                    $fields[] = $item;
                    if($key == 1){
                        foreach ($languages as $lang) {
                            $fields[] = $item.'_'.$lang;
                        }
                    }
                }
            }
            return $fields;
        }
    }

    public function getDynamicFields($onlyRelated = false)
    {
        $categoryFields = [];
        if (isset($this->category_id)) {
            $categoryFields = CategoryFieldWrapper::find()->with(['translations'])->where(['category_id' => $this->category_id, 'target_model' => (new \ReflectionClass($this))->getShortName()])->all();
        } elseif (!$onlyRelated)
            $categoryFields = CategoryFieldWrapper::find()->with(['translations'])->where(['target_model' => (new \ReflectionClass($this))->getShortName()])->all();
        return $categoryFields;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (isset($this->category_id) || strlen(trim($this->category_id)) > 0) {
                $categoryModel = $this->category;
                if (isset($categoryModel)) {
                    $this->parent_category_id = $categoryModel->parent_id;
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['title'] = function () {
            return $this->title;
        };
        $fields['description'] = function () {
            return $this->description;
        };
        $fields['thumbUrl'] = function () {
            return $this->getThumbPath(185, 151, 'h', true, false, true);
        };
//        $fields['prices'] = function () {
//            return $this->getRoomPrices();
//        };
//        $fields['is_liked'] = function () {
//            $checkActivity = $this->findAdvertActivity(AdvertActivityWrapper::TYPE_LIKE);
//            return isset($checkActivity);
//        };

        unset($fields['alias'], $fields['parent_category_id'], $fields['sort_order'], $fields['is_main'], $fields['is_menu'], $fields['type']);
        return $fields;
    }

    public function extraFields()
    {
        $extraFields = parent::extraFields();
        $extraFields['documents'] = function () {
            $docs = $this->documents;
            $thumbs = [];
            foreach ($docs as $document) {
                $thumb['id'] = $document->id;
                $thumb['thumbUrl'] = $document->getThumb(250, 250, 'h');
                $thumb['fullUrl'] = $document->getFullPath();
                $thumbs[] = $thumb;
            }
            return $thumbs;
        };


        $extraFields['events'] = function () {
            $events = EventWrapper::find()->where(['location_id' => $this->id])->all();
            $eventsData = [];
            foreach ($events as $event) {
                $eventData = [];
//                $eventData['url'] = $event->url;
                $eventData['start_time'] = $event->start_time;

                $contentModel = $event->loadContent();
                if (isset($contentModel))
                    $eventData['title'] = $contentModel->title;
                $eventsData[] = $eventData;
            }
            return $eventsData;
        };

        return $extraFields;
    }

    public function getTags()
    {
        return $this->hasMany(TagWrapper::className(), ['id' => 'tag_id'])->viaTable('tbl_item_to_tag', ['item_id' => 'id']);
    }

    public function getEvents()
    {
        return $this->hasMany(EventWrapper::className(), ['location_id' => 'id']);
    }

    public function getCategory()
    {
        return $this->hasOne(CategoryWrapper::className(), ['id' => 'category_id']);
    }

    public function loadCategory()
    {
        return CategoryWrapper::find()->where(['id' => $this->category_id])->multilingual()->one();
//        return $this->hasOne(CategoryWrapper::className(), ['id' => 'category_id']);
    }

    public function getDocuments()
    {
        return $this->hasMany(DocumentWrapper::className(), ['id' => 'document_id'])
            ->viaTable('tbl_item_to_document', ['item_id' => 'id'])
            ->orderBy('type');
    }

    public function getTranslations()
    {
        return $this->hasMany(ItemLang::className(), ['item_id' => 'id']);
    }

    public function getTypeText()
    {
        $typeOptions = $this->getTypeOptions();
        return isset($typeOptions[$this->type]) ? $typeOptions[$this->type] : '';
    }

    public static function getTypeOptions()
    {
        return array(
            self::TYPE_DETAILED => Yii::t('app', 'TYPE_DETAILED'),
            self::TYPE_TEXT => Yii::t('app', 'TYPE_TEXT'),
            self::TYPE_RELATED => Yii::t('app', 'TYPE_RELATED'),
        );
    }

    public function getStatusText()
    {
        $statusOptions = $this->getStatusOptions();
        return isset($statusOptions[$this->status]) ? $statusOptions[$this->status] : '';
    }

    public static function getStatusOptions()
    {
        return array(
            self::STATUS_DISABLED => Yii::t('app', 'STATUS_DISABLED'),
            self::STATUS_ENABLED => Yii::t('app', 'STATUS_ENABLED')
        );
    }

}
