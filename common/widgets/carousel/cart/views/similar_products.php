<?php
use yii\helpers\Html;

$list = $this->context->list;
$carouselCssClass = uniqid('carousel');
$item_class = isset($this->context->item_class) ? $this->context->item_class : 'col-sm-4 col-md-4 col-lg-4 col-xl-4';
?>
<div class="carousel-box" style="display: none">
    <div class="row">
        <div class="<?= $carouselCssClass ?>">
            <?php
            if (isset($list) && count($list) > 0) { ?>
                <?php foreach ($list as $key => $model) {
                    $href = $model->url;
                    ?>
                    <div class="<?= $item_class ?>">
                        <article id="post-34" class="entry-box">
                            <div class="articleBox">
                                <div class="article-image-viewer withoverlay">
                                    <a href="<?=$href?>" tabindex="-1">
                                        <?php
                                        $imgsrc = $model->getThumbPath(266, 266, null, true);
                                        echo Html::a(Html::img($imgsrc, ['alt' => '', 'class' => 'product-image img-responsive']), $href);
                                        ?>
                                        <a href="<?=$href?>">
                                            <div class="image-overlay">
                                                <div class="product-title">
                                                    <?=$model->title ?>
                                                </div>
                                            </div>
                                        </a>
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>


<?php
$this->registerJs('
    function init(){
           var owl=$(".' . $carouselCssClass . '").owlCarousel({
                autoPlay: true,
                slideSpeed: 2000,
                loop:true,
                pagination: false,
                navigation: false,
                items: 4,
                navigationText: [""],
          });
          
          $(".next").click(function(){
            owl.trigger(\'owl.next\');
          })
          $(".prev").click(function(){
            owl.trigger(\'owl.prev\');
          })
          
          $(".carousel-box").show(500);
  }
  
  init();
  
  ', \yii\web\View::POS_READY, 'carousel');
?>
