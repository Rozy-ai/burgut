<?php
/**
 * Created by PhpStorm.
 * User: batyr
 * Date: 4/4/2019
 * Time: 9:38 PM
 */

namespace common\widgets\jssorSlider;


use yii\grid\GridView;
use yii\web\AssetBundle;

class JssorAsset extends AssetBundle {
    public $sourcePath = '@common/widgets/jssorSlider/assets';
//    public $css = ['main.css'];
    public $js = ['js/jssor.slider.min.js'];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public $publishOptions = [
        'forceCopy' => true,
    ];
}