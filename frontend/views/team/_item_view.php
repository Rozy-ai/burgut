<?php
use yii\helpers\Html;

$href = $model->url;
$author = (isset($model->author) && strlen(trim($model->author)) > 0) ? $model->author : $model->create_username;

//$path = $model->getThumbPath(365, 215, '', true, false, true);
?>


<div class="col-sm-12">
    <article class="entry-list">
        <div class="row">
            <div class="col-md-12">
                <div class="item_meta_wrapper">

                    <?php
                    $imgsrc = $model->getThumbPath(170, 100);

                    if (isset($imgsrc) && $imgsrc != "") {
                        ?>
                        <div class="entry-image responsive pull-left">
                            <?php

                            echo Html::a(Html::img($imgsrc, ['alt' => '', 'class' => 'entry-featured-image-url']), $href);
                            ?>
                        </div>
                        <?php
                    }
                    ?>


                    <div class="entry-title bold ">
                        <?php
                        $title = Yii::$app->controller->truncate($model->title, 10, 250);
                        echo Html::a($title, $model->url, array('title' => $title, 'rel' => 'bookmark'));
                        ?>
                    </div>
                </div>

                <div class="entry-description">
                    <?php
                    $desc = Yii::$app->controller->truncate($model->description, 18, 250);
                    echo Html::a($desc, $model->url, array('title' => $desc, 'rel' => 'bookmark'));
                    ?>
                </div>
            </div>
        </div>
    </article>
</div>
