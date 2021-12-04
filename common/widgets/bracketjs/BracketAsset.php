<?php
namespace common\widgets\bracketjs;

use yii\grid\GridView;
use yii\web\AssetBundle;

class BracketAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/bracketjs/assets';
    public $css = ['jquery.bracket.min.css'];
    public $js = [
        'jquery.bracket.min.js',
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