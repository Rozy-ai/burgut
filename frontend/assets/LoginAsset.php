<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main frontend application asset bundle.
 */
class LoginAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';


    public $css = [
        // 'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all',
        // 'source/global/plugins/font-awesome/css/font-awesome.min.css',
        // 'source/global/plugins/simple-line-icons/simple-line-icons.min.css',
        // 'source/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css',
        // 'source/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css',
//        'source/global/plugins/morris/morris.css',
//        'source/global/plugins/fullcalendar/fullcalendar.min.css',
        // 'source/global/css/components-md.min.css',
        // 'source/global/css/plugins-md.min.css',
        // 'source/layouts/layout/css/layout.css',
        // 'source/layouts/layout/css/themes/darkblue.min.css',
        // 'source/layouts/layout/css/custom.css?v=1.1',
        // 'source/pages/css/login-3.min.css',
        // 'source/css/opensans.css',
        'source/css/fontawesome.min.css',
        'source/css/forlayout.css',
    ];

    public $js = [
//        'source/global/plugins/morris/morris.min.js',
//        'source/global/plugins/morris/raphael-min.js',


//        'source/global/scripts/app.js',
        // 'source/global/scripts/custom.js',
//        'source/layouts/layout/scripts/layout.min.js',
//        'source/layouts/layout/scripts/demo.min.js',
//        'source/layouts/global/scripts/quick-sidebar.min.js',
        // 'source/js/forlayout.js',
    ];


    public $jsOptions = [
        'position' => View::POS_END
    ];

    public $depends = [
        // 'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
//        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
