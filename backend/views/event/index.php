<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Event Wrappers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-wrapper-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Event Wrapper'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?php
    //    $locations = \common\models\wrappers\ItemWrapper::find()->where(['code' => 'location'])->all();
    //    $filter_location = [];
    //    foreach ($locations as $loc) {
    //        $filter_location[$loc->id] = $loc->title;
    //    }
    // echo $this->render('_search', ['model' => $searchModel]);
    ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
//            [
//                'options' => ['max-width' => '120px'],
//                'attribute' => 'show_id',
//                'value' => function ($model) {
//                    $contentModel = $model->loadContent();
//                    if (isset($contentModel))
//                        return $contentModel->title;
//                },
//                'format' => 'html',
//            ],
            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'location',
                'value' => function ($model) {
                    $location = $model->location;
                    if (isset($location))
                        return $location->fullTitle;
                },
                'format' => 'html',
            ],

            [
                'options' => ['max-width' => '50px'],
                'attribute' => 'start_time',
                'format' => 'html',
            ],

//            'show_id',
//            'content_item_id',
//            'start_time',
//            'edited_username',
            //'create_username',
            //'date_created',
            //'date_modified',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}  ',
                'buttonOptions' => ['class' => 'btn btn-default'],
                'header' => Yii::t('app', 'Actions'),
                'headerOptions' => ['style' => 'width:190px', 'class' => 'activity-view-link',],
//                'contentOptions' => ['style' => 'text-align:right'],
                'buttons' => array(
                    'seats' => function ($url, $model) {
                        $url = \yii\helpers\Url::to(['event-to-seat/index', 'event_id' => $model->id]);
                        return Html::a('<i class="fa fa-ticket"></i>' . Yii::t('app', 'Seats'), $url, ['class' => 'btn btn-default', 'title' => Yii::t('app', 'Tickets and Seats')]);
                    },
                ),
            ],
        ],
    ]);

    ?>


</div>
