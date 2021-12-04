<?php
namespace common\widgets\magnificpopup;

use yii\web\AssetBundle;

class MagnificPopupAsset extends AssetBundle{

    public $sourcePath = '@common/widgets/magnificpopup/assets';
	
    public $css = [
        'magnific-popup.css'
    ];
	
    public $js = [
        'jquery.magnific-popup.min.js'
    ];
	
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}