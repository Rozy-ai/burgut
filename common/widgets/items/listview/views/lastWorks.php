<?php
use yii\helpers\Html;

$items = $this->context->list;
?>

<div class="widget widget_post">
    <h3 class="sidebar_title"><?=yii::t('app', 'Latest Works')?></h3>
    <?php
    foreach ($items as $key => $data) { ?>
        <?php $date = $data->renderDateToWord($data->date_created);?>
        <div class="media post_item" style="margin-bottom: 10px">
            <?=html::a(html::img($data->getThumbPath(100, 80, 'w'),['height' => 75, 'width' => 100]), $data->url)?>
            <div class="media-body">
                <?= Html::a('<h5>'.$data->title.'</h5>', $data->url) ?>
                <div class="category"><?=$data->category->name?></div>
                <div class="p_date"><img src="/source/img/png/date_icon.png" alt=""><?=$date?></div>
            </div>
        </div>
    <?php } ?>
</div>