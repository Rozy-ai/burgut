<?php
/**
 * Created by PhpStorm.
 * User: Fujitsu
 * Date: 1.4.2017
 * Time: 9:00 AM
 */

namespace common\widgets\gallery;

use common\models\wrappers\ImageWrapper;

class Gallery extends \yii\base\Widget
{
    public $images;
    public $count = 3;

    public function init()
    {
        $this->images = ImageWrapper::find()->where(['type' => [ImageWrapper::IMAGE_GALLERY, ImageWrapper::IMAGE_VIDEO]])->orderBy('id desc')->limit($this->count)->all();
        parent::init();
    }


    public function run()
    {
        if (isset($this->images))
            return $this->render('gallery');
    }
}