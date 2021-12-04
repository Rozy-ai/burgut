<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ItemWrapper */

$this->title = $model->title;
$categoryModel = $model->category;
if (isset($categoryModel) && $categoryModel->top == true) {
    $this->params['breadcrumbs'] = $categoryModel->getBreadcrumbs(true);
}
$this->params['breadcrumbs'][] = Yii::$app->controller->truncate($model->title, 8, 65);


$href = $model->url;
$author = (isset($model->author) && strlen(trim($model->author)) > 0) ? $model->author : $model->create_username;
$date = $model->renderDateToWord($model->date_created);

$path = $model->getThumbPath(950, 400, 'w', true);
?>
<!-- product-details-area are start-->

<!--<div class="page-header">-->
<!--    <div class="container">-->
<!--        <h1 class="page-title">-->
<!--            --><?php
//            echo Html::encode($model->title);
//            ?>
<!--        </h1>-->
<!--    </div>-->
<!--</div>-->


<div class="container">
    <div class="row">
        <div class="ep-content">
            <div class="col-md-5">
                <div class="item-slider">
                    <?php
                    $items = [];
                    $images = $model->documents;
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
            <div class="col-md-7">
                <h1 class="page-title">
                    <?php
                    echo Html::encode($model->title);
                    ?>
                </h1>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="location-content">
                <?php

                $showSearch = new \common\models\search\ShowSearch();
                $showSearch->location_id = $model->id;
                $showDp = $showSearch->search([]);

                echo \yii\bootstrap\Tabs::widget([
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Events'),
                            'content' => \common\widgets\event\listview\ListWidget::widget([
                                'view' => 'grid',
                                'limit' => 8,
                                'location_id' => $model->id,
                                'show_all_url' => \yii\helpers\Url::to('item/events'),
                                'show_all_title' => Yii::t('app', 'Show detailed info about events')
                            ]),
                        ],
                        [
                            'label' => Yii::t('app', 'Shows'),
                            'content' => \common\widgets\show\listview\ListWidget::widget([
                                'view' => 'overview',
                                'limit' => 8,
                                'location_id' => $model->id,
                                'show_all_url' => \yii\helpers\Url::to('item/events'),
                                'show_all_title' => Yii::t('app', 'Show detailed info about shows')
                            ]),
                        ],
                        [
                            'label' => Yii::t('app', 'Theatre detail'),
                            'content' => $this->render('_tab_description', ['model' => $model])
                        ]
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
<!--    <div class="row">-->
<!--        <div class="col-md-12">-->
<!--            <div class="related-blogs">-->
<!--                --><?php
//                echo \common\widgets\items\listview\ListWidget::widget([
//                    'category' => $categoryModel->code,
//                    'view' => 'related',
//                    'limit' => 3,
//                    'widget_title' => Yii::t('app', 'Related')
//                ]); ?>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</div>
