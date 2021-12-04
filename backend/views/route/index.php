<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\RouteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Route Wrappers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="route-wrapper-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Route Wrapper'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute' => 'route_no',
                'value' => function ($data) {
                    return 'No: ' . $data->route_no;
                },
                'format' => 'html',
                'options' => ['width' => '80px']
            ],
            [
                'attribute' => 'region',
                'filter' => $searchModel->getRegionOptions(),
                'value' => function ($data) {
                    return $data->getRegionText();
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'from_point_id',
                'filter' => $searchModel->getPointList(),
                'value' => function ($data) {
                    $fromPoint = $data->fromPoint;
                    $toPoint = $data->toPoint;
                    if (isset($fromPoint))
                        return $fromPoint->name;
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'to_point_id',
                'filter' => $searchModel->getPointList(),
                'value' => function ($data) {
                    $toPoint = $data->toPoint;
                    if (isset($toPoint))
                        return $toPoint->name;
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'length',
                'value' => function ($data) {
                    return (float)$data->length . ' km';
                },
                'format' => 'html',
                'options' => ['width' => '120px']
            ],
            [
                'attribute' => 'cycle_min',
                'value' => function ($data) {
                    return $data->cycle_min . ' min';
                },
                'format' => 'html',
                'options' => ['width' => '120px']
            ],
            [
                'attribute' => 'planned_period_min',
                'value' => function ($data) {
                    return $data->planned_period_min . ' min';
                },
                'format' => 'html',
                'options' => ['width' => '120px']
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'options' => ['width' => '120px']
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
