<?php
use yii\helpers\Html;

$list = $this->context->list;
$carouselCssClass = uniqid('competition_carousel');
$item_class = isset($this->context->item_class) ? $this->context->item_class : 'col-sm-4 col-md-4 col-lg-4 col-xl-4';
?>
<div class="competition-carousel-box" style="display: none">
    <div class="row">
        <div class="col-md-12">
            <?php if (isset($this->context->widget_title)) { ?>
                <h3 class="widget-header pull-left"><?= $this->context->widget_title ?></h3>
            <?php } ?>
        </div>

        <!--        <a class="btn competition_prev pull-left"><i class="fa fa-chevron-left"></i></a>-->
        <!--        <a class="btn competition_next pull-right"><i class="fa fa-chevron-right"></i></a>-->

        <div class="<?= $carouselCssClass ?> owl-theme">
            <?php
            if (isset($list) && count($list) > 0) { ?>
                <?php foreach ($list as $key => $model) {
                    $contentModel = $model->loadContent();
                    $season = $model->season;
                    $href = $model->url;
                    ?>
                    <div class="<?= $item_class ?>">
                        <div class="competition-box">
                            <div class="season-header">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php
                                        echo Yii::$app->controller->renderDateToWord($season->start_date) . ' - ' . Yii::$app->controller->renderDateToWord($season->end_date);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="competition-box-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <?php
                                        $imgsrc = $contentModel->getThumbPath(220, 120, 'auto');
                                        echo Html::a(Html::img($imgsrc, ['alt' => '', 'class' => 'entry-featured-image-url']), $href);
                                        ?>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="entry-content">
                                            <div class="entry-header">
                                                <h6 class="entry-title">
                                                    <?= Html::a($contentModel->title, $href) ?>
                                                </h6>
                                            </div>

                                            <div class="entry-links">
                                                <?php
                                                echo Html::a(Yii::t('app', 'News'), \yii\helpers\Url::to(['competition/view', 'id' => $model->id, 'tab' => 'news']));
                                                echo Html::a(Yii::t('app', 'Statistics'), \yii\helpers\Url::to(['competition/view', 'id' => $model->id, 'tab' => 'result']));
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

        <!--        <div class="col-md-12">-->
        <!--            <div class="widget-show-all">-->
        <!--                --><?php //if (isset($this->context->show_all_url)) { ?>
        <!--                    <a href="--><? //= $this->context->show_all_url ?><!--">-->
        <? //= $this->context->show_all_title ?><!--</a>-->
        <!--                --><?php //} ?>
        <!--            </div>-->
        <!--        </div>-->
    </div>
</div>


<?php
$this->registerJs('
    function competition_carousel_init(){
           var owl_competition=$(".' . $carouselCssClass . '").owlCarousel({
                autoPlay: false,
                slideSpeed: 2000,
                loop:true,
//                pagination: false,
//                navigation: false,
                pagination: false,
                navigation: true,
                items: 2,
//                navigationText: [""],
                        navigationText : ["<i class=\'fa fa-chevron-left\'></i>","<i class=\'fa fa-chevron-right\'></i>"]

          });
//          
//          $(".competition_next").click(function(){
//            owl_competition.trigger(\'owl.next\');
//          })
//          $(".competition_prev").click(function(){
//            owl_competition.trigger(\'owl.prev\');
//          })
          
          $(".competition-carousel-box").show(500);
  }
  
  competition_carousel_init();
  
  ', \yii\web\View::POS_READY, 'comp_carousel');
?>
