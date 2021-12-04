<?php
$href = $model->url;
$date = yii::$app->controller->renderDateToWord($model->date_created);
?>

<div class="col-md-12" style="margin-top: 3%;margin-bottom: 3%">
    <div class="blog-one__single">
        <a href="<?=$href?>">
        <div class="blog-one__single-inner-block">
            <div class="blog-one__date"><?=$date?></div><!-- /.blog-one__date -->
            <h3 class="blog-one__title" style="margin-top: 10px">
                <?=$model->title?>
            </h3>
            <p class="blog-one__text"><?=yii::$app->controller->truncate($model->description, 15, 65)?></p>
            <a href="<?=$href?>" class="blog-one__link"><i class="nonid-icon-left-arrow"></i></a>
        </div><!-- /.blog-one__single-inner-block -->
        </a>
    </div>
</div>
