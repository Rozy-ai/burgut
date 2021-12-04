<?php
use yii\helpers\Html;

$list = $this->context->list;
?>
<div class="partners_title_2">
    <h1 class="mx-auto">Bize ynam bildirenler</h1>
    <div class="partner_slider_btn mx-auto">
    </div>
</div>
<div class="lazy slider h100">
    <div class="partner_slide">
        <?php foreach ($list as $key => $model):?>
        <div class="partner_slider_block">
            <div class="partner_slider_img">
               <?=html::img($model->getThumbPath(),['class' => 'img-responsive'])?>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>


<?php
$this->registerJs('
   $(".lazy").slick({
                dots: false,
                infinite: true,
                slidesToShow: 5,
                slidesToScroll: 1,
                appendArrow: ".partner_slider_btn ", 
            });
  
  ', \yii\web\View::POS_READY, 'lazy');
?>
