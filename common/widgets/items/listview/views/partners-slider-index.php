<?php
use yii\helpers\Html;

$list = $this->context->list;
$item_class = isset($this->context->item_class) ? $this->context->item_class : 'col-sm-4 col-md-4 col-lg-4 col-xl-4';

if (isset($list) && count($list) > 0) { ?>
<section class="partners_section">
    <div class="container">
        <div class="title_section">
            <h1><?=$this->context->widget_title?></h1>
            <div class="partners_slider_btn"></div>
        </div>
        <div class="partners-slider">
            <?php foreach ($list as $key => $model) {
                $href = $model->url;
                $images = $model->documents;
                foreach ($images as $image){
                ?>
                <div class="partner_slider_block">
                    <div class="partner_slider_img">
                        <?=html::img($image->getThumb(225, 166, 'auto'), ['class' => 'img-responsive'])?>
                    </div>
                </div>
            <?php }} ?>
        </div>
    </div>
</section>

<?php } ?>



<?php

echo $this->registerJS('
    $(\'.partners-slider\').slick({
        dots: false,
        infinite: true,
        initialSlide: 1,
        speed: 300,
        slidesToShow: 5,
        slidesToScroll:1,
        swipeToSlide: true,
        autoplay: false,
        prevArrow: \'<button class="slick-prev" aria-label="Previous" type="button"><i class="fa fa-chevron-left"></i></button>\',
        nextArrow: \'<button class="slick-next" aria-label="Next" type="button"><i class="fa fa-chevron-right"></i></button>\',
        appendArrows:".partners_slider_btn",
         responsive: [
             {
                 breakpoint: 1024,
                 settings: {
                     slidesToShow: 5,
                     slidesToScroll: 1,
                 }
             },
             {
                 breakpoint: 768,
                 settings: {
                     slidesToShow: 3,
                     slidesToScroll: 1
                 }
             },
             {
                 breakpoint: 480,
                 settings: {
                     slidesToShow: 2,
                     slidesToScroll: 1
                 }
             }
         ]
    });
', \yii\web\View::POS_END);

?>