<?php
namespace common\models\wrappers;
use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
use common\models\Banner;
use Yii;


/**
 * This is the model class for table "tbl_banner".
 *
 * The followings are the available columns in table 'tbl_banner':
 * @property integer $id
 * @property integer $format_type
 * @property string $description
 * @property string $adsense_code
 * @property integer $width
 * @property integer $height
 * @property integer $type
 * @property integer $url
 */
class BannerWrapper extends Banner {
    public $docs = [];
    public $_image;

    public $exceptions = array();
    const FORMAT_TYPE_DESKTOP = 0, FORMAT_TYPE_MOBILE = 1;

    public function getFormatTypeOptions() {
        return array(
            self::FORMAT_TYPE_DESKTOP => Yii::t('backend', 'FORMAT_TYPE_DESKTOP'),
            self::FORMAT_TYPE_MOBILE => Yii::t('backend', 'FORMAT_TYPE_MOBILE'),
        );
    }

    public function getFormatTypeText() {
        $formatTypeOptions = $this->formatTypeOptions;
        return isset($formatTypeOptions[$this->format_type]) ? $formatTypeOptions[$this->format_type] : Yii::t('app', '$FORMAT_TYPE_UNKNOWN');
    }

//
//    public function relations() {
//        // NOTE: you may need to adjust the relation name and the related
//        // class name for the relations automatically generated below.
//        return array(
//            'documents' => array(self::MANY_MANY, 'Documents', 'tbl_banner_to_documents(banner_id,documents_id)'),
//            'banner_type' => array(self::BELONGS_TO, 'BannerType', 'type'),
//        );
//    }


    public function behaviors() {
        return [
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
//                    [
//                        'editableAttribute' => 'docs', // Editable attribute name
//                        'table' => 'tbl_music_to_document', // Name of the junction table
//                        'ownAttribute' => 'music_id', // Name of the column in junction table that represents current model
//                        'relatedModel' => Document::className(), // Related model class
//                        'relatedAttribute' => 'document_id', // Name of the column in junction table that represents related model
//                    ],
                    [
                        'editableAttribute' => 'docs', // Editable attribute name
                        'name' => 'documents',
                    ],
                ],
            ],
        ];
    }


    public function getDocuments() {
        return $this->hasMany(DocumentWrapper::className(), ['id' => 'document_id'])
            ->viaTable('tbl_banner_to_document', ['banner_id' => 'id'])
            ->orderBy('type');
    }


//
//    /**
//     * @return array customized attribute labels (name=>label)
//     */
//    public function attributeLabels() {
//        return array(
//            'id' => Yii::t('app', 'id'),
//            'format_type' => Yii::t('app', 'format_type'),
//            'description' => Yii::t('app', 'description'),
//            'adsense_code' => Yii::t('app', 'adsense_code'),
//            'width' => Yii::t('app', 'width'),
//            'height' => Yii::t('app', 'height'),
//            'type' => Yii::t('app', 'type'),
//            'url' => Yii::t('app', 'url'),
//            'edited_username' => Yii::t('app', 'edited_username'),
//            'create_username' => Yii::t('app', 'create_username'),
//            'date_added' => Yii::t('app', 'date_added'),
//            'date_modified' => Yii::t('app', 'date_modified'),
//        );
//    }
//
//
//    public function search() {
//        // @todo Please modify the following code to remove attributes that should not be searched.
//
//        $criteria = new CDbCriteria;
//
//        $criteria->compare('id', $this->id);
//        $criteria->compare('format_type', $this->format_type);
//        $criteria->compare('description', $this->description, true);
//        $criteria->compare('adsense_code', $this->adsense_code, true);
//        $criteria->compare('width', $this->width);
//        $criteria->compare('height', $this->height);
//        $criteria->compare('type', $this->type);
//        $criteria->compare('url', $this->url);
//
//        if (count($this->exceptions) > 0)
//            $criteria->addNotInCondition('id', $this->exceptions);
//
//        return new CActiveDataProvider($this, array(
//            'criteria' => $criteria,
//        ));
//    }

//
//    public function getThumbPath($width = null, $height = null, $type = '', $is_cropped = false, $with_watermark = true, $with_no_image = true) {
//        $bannerType = $this->banner_type;
//        if (isset($bannerType) && $bannerType->type != BannerType::TYPE_FLASH)
//            return parent::getThumbPath($width, $height, $type, $is_cropped, $with_watermark, $with_no_image);
//    }
}
