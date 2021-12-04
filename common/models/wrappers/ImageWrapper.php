<?php

namespace common\models\wrappers;

use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
use common\models\Document;
use common\models\Image;
use common\models\ImageLang;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%tbl_image}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $type
 * @property string $date_created
 * @property string $date_modified
 */
class ImageWrapper extends Image
{
    public $docs = [];
    public $video_docs = [];
    public $_image;
    private $_url;


    public function getGalleryUrl($absolute = false)
    {
        if ($this->_url === null)
            $this->_url = Url::to(['gallery/view', 'id' => $this->id]);

        if ($absolute == true)
            $this->_url = Yii::app()->createAbsoluteUrl($this->_url);
        return $this->_url;
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
                    [
                        'editableAttribute' => 'video_docs', // Editable attribute name
                        'name' => 'videoDocuments',
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
                'langClassName' => ImageLang::className(), // or namespace/for/a/class/PostLang
                'defaultLanguage' => Yii::$app->language,
                'langForeignKey' => 'image_id',
                'tableName' => "{{%tbl_image_lang}}",
                'attributes' => [
                    'title', 'description','btn_link', 'btn_title',
                ]
            ],
        ];
    }



    public function rules()
    {
        return \yii\helpers\ArrayHelper::merge(parent::rules(), [
            [['title', 'description'], 'string'],
            [['title', 'description', 'title_ru', 'description_ru', 'title_en', 'description_en'], 'safe'],
        ]);
    }


    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }


    public function getDocuments()
    {
        return $this->hasMany(DocumentWrapper::className(), ['id' => 'document_id'])
            ->viaTable('tbl_image_to_document', ['image_id' => 'id'])
            ->orderBy('type');
    }

    public function getVideoDocuments()
    {
        return $this->hasMany(DocumentWrapper::className(), ['id' => 'document_id'])
            ->viaTable('tbl_image_video_to_document', ['image_id' => 'id'])
            ->orderBy('type');
    }


    const IMAGE_SIZE1 = 1, IMAGE_SIZE2 = 2, IMAGE_SIZE3 = 3, IMAGE_SIZE_SLIDER = 4;

    public static function getSizeOptions($type)
    {
        $sizes = array(
            self::IMAGE_GALLERY => array(
                self::IMAGE_SIZE1 => Yii::t('app', 'IMAGE_SIZE1'),
//                self::IMAGE_SIZE2 => Yii::t('app', 'IMAGE_SIZE2'),
//                self::IMAGE_SIZE3 => Yii::t('app', 'IMAGE_SIZE3'),
            ),
            self::IMAGE_SLIDER => array(
                self::IMAGE_SIZE_SLIDER => Yii::t('app', 'IMAGE_SIZE_SLIDER'),
            ),
        );

        return $sizes[$type];
    }

    public static function getSizeByType($type)
    {
        $sizes = array(
            self::IMAGE_GALLERY => array(
                self::IMAGE_SIZE1 => array('width' => 480, 'height' => 400,),
//                self::IMAGE_SIZE2 => array('data-width' => 380, 'data-height' => 480),
//                self::IMAGE_SIZE3 => array('data-width' => 760, 'data-height' => 240),
            ),
            self::IMAGE_SLIDER => array(
                self::IMAGE_SIZE_SLIDER => array('width' => 1900, 'height' => 730),
            ),
        );

        if (isset($sizes[$type]))
            return $sizes[$type];
        return null;
    }

    public function getSizeDetail()
    {
        $type = isset($this->type) ? $this->type : self::IMAGE_GALLERY;
        $sizeOptions = $this->getSizeByType($type);
        return isset($sizeOptions[$this->size]) ? $sizeOptions[$this->size] : '';
    }


    const IMAGE_SLIDER = 1, IMAGE_GALLERY = 2, IMAGE_VIDEO = 3;

    public static function getTypeOptions()
    {
        return array(
            self::IMAGE_VIDEO => Yii::t('backend', 'video'),
            self::IMAGE_SLIDER => Yii::t('backend', 'slider'),
            self::IMAGE_GALLERY => Yii::t('backend', 'gallery'),
        );
    }


    public function getTypeText()
    {
        $typeOptions = $this->getTypeOptions();
        return isset($typeOptions[$this->type]) ? $typeOptions[$this->type] : '';
    }


    public function getThumbPathBySize($multiplier = 1)
    {
        $size = $this->getSizeDetail();
        return $this->getThumbPath($size['width'] * $multiplier, $size['height'] * $multiplier, 'auto', false);
    }
}
