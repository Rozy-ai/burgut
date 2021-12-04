<?php
namespace common\widgets\carousel\cart;

use yii\grid\GridView;
use yii\web\AssetBundle;

class CarouselAsset extends AssetBundle {
    public $sourcePath = '@common/widgets/carousel/cart/assets';
    public $css = ['owl.carousel.css'];
    public $js = [
        'owl.carousel.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $publishOptions = [
        'forceCopy' => true,
    ];
}