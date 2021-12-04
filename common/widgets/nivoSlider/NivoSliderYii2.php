<?php
/**
 * Created by PhpStorm.
 * User: Fujitsu
 * Date: 1.4.2017
 * Time: 9:00 AM
 */

namespace common\widgets\nivoSlider;
use common\models\wrappers\ImageWrapper;

class NivoSliderYii2  extends \yii\base\Widget{
//    public $dropzoneName = 'myDropzone';
//    public $uploadUrl = '/site/upload';
//    public $deleteUrl = '/site/deleteupload';
//    public $mockFiles = [];
//    public $inputId = 'fileupload3';
    public $images = [];

    public function init() {
        $this->images=ImageWrapper::find()->where(['type'=>ImageWrapper::IMAGE_SLIDER])->all();
        parent::init();
    }


    public function run()
    {
        if(isset($this->images))
            return $this->render('nivo-slider');
    }
}