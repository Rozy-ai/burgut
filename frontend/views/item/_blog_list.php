<?php
use yii\helpers\Html;

    $href = $model->url;
    $date = yii::$app->controller->renderDateToWord($model->date_created);
    ?>
    <div class="news_cart">
        <div class="news_cart_block">
            <a href="<?= $model->url; ?>">
                <div class="news_cart_img text-center">
                     <img src="<?=$model->getThumbPath()?>" class="img-fluid" alt="">
                </div>
            </a>
            <div class="news_cart_caption">
                <a href="<?= $model->url; ?>"> 
                    <h4><?=$model->title?></h4>
                </a>
                <p><?=$model->description?></p>
                <div class="news_cart_divider"></div>
                <span class="new_date"><?= $date ?></span>
            </div>
        </div>
    </div>


<?php if($index % 4 == 0): ?>
                            <div class="clearfix"></div>
                        <?php endif; ?>