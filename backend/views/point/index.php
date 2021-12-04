<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PointSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Point Wrappers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="point-wrapper-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Point Wrapper'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            'id',
            [
                'attribute' => 'name',
                'value' => function ($data) {
                    return $data->name;
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'description',
                'value' => function ($data) {
                    return $data->description;
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'code',
                'value' => function ($data) {
                    return $data->code;
                },
                'format' => 'html',
                'options' => ['width' => '120px']
            ],
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    return $data->status;
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
