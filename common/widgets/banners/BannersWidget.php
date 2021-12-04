<?php
namespace common\widgets\banners;


use common\models\wrappers\BannerTypeWrapper;
use yii\base\Widget;
use Yii;

class BannersWidget extends Widget
{
    public $type;
    public $format_type;
    public $width;
    public $height;
    public $outer_css_class;
    public $outer_css_id;
    public $is_mobile;
    public $ajax = false;


    public function init()
    {
        parent::init();
        if (!isset($this->is_mobile)) {
            $this->is_mobile = false;
        }
        if (!isset($this->outer_css_id))
            $this->outer_css_id = "nivo-slider";
    }


    public function run()
    {
        $bannerTypeModel = BannerTypeWrapper::find()->where(['type_name' => $this->type, 'status' => 1])->one();
        if (isset($bannerTypeModel)) {
            if ((!Yii::$app->mobileDetect->isMobile() && !Yii::$app->mobileDetect->isTablet()) || $this->is_mobile == true || $bannerTypeModel->is_mobile_enabled == true) {
                if ($this->ajax == false) {
                    $banners = $bannerTypeModel->banners;
                    if (count($banners) > 0) {
                        if (!isset($this->width))
                            $this->width = $bannerTypeModel->width;
                        if (!isset($this->height))
                            $this->height = $bannerTypeModel->height;
                    }
                    return $this->render('BannersWidget', array('bannerTypeModel' => $bannerTypeModel, 'banners' => $banners));
                }
            }

//            else {
//                return $this->render('BannersWidget', array('bannerTypeModel' => $bannerTypeModel, 'banners' => $banners));
//            }
        }
    }
}

?>
