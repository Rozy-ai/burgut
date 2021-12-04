<?php

namespace common\models\wrappers;

use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
use common\models\Album;
use common\models\Location;
use common\models\LocationLang;
use common\models\Music;
use common\models\query\LocationQuery;
use omgdef\multilingual\MultilingualBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%tbl_location}}".
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
 * @property string $edited_username
 * @property string $create_username
 * @property string $date_added
 * @property string $date_modified
 */
class LocationWrapper extends Location
{
    public $docs = [];
    public $calendar_date;

    private $_url;

    public function getUrl()
    {
        if ($this->_url === null)
            $this->_url = Url::to(['location/view', 'id' => $this->id]);

        return $this->_url;
    }


    public function attributeLabels()
    {
        return \yii\helpers\ArrayHelper::merge(parent::attributeLabels(), [
            'title' => Yii::t('app', 'Location Title'),
        ]);
    }

    public function rules()
    {
        return \yii\helpers\ArrayHelper::merge(parent::rules(), [
            [['title', 'description', 'content'], 'string'],
            [['title', 'description', 'content', 'category_id', 'parent_category_id', 'title_ru', 'description_ru', 'title_en', 'description_en'], 'safe'],
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
            'ml' => [
                'class' => MultilingualBehavior::className(),
                'languages' => Yii::$app->urlManager->languages,
                //'languageField' => 'language',
                //'localizedPrefix' => '',
                //'requireTranslations' => false',
                //'dynamicLangClass' => true',
                'langClassName' => LocationLang::className(), // or namespace/for/a/class/PostLang
                'defaultLanguage' => Yii::$app->language,
                'langForeignKey' => 'location_id',
                'tableName' => "{{%tbl_location_lang}}",
                'attributes' => [
                    'title', 'description', 'content',
                ]
            ],
        ];
    }

    public static function find()
    {
        return new LocationQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
//            if (isset($this->event_date) || strlen(trim($this->event_date)) > 0)
//                $this->event_date = \Yii::$app->formatter->asDate($this->event_date, 'yyyy-MM-dd HH:mm:ss');

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


    public function getMerchant()
    {
        return $this->hasOne(MerchantWrapper::className(), ['id' => 'merchant_id']);
    }



    public function fields()
    {
        $fields = parent::fields();
        $fields['title'] = function () {
            return $this->fullTitle;
        };
        $fields['description'] = function () {
            return $this->description;
        };

        $fields['thumbUrl'] = function () {
            return $this->getThumbPath(461, 255, 'h', true, false, true);
        };

//        $fields['prices'] = function () {
//            return $this->getRoomPrices();
//        };
//        $fields['is_liked'] = function () {
//            $checkActivity = $this->findAdvertActivity(AdvertActivityWrapper::TYPE_LIKE);
//            return isset($checkActivity);
//        };

        unset($fields['alias'], $fields['parent_category_id'], $fields['sort_order'], $fields['merchant_id'], $fields['visited_count'], $fields['create_username'], $fields['edited_username'], $fields['date_created'], $fields['date_modified']);
        return $fields;
    }


    public function extraFields()
    {
        $extraFields = parent::extraFields();
        $extraFields['content'] = function () {
            return $this->content;
        };

        $extraFields['schemaThumbUrl'] = function () {
            return $this->getThumbPath(570, 400, 'h', false, false, true, 'schema');
        };

        $extraFields['schemaFullUrl'] = function () {
            return $this->getThumbPath(1540, 750, 'h', false, false, true, 'schema');
        };

        $extraFields['documents'] = function () {
            $docs = $this->documents;
            $thumbs = [];
            foreach ($docs as $document) {
                $thumb['id'] = $document->id;
                $thumb['code'] = $document->code;
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


    public function getEvents()
    {
        return $this->hasMany(EventWrapper::className(), ['location_id' => 'id']);
    }

    public function getCategory()
    {
        return $this->hasOne(CategoryWrapper::className(), ['id' => 'category_id']);
    }

    public function getParent()
    {
        return $this->hasOne(LocationWrapper::className(), ['id' => 'parent_id']);
    }

    public function getDocuments()
    {
        return $this->hasMany(DocumentWrapper::className(), ['id' => 'document_id'])
            ->viaTable('tbl_location_to_document', ['location_id' => 'id'])
            ->orderBy('type');
    }


    public function getComments()
    {
        return $this->hasMany(CommentWrapper::className(), ['id' => 'comment_id'])
            ->viaTable('tbl_location_to_comment', ['location_id' => 'id']);
    }


    public function getTranslations()
    {
        return $this->hasMany(LocationLang::className(), ['location_id' => 'id']);
    }


    private $_fullTitle;

    public function getFullTitle()
    {
        if (!isset($this->_fullTitle)) {
            $this->_fullTitle = $this->title;
            $parent = $this->parent;
            if (isset($parent)) {
                $this->_fullTitle = $parent->title . " (" . $this->_fullTitle . ")";
            }
        }

        return $this->_fullTitle;
    }


    const TYPE_DETAILED = 1, TYPE_TEXT = 2, TYPE_RELATED = 3;

    public static function getTypeOptions()
    {
        return array(
            self::TYPE_DETAILED => Yii::t('app', 'TYPE_DETAILED'),
            self::TYPE_TEXT => Yii::t('app', 'TYPE_TEXT'),
            self::TYPE_RELATED => Yii::t('app', 'TYPE_RELATED'),
        );
    }

    public function getTypeText()
    {
        $typeOptions = $this->getTypeOptions();
        return isset($typeOptions[$this->type]) ? $typeOptions[$this->type] : '';
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

    const IMAGE_SIZE1 = 1, IMAGE_SIZE2 = 2, IMAGE_SIZE3 = 3, IMAGE_SIZE_CART = 4;

    public static function getSizeByType($type)
    {
        $sizes = array(
            self::TYPE_TEXT => array(
                self::IMAGE_SIZE1 => array('width' => 460, 'height' => 255,),
                self::IMAGE_SIZE2 => array('data-width' => 380, 'data-height' => 480),
                self::IMAGE_SIZE3 => array('data-width' => 760, 'data-height' => 240),
            ),
            self::TYPE_DETAILED => array(
                self::IMAGE_SIZE_CART => array('width' => 460, 'height' => 255),
            ),
        );

        if (isset($sizes[$type]))
            return $sizes[$type];
        return null;
    }

    public static function getMerchantOptions()
    {
        $merchants = MerchantWrapper::find()->all();
        return ArrayHelper::map($merchants, 'id', 'name');
    }

    public function getChildrenCount()
    {
        return LocationWrapper::find()->where(['parent_id' => $this->id])->count();
    }

}
