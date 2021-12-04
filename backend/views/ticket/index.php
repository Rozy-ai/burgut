<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ticket Wrappers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-wrapper-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Ticket Wrapper'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'unique_code',
            [
                'attribute' => 'event_id',
                'value' => function ($model) {
                    $event = $model->event;
                    if (isset($event)) {
                        $link_text = $event->getTitle() . " (" . $model->formatDate($event->start_time, 'dd.MM.yyyy H:i') . ')';
                        return Html::a($link_text, \yii\helpers\Url::to(['event/view', 'id' => $event->id]));
                    }
                },
                'format' => 'html',
                'options' => ['max-width' => '80px']
            ],
            [
                'attribute' => 'location',
                'value' => function ($model) {
                    $location = $model->location;
                    if (isset($location)) {
                        return Html::a($location->fullTitle, \yii\helpers\Url::to(['location/view', 'id' => $location->id]));
                    }
                },
                'format' => 'html',
                'options' => ['max-width' => '80px']
            ],
            'firstname',
            'lastname',
            [
                'attribute' => 'email_alerted_date',
                'value' => function ($model) {
                    if (isset($model->email_alerted_date))
                        return $model->formatDate($model->email_alerted_date, 'dd.MM.yyyy H:i');
                },
                'format' => 'html',
                'options' => ['max-width' => '80px']
            ],

            [
                'attribute' => 'payment_id',
                'value' => function ($model) {
                    $payment = $model->payment;
                    if (isset($payment)) {
                        return Html::a($payment->merchant_order_number, \yii\helpers\Url::to(['payment/view', 'id' => $payment->id]));
                    }
                },
                'format' => 'html',
                'options' => ['max-width' => '80px']
            ],

            [
                'attribute' => 'status',
                'filter' => \common\models\wrappers\TicketWrapper::getStatusOptions(),
                'value' => function ($data) {
                    return $data->statusText;
                },
                'format' => 'html',
                'options' => ['max-width' => '80px']
            ],
//            'status',
            //'date_approved',
            //'date_created',
            //'date_modified',
            //'payment_id',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}  {download}  {sendEmail}',
                'options' => ['min-width' => '50px'],
                'header' => Yii::t('app', 'On map'),
                'headerOptions' => ['style' => 'width:50px', 'class' => 'activity-view-link',],
                'contentOptions' => ['style' => 'text-align:right'],
                'buttons' => array(
                    'download' => function ($url, $model) {
                        return Html::a('<i class="fa fa-download"> </i>',
                            $model->getPdfDownloadUrl()
                        );
                    },

                    'sendEmail' => function ($url, $model) {
                        return Html::a('<i class="fa fa-envelope"> </i>',
                            \yii\helpers\Url::to(['/ticket/send-email', 'id' => $model->id])
//                            [
//                                'title' => '',
//                                'data-toggle' => 'modal',
//                                'data-target' => '#modalseat',
//                            ]
                        );
                    },
                ),
            ],
        ],
    ]); ?>


</div>
