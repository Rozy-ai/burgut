<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'source/css/bootstrap.min.css',
        'source/css/bootstrap.min.css.map',
        'source/css/fontawesome.min.css',
        'source/css/animate.css',
        'source/css/slick.css',
        'source/css/slick-theme.css',
        'source/css/style.css',
        'source/css/media.css',
    ];
    public $js = [
       'source/js/jquery.min.js',
       'source/js/bootstrap.bundle.min.js',
       // 'source/js/bootstrap.bundle.min.js.map',
        'source/js/wow.min.js',
        'source/js/slick.min.js',
        'source/js/scripts.js',
    ];
    public $depends = [
        // 'yii\web\JqueryAsset',
        // 'yii\web\YiiAsset',
        // 'frontend\assets\MainAsset',
        // 'yii\bootstrap\BootstrapPluginAsset',
        // 'source/js/jquery.min.js',
    ];
}
