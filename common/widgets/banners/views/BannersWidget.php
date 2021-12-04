<!--noindex-->
<!--<div class="banner">-->
<?php
use common\models\wrappers\BannerTypeWrapper;

if ($this->context->ajax == true) {
    echo '<div id="banner_wrapper' . $this->outer_css_id . '"></div>';
    Yii::$app->clientScript->registerScript("bannerWidgetWrapper",
        'function bannerWidget(){' .
        CHtml::ajax(
            array(
                'url' => array("//widgets/partial"),
                'dataType' => 'html',
                'type' => 'POST',
                'update' => '#banner_wrapper' . $this->outer_css_id,
                'data' => array(
                    "widget" => 'application.widgets.banners.BannersWidget',
                    'type' => $this->type,
                    'outer_css_class' => $this->outer_css_class,
                    'outer_css_id' => $this->outer_css_id,
                )
            )
        ) . ' 
            }
                
            timer = setTimeout("bannerWidget()", 1000);',
        CClientScript::POS_END);
} else {

    switch ($bannerTypeModel->type) {
        case BannerTypeWrapper::TYPE_FLASH:
            echo $this->render('flash', array('bannerModel' => $banners[0]));
            break;
        case BannerTypeWrapper::TYPE_ADSENSE:
            $is_mobile = Yii::app()->controller->isMobile();
            $bannerModel = null;
            foreach ($banners as $banner) {
                if ($is_mobile == true && $banner->format_type == Banner::FORMAT_TYPE_MOBILE) {
                    $bannerModel = $banner;
                    break;
                } elseif ($is_mobile == false && $banner->format_type == Banner::FORMAT_TYPE_DESKTOP) {
                    $bannerModel = $banner;
                    break;
                }
            }

            if (isset($bannerModel))
                echo $this->render('adsense', array('bannerModel' => $bannerModel));
            break;
        case BannerTypeWrapper::TYPE_IMAGE:
            echo $this->render('image', array('bannerModel' => $banners[0]));
            break;
        case BannerTypeWrapper::TYPE_IMAGE_RANDOM:
            echo $this->render('image', array('bannerModel' => $banners[array_rand($banners)]));
            break;
        case BannerTypeWrapper::TYPE_IMAGE_SLIDER:
            echo $this->render('slider', array('banners' => $banners, 'bannerTypeModel' => $bannerTypeModel));
            break;
    }
} ?>
<!--</div>-->
<!--/noindex-->
