<?php
use yii\helpers\Html;

foreach ($items as $key => $data) { ?>
    <!--    <div class="list-item inline-block type-post ">-->
    <div class="list-item col-md-12 type-post most-recent main-title ">
        <?php $title = $data->title; ?>
        <?php
        $path = $data->getThumbPath(120, 100, 'w', true);
        if (isset($path) && strlen(trim($path)) > 1) { ?>
            <div class="responsive pull-left recent-news-thumb">
                <?php echo Html::a(Html::img($path, array ('style' => 'margin-right:15px;', 'alt' => $title)), $data->url, array ('class' => "thumb")); ?>
            </div>
        <?php } ?>


        <div class="item_meta_wrapper">
            <div class="entry-date inline">
                <time
                    datetime="<?php echo Yii::$app->controller->dateToW3C($data->date_created); ?>"> <?php echo Yii::$app->controller->renderDate($data->date_created); ?></time>
            </div>

            <!--            --><?php
            //            $categoryModel = $data->category;
            //            if (isset($categoryModel)) { ?>
            <!--                <div class="item_category inline">-->
            <!--                    --><?php
            //                    echo Html::a($categoryModel->name, $categoryModel->url);
            //                    ?>
            <!--                </div>-->
            <!--            --><?php //} ?>


            <div class="entry-title bold inline">
                <?php
                $title = Yii::$app->controller->truncate($title, 10, 250);
                echo Html::a($title, $data->url, array ('title' => $title, 'rel' => 'bookmark'));
                ?>
            </div>
        </div>

        <div class="entry-description">
            <?php
            $desc = Yii::$app->controller->truncate($data->description, 18, 250);
            echo Html::a($desc, $data->url, array ('title' => $desc, 'rel' => 'bookmark'));
            ?>
        </div>
    </div>
<?php } ?>