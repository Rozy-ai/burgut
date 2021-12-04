<?php
/**
 * Created by PhpStorm.
 * User: batyr
 * Date: 4/4/2019
 * Time: 9:38 PM
 */

namespace common\widgets\horizontalCalendar;


use yii\grid\GridView;
use yii\web\AssetBundle;

class HorizontalCalendarAsset extends AssetBundle {
    public $sourcePath = '@common/widgets/horizontalCalendar/assets';
    public $css = ['jquery.calendarPicker.css'];
    public $js = [
        'jquery.calendarPicker.js',
//        'jquery.mousewheel.js'
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