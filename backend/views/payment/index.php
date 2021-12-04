<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Payment Wrappers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-wrapper-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Payment Wrapper'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            [
//                'options' => ['width' => '120'],
//                'attribute' => 'merchant_id',
//                'filter' => \common\models\wrappers\PaymentWrapper::getMerchantOptions(),
//                'value' => function ($model) {
//                    $merchant = $model->merchant;
//                    if (isset($merchant)) {
//                        return $merchant->name;
//                    }
//                },
//                'format' => 'html',
//            ],
            'description:ntext',
            'merchant_order_number',
//            'merchant_success_url:ntext',
//            'merchant_failure_url:ntext',
            'submitted_order_number',
            'response_order_id',
            // 'response_form_url:ntext',
            [
                'attribute' => 'response_error_code',
                'filter' => \common\models\wrappers\PaymentWrapper::getResponseErrorCodeOptions(),
                'value' => function ($model) {
                    return $model->getErrorCodeText();
                },
                'format' => 'html',
                'options' => ['width' => '50']
            ],
            [
                'attribute' => 'amount',
                'value' => function ($model) {
                    return ((float)$model->amount/100) . ' TMT';
                },
                'format' => 'html',
                'options' => ['width' => '100']
            ],
            [
                'attribute' => 'status',
                'filter' => \common\models\wrappers\PaymentWrapper::getStatusOptions(),
                'value' => function ($model) {
                    return $model->getStatusText();
                },
                'format' => 'html',
                'options' => ['width' => '50']
            ],
            "date_created",
            "date_merchant_alerted",
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'headerOptions' => ['width' => '60px', 'class' => 'activity-view-link',],
                'contentOptions' => ['style' => 'text-align:right'],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
