<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ShowSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Show Wrappers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="show-wrapper-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Show Wrapper'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    $locationCategory = \common\models\wrappers\CategoryWrapper::find()->where(['code' => 'location'])->one();
    $locations = \common\models\wrappers\ItemWrapper::find()->where(['category_id' => $locationCategory->id])->all();
    $filter_location = [];
    foreach ($locations as $loc) {
        $filter_location[$loc->id] = $loc->title;
    }
    // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'content_item_id',
                'value' => function ($model) {
                    $contentModel = $model->loadContent();
                    if (isset($contentModel))
                        return $contentModel->title;
                },
                'format' => 'html',
            ],
            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'location_id',
                'filter' => $filter_location,
                'value' => function ($model) {
                    $location = $model->location;
                    if (isset($location))
                        return $location->title;
                },
                'format' => 'html',
            ],

            [
                'options' => ['max-width' => '50px'],
                'attribute' => 'duration_min',
                'format' => 'html',
            ],


            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete} {crop}',
                'headerOptions' => ['width' => '100px', 'class' => 'activity-view-link',],
                'contentOptions' => ['style' => 'text-align:right'],
                'buttons' => array (
                    'crop' => function ($url, $showModel, $key) {
                        $model = $showModel->loadContent();
                        if (isset($model)) {
                            $sizes = $model->getSizeByType($model->type);
                            $returnUrl = \yii\helpers\Url::toRoute(['/item/index', 'type' => $model->type]);
                            if (isset($sizes) && is_array($sizes)) {
                                $sizes = serialize($sizes);
                            }

                            $documents = $model->documents;
                            if (isset($documents) && count($documents) > 0) {
                                return Html::a('<span class="fa fa-crop"></span>', \yii\helpers\Url::toRoute(['/document/crop', 'id' => $documents[0]->id, 'ratios' => $sizes, 'returnUrl' => $returnUrl]), [
                                    'title' => Yii::t('yii', 'Crop'),
                                ]);
                            }
                        }
                        return false;
                    },
                ),
                'options' => ['width' => '120'],
            ],
        ],
    ]); ?>


</div>
