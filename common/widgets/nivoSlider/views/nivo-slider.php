<?php
//$dropZoneName=$this->context->dropzoneName;
//$options=$this->context->options;
//$deleteUrl=\yii\helpers\Url::to([$this->context->deleteUrl]);
//$uploadUrl=\yii\helpers\Url::to([$this->context->uploadUrl]);
//$inputId=$this->context->inputId;
$sliderImages = $this->context->images;


if (isset($sliderImages) && count($sliderImages) > 0) { ?>
    <!-- Main Slider -->
    <div id="mainSlider" class="nivoSlider slider-image">
        <?php foreach ($sliderImages as $key => $image) {
            $path = $image->getThumbPath(1920,900,'auto',true);
            echo \yii\helpers\Html::img($path, ['alt' => 'main slider', 'title' => '#htmlcaption' . $key]);
            ?>
        <?php } ?>
    </div>

    <?php foreach ($sliderImages as $key => $image) { ?>
        <div id="<?php echo 'htmlcaption' . $key; ?>"
             class="nivo-html-caption <?php echo 'slider-caption-' . $key; ?>">

<!--            <div id="htmlcaption" class="nivo-html-caption">-->
<!--                <strong>This</strong> is an example of a <em>HTML</em> caption with <a href="#">a link</a>.-->
<!--            </div>-->

            <div class="slider-progress"></div>
            <div class="slide1-text">
                <div class="top-icon sl-icon">
                    <img src="/img/slider/star-icon.png" alt="">
                </div>
                <div class="middle-text">
                    <div class="cap-title wow bounceInRight" data-wow-duration="1.2s" data-wow-delay="0.2s">
                        <h1><?php echo $image->title; ?></h1>
                    </div>
                    <div class="cap-dec wow bounceInDown" data-wow-duration="0.9s" data-wow-delay="0s">
                        <h3><?php echo $image->description; ?></h3>
                    </div>
                    <div class="bottom-icon sl-icon">
                        <img src="/img/slider/rou.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>


<?php } ?>
