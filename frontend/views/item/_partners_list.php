<?php
use yii\helpers\Html;

    $href = $model->url;
    $date = yii::$app->controller->renderDateToWord($model->date_created);
    ?>
    <div class="news_cart">
        <div class="news_cart_block">
          
                <div class="news_cart_img text-center">
                     <img src="<?=$model->getThumbPath()?>" class="img-fluid" alt="">
                </div>
           
            <div class="news_cart_caption_partners">
              
                    <h4><?=$model->title?></h4>
              
              <!--   <div class="news_cart_divider"></div>
                <span class="new_date"><?= $date ?></span> -->
            </div>
        </div>
    </div>


<?php if($index % 4 == 0): ?>
                            <div class="clearfix"></div>
                        <?php endif; ?>