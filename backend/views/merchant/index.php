<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\MerchantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Merchant Wrappers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="merchant-wrapper-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Merchant Wrapper'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'options' => ['width' => '250'],
                'attribute' => 'user_id',
                'filter' => \common\models\wrappers\MerchantWrapper::getUserOptions(),
                'value' => function ($model) {
                    $user = $model->user;
                    if (isset($user)) {
                        return $user->profile->name . " [" . $user->username . "]";
                    }
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'latest_order_number',
                'value' => function ($model) {
                    return $model->latest_order_number;
                },
                'format' => 'html',
                'options' => ['width' => '130']
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->getStatusText();
                },
                'format' => 'html',
                'options' => ['width' => '50']
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'headerOptions' => ['width' => '100px', 'class' => 'activity-view-link',],
                'contentOptions' => ['style' => 'text-align:right'],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
