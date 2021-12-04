<?php
use yii\helpers\Html;

$list = $this->context->list;
$carouselCssClass = uniqid('carousel');
$item_class = isset($this->context->item_class) ? $this->context->item_class : 'col-sm-4 col-md-4 col-lg-4 col-xl-4';
?>
<div class="carousel-box" style="display: none">
    <div class="row">
<!--        <div class="col-md-12">-->
<!--            --><?php //if (isset($this->context->widget_title)) { ?>
<!--                <h3 class="widget-header pull-left">--><?//= $this->context->widget_title ?><!--</h3>-->
<!--            --><?php //} ?>
<!--            <div class="owlNavigation pull-right">-->
<!--                <a class="btn prev "><i class="fa fa-chevron-left"></i></a>-->
<!--                <a class="btn next "><i class="fa fa-chevron-right"></i></a>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="--><?//= $carouselCssClass ?><!--">-->
<!--            --><?php
//            if (isset($list) && count($list) > 0) { ?>
<!--                --><?php //foreach ($list as $key => $model) {
//                    $href = $model->url;
//                    ?>
<!--                    <div class="--><?//= $item_class ?><!--">-->
<!--                        <article id="post-34" class="entry-box">-->
<!---->
<!--                            <div class="entry-image">-->
<!--                                --><?php
//                                $imgsrc = $model->getThumbPath(450, 250, null, true);
//                                echo Html::a(Html::img($imgsrc, ['alt' => '', 'class' => 'entry-featured-image-url']), $href);
//                                ?>
<!--                            </div>-->
<!---->
<!--                            <div class="entry-content">-->
<!--                                <div class="entry-header">-->
<!--                                    <h6 class="entry-title">-->
<!--                                        --><?//= Html::a($model->title, $href) ?>
<!--                                    </h6>-->
<!--                                </div>-->
<!---->
<!--                                <div class="entry-desc">-->
<!--                                    --><?php
//                                    $desc = Yii::$app->controller->truncate($model->description, 15, 220);
//                                    echo $desc;
//                                    ?>
<!--                                </div>-->
<!--                            </div>-->
<!--                        </article>-->
<!--                    </div>-->
<!--                --><?php //} ?>
<!--            --><?php //} ?>
<!--        </div>-->
<!---->
<!--        <div class="col-md-12">-->
<!--            <div class="widget-show-all">-->
<!--                --><?php //if (isset($this->context->show_all_url)) { ?>
<!--                    <a href="--><?//= $this->context->show_all_url ?><!--">--><?//= $this->context->show_all_title ?><!--</a>-->
<!--                --><?php //} ?>
<!--            </div>-->
<!--        </div>-->

        <div data-slick='{"slidesToShow": 4, "slidesToScroll": 4}'>
            <div><h3>1</h3></div>
            <div><h3>2</h3></div>
            <div><h3>3</h3></div>
            <div><h3>4</h3></div>
            <div><h3>5</h3></div>
            <div><h3>6</h3></div>
        </div>
    </div>
</div>


<?php
$this->registerJs('
    $(".regular").slick({
                dots: false,
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1
            });
  
  ', \yii\web\View::POS_READY, 'carousel');
?>
