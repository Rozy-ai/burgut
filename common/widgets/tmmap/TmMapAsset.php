<?php
/**
 * Created by PhpStorm.
 * User: batyr
 * Date: 4/4/2019
 * Time: 9:38 PM
 */

namespace common\widgets\tmmap;


use yii\grid\GridView;
use yii\web\AssetBundle;

class TmMapAsset extends AssetBundle {
    public $sourcePath = '@common/widgets/tmmap/assets';
    public $css = ['css/jquery.qtip.min.css','css/interactive_map.css'];
//    public $css = ['css/jquery.qtip.min.css'];
    public $js = ['js/maplight.js', 'js/jquery.qtip.min.js', 'js/interactive_map.js'];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public $publishOptions = [
        'forceCopy' => true,
    ];
}