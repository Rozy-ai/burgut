<?php

    $href = $model->url;
    $date = yii::$app->controller->renderDateToWord($model->date_created);
    ?>

<div class="col-md-4 col-sm-6">
    <div class="blog-one__single">
        <div class="blog-one__single-inner-block">
            <div class="blog-one__date"><?=$date?></div><!-- /.blog-one__date -->
            <a href="<?=$href?>" class="blog-one__author">By layerdrops</a>
            <h3 class="blog-one__title">
                <a href="<?=$href?>"><?=$model->name?></a>
            </h3>
            <p class="blog-one__text"><?=yii::$app->controller->truncate($model->description, 15, 65)?></p>
            <a href="<?=$href?>" class="blog-one__link"><i class="nonid-icon-left-arrow"></i></a>
        </div><!-- /.blog-one__single-inner-block -->
    </div>
</div>
