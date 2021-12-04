<?php
/**
 * Created by PhpStorm.
 * User: Fujitsu
 * Date: 1.4.2017
 * Time: 9:00 AM
 */

namespace common\widgets\revSlider;
use common\models\wrappers\ImageWrapper;

class RevSliderYii2  extends \yii\base\Widget{
//    public $dropzoneName = 'myDropzone';
//    public $uploadUrl = '/site/upload';
//    public $deleteUrl = '/site/deleteupload';
//    public $mockFiles = [];
    public $cssId = 'main-slider';
    public $images = [];

    public function init() {
        $this->images=ImageWrapper::find()->where(['type'=>ImageWrapper::IMAGE_SLIDER])->all();
        parent::init();
    }


    public function run()
    {
        if(isset($this->images))
            return $this->render('rev-slider');
    }
}