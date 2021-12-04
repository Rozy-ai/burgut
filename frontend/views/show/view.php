<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ShowWrapper */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Show Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$contentModel = $model->loadContent();
$path = $contentModel->getThumbPath(950, 400, 'w', true);
?>


<div class="page-header">
    <div class="container">
        <h1 class="page-title">
            <?php
            echo Html::encode($contentModel->title);
            ?>
        </h1>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="item-slider">
                <?php
                $items = [];
                $images = $contentModel->documents;
                foreach ($images as $image) {
                    $path = $image->getThumb(600, 400, '', true);
                    $items[] = ['thumbPath' => $path];
                }

                echo \common\widgets\jssorSlider\JssorSliderYii2::widget([
                    'items' => $items,
                    'width' => 600,
                    'height' => 400,
                ]);

                ?>
            </div>
        </div>
        <div class="col-md-4">
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="single-blog">
                <div class="ep-content">
                    <?php echo $contentModel->content; ?>
                </div>
            </div>

        </div>

        <!--        <div class="col-md-4">-->
        <!--            <div class="sidebox">-->
        <!--                --><?php
        //                echo \common\widgets\event\listview\ListWidget::widget([
        //                    'view' => 'sidelist',
        //                    'show_id' => $model->id,
        //                    'limit' => 10
        //                ]);
        //                ?>
        <!--            </div>-->
        <!--        </div>-->
    </div>
</div>
