<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'css/bootstrap.min.css',
        'css/font-awesome-4.6.3/css/font-awesome.min.css',
        'css/ionicons.min.css',
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
        'plugins/iCheck/flat/blue.css',

        'plugins/cropperjs/cropper.css',
        'plugins/cropperjs/main.css',

//        'https://unpkg.com/leaflet@1.0.0-rc.3/dist/leaflet.css',
//        'plugins/leaflet-routing-machine/dist/leaflet-routing-machine.css',
        'css/site.css?v=0.01',
    ];


    public $js = [
        'js/jquery-ui.min.js',
         // 'js/bootstrap/bootstrap.min.js',

        'js/raphael-min.js',
        'plugins/sparkline/jquery.sparkline.min.js',
        'plugins/slimscroll/jquery.slimscroll.min.js',
        'plugins/fastclick/fastclick.min.js',
        'plugins/morris/morris.min.js',
        'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        'plugins/knob/jquery.knob.js',
        'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        'plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        'js/app.min.js',

//        'http://maps.google.ru/maps/api/js?key=AIzaSyBDJ1dE9OjJtp33gBzRMad6iasRnAW_4xQ&libraries=places&region=ES',
//        'https://unpkg.com/leaflet@1.0.0-rc.3/dist/leaflet.js',
//        'plugins/leaflet-routing-machine/dist/leaflet-routing-machine.js',
//        'plugins/leaflet-routing-machine/examples/Control.Geocoder.js',
//        'js/leaflet/config.js',
//        'js/leaflet/main.js',

        'js/dashboard.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
