<?php
namespace common\models\wrappers;

use common\models\BannerType;
use Yii;


class BannerTypeWrapper extends BannerType {

    public $bannersTitle;
    public $size;
    const TYPE_IMAGE = 0, TYPE_FLASH = 1, TYPE_IMAGE_RANDOM = 2, TYPE_IMAGE_SLIDER = 3, TYPE_ADSENSE = 4;

    public function getTypeOptions() {
        return array(
            self::TYPE_IMAGE => Yii::t('app', 'TYPE_IMAGE_STATIC'),
            self::TYPE_ADSENSE => Yii::t('app', 'TYPE_ADSENSE'),
            self::TYPE_IMAGE_RANDOM => Yii::t('app', 'TYPE_IMAGE_RANDOM'),
            self::TYPE_FLASH => Yii::t('app', 'TYPE_FLASH'),
            self::TYPE_IMAGE_SLIDER => Yii::t('app', 'TYPE_IMAGE_SLIDER'),
        );
    }

    public function getTypeText() {
        $typeOptions = $this->typeOptions;
        return isset($typeOptions[$this->type]) ? $typeOptions[$this->type] : Yii::t('app', '$TYPE_UNKNOWN');
    }


    const  BOOL_NO = 0, BOOL_YES = 1;

    public function getBoolOptions() {
        return array(
            self::BOOL_NO => Yii::t('app', 'BOOL_NO'),
            self::BOOL_YES => Yii::t('app', 'BOOL_YES'),
        );
    }

//    public function relations() {
//        // NOTE: you may need to adjust the relation name and the related
//        // class name for the relations automatically generated below.
//        return array(
//            'banners' => array(self::HAS_MANY, 'Banner', 'type'),
//        );
//    }

    public function getBanners() {
        return $this->hasMany(BannerWrapper::className(), ['type' => 'id']);
    }


    public function getBannersTitle() {
        $banners = $this->banners;
        $this->bannersTitle = "";
        if (isset($banners)) {
            foreach ($banners as $banner) {
                $this->bannersTitle .= " " . $banner->description . ', ';
            }
        }
        return trim($this->bannersTitle, ",");
    }


    public function getSize() {
        if (isset($this->width) && isset($this->height))
            return $this->width . " x " . $this->height;
        return "";
    }
}
