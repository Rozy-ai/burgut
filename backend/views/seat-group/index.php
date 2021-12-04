<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SeatGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Seat Group Wrappers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seat-group-wrapper-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Seat Group Wrapper'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'name',
                'value' => function ($model) {
                    return $model->name;
                },
                'format' => 'html',
            ],
            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'location_id',
                'value' => function ($model) {
                    $location = $model->location;
                    if (isset($location))
                        return $location->title;
                },
                'format' => 'html',
            ],
//            'location_id',
//            'parent_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
