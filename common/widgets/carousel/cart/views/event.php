<?php
use yii\helpers\Html;

$list = $this->context->list;
$carouselCssClass = uniqid('carousel');
$item_class = isset($this->context->item_class) ? $this->context->item_class : 'col-sm-4 col-md-4 col-lg-4 col-xl-4';
?>
<div class="carousel-box event-carousel">
    <div class="row">
        <div class="col-md-12">
            <?php if (isset($this->context->widget_title)) { ?>
                <h3 class="widget-header pull-left"><?= $this->context->widget_title ?></h3>
            <?php } ?>

            <div class="owlNavigation pull-right visible-xs">
                <a class="btn prev "><i class="fa fa-chevron-left"></i></a>
                <a class="btn next "><i class="fa fa-chevron-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="owlNavigationEvent hidden-xs">
                <a class="prev ">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="60px"
                         height="80px" viewBox="0 0 50 80" xml:space="preserve">
                    <polyline fill="none" stroke="#AAAAAA" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round" points="
                    35.63,75.8 0.375,38.087 35.63,0.375 "></polyline>
                  </svg>
                </a>
                <a class=" next ">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="60px"
                         height="80px" viewBox="0 0 50 80" xml:space="preserve">
                    <polyline fill="none" stroke="#aaaaaa" stroke-width="2" stroke-linecap="round"
                              stroke-linejoin="round"
                              points="0.375,0.375 35.63,38.087 0.375,75.8"></polyline>
                  </svg>
                </a>
            </div>


            <div class="<?= $carouselCssClass ?> ">

                <?php
                if (isset($list) && count($list) > 0) {

                    ?>
                    <?php foreach ($list as $key => $model) {
                        $showModel = $model->show;
                        $href = $showModel->url;
                        $contentModel = $model->loadContent();
                        ?>
                        <div class="">
                            <div class="entry-box">

                                <div class="entry-image">
                                    <?php
                                    $imgsrc = $contentModel->getThumbPath(450, 250);
                                    echo Html::a(Html::img($imgsrc, ['alt' => '', 'class' => 'entry-featured-image-url']), $href);
                                    ?>
                                </div>

                                <div class="entry-content">
                                    <div class="entry-header">
                                        <h6 class="entry-title">
                                            <?= Html::a($contentModel->title, $href) ?>
                                        </h6>
                                    </div>

                                    <div class="entry-desc">
                                        <?php
                                        $location = $showModel->location;
                                        if (isset($location)) {
                                            $desc = Yii::$app->controller->truncate($location->fullTitle, 20, 300);
                                            echo '<i class="fa fa-map-marker"></i> ';
                                            echo $desc;
                                        }
                                        ?>
                                    </div>

                                    <div class="entry-date">
                                        <i class="fa fa-calendar"></i>
                                        <time
                                            datetime="<?php echo Yii::$app->controller->dateToW3C($model->start_time); ?>">
                                            <?php echo Yii::$app->controller->renderDateToWord($model->start_time); ?>
                                        </time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>

            <div class="col-md-12">
                <div class="widget-show-all">
                    <?php if (isset($this->context->show_all_url)) { ?>
                        <a href="<?= $this->context->show_all_url ?>"><?= $this->context->show_all_title ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$this->registerJs('
   var owlEvent=$(".' . $carouselCssClass . '").owlCarousel({
    autoPlay: false,
    slideSpeed: 2000,
    pagination: false,
    navigation: false,
    loop:true,
    items: 3,
    itemsCustom: [
      [0, 1],
      [450, 1],
      [480, 1],
      [600, 2],
      [700, 2],
      [768, 2],
      [992, 3],
      [1199, 3]
    ],
    /* transitionStyle : "fade", */    /* [This code for animation ] */
    navigationText: [""],
  });
  
    $(".event-carousel .next").click(function(){
        owlEvent.trigger(\'owl.next\');
    });
    
  $(".event-carousel .prev").click(function(){
    owlEvent.trigger(\'owl.prev\');
  });
  ', \yii\web\View::POS_READY,
    'calendarPicker'
);
?>
