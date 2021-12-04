<?php
/**
 * Asset manager for Yii2 Slick widget.
 * 
 * @author Evgeniy Chernishev <EvgeniyRRU@gmail.com>
 */

namespace common\widgets\slick;

use yii\web\AssetBundle;

class SlickAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/slick/assets';

    public $css = [
//        'slick.css',
//        'slick-theme.css',
    ];

    public $js = [
//        'slick.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
} 