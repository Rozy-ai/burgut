<?php
$list = $this->context->list;
$itemCssClass = uniqid('carousel');
?>


<div class="<?= $itemCssClass ?>">
    <?php
    if (isset($list) && count($list) > 0) { ?>
        <?php foreach ($list as $key => $model) {
            $href = $model->url;
            ?>
            <div class="col-xs-12">
                <div class="single-our-menu">
                    <div class="sm-image">
                        <?php
                        $path = $model->getThumbPath(360, 360);
                        echo \yii\helpers\Html::img($path, ['alt' => '', 'class' => '']);
                        ?>
                        <div class="sm-heading"><a href="<?= $href ?>"><?= $model->title ?></a></div>
                    </div>
                    <div class="sm-content">
                        <div class="sm-des">
                            <?= $model->description ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>


<?php
$this->registerJs('
   $(".' . $itemCssClass . '").owlCarousel({
    autoPlay: false,
    slideSpeed: 2000,
    pagination: false,
    navigation: true,
    items: 2,
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
  });',
    \yii\web\View::POS_END,
    'calendarPicker'
);
?>
