<?php
/**
 * Created by PhpStorm.
 * User: Fujitsu
 * Date: 1.4.2017
 * Time: 9:00 AM
 */

namespace common\widgets\jssorSlider;

use common\models\wrappers\ImageWrapper;

class JssorSliderYii2 extends \yii\base\Widget {
//    public $dropzoneName = 'myDropzone';
//    public $uploadUrl = '/site/upload';
//    public $deleteUrl = '/site/deleteupload';
//    public $mockFiles = [];
    public $cssId = 'main-slider';
    public $items = [];
    public $width = 600;
    public $height = 400;

    public function init() {
//        if (!isset($this->items) || count($this->items) == 0) {
//            $images = ImageWrapper::find()->where(['type' => ImageWrapper::IMAGE_SLIDER])->all();
//            foreach ($images as $image) {
//                $path = $image->getThumbPath($this->width, $this->height, '', true);
//                $this->items[] = ['thumbPath' => $path, 'title' => $image->title, 'description' => $image->description];
//            }
//        }

        $view = $this->getView();
        JssorAsset::register($view);
        parent::init();
    }


    public function run() {
        if (isset($this->items))
            return $this->render('jssor-slider');
    }
}