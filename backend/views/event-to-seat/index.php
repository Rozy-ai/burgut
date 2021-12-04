<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\EventToSeatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Event To Seat Wrappers');
$this->params['breadcrumbs'][] = $this->title;
$eventModel = $searchModel->event;
if (isset($eventModel)) {
    $locationModel = $eventModel->location;
    ?>
    <div class="event-to-seat-wrapper-index">

        <h1><?= Html::encode($eventModel->title) ?></h1>
        <h4><i class="fa fa-map-marker"></i> <?= Html::encode($locationModel->title) ?></h4>


        <?php Pjax::begin(['id' => 'pjax-event-to-seat-grid', 'timeout' => 5000]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//            'id',
                [
//                'options' => ['max-width' => '120px'],
                    'contentOptions' => ['style' => 'width:100px; white-space: normal;'],
                    'filter' => \common\models\wrappers\SeatGroupWrapper::getSeatGroupOptoins($eventModel->location_id),
                    'attribute' => 'seat_group_id',
                    'value' => function ($model) {
                        $seatGroup = $model->seatGroup;
                        if (isset($seatGroup))
                            return $seatGroup->name;
                    },
                    'format' => 'html',
                ],


                [
                    'options' => ['max-width' => '120px'],
                    'attribute' => 'seat_name',
                    'value' => function ($model) {
                        $seat = $model->seat;
                        if (isset($seat))
                            return $seat->name;
                    },
                    'format' => 'html',
                ],

//            'event_id',
//            'seat_id',
//            'seat_group_id',
//            'price',
                [
                    'options' => ['max-width' => '120px'],
                    'attribute' => 'ticket_unique_code',
                    'value' => function ($model) {
                        $ticket = $model->ticket;
                        if (isset($ticket) && $ticket->status == \common\models\wrappers\TicketWrapper::STATUS_SUCCESS)
                            return Html::a($ticket->unique_code, \yii\helpers\Url::to(['ticket/view', 'id' => $ticket->id]));
                    },
                    'format' => 'html',
                ],

                [
                    'options' => ['max-width' => '120px'],
                    'filter' => false,
                    'attribute' => 'price',
                    'value' => function ($model) {
                        return $model->price;
                    },
                    'format' => 'html',
                ],
                [
//                'options' => ['max-width' => '80px'],
                    'headerOptions' => ['style' => 'width:180px'],
                    'contentOptions' => ['style' => 'width:180px; white-space: normal;'],
                    'attribute' => 'status',
                    'filter' => \common\models\wrappers\EventToSeatWrapper::getStatusOptions(),
                    'value' => function ($model) {
                        $currentStatus = $model->status;
                        if ($model->isSeatAvailable())
                            $model->status = \common\models\wrappers\EventToSeatWrapper::STATUS_AVAILABLE;
                        return $model->statusText;
                    },
                    'format' => 'html',
                ],
                //'discount',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{occupy} {ticket} ',
                    'buttonOptions' => ['class' => 'btn btn-default'],
                    'header' => Yii::t('app', 'Actions'),
                    'headerOptions' => ['style' => 'width:250px', 'class' => 'activity-view-link',],
//                    'contentOptions' => ['style' => 'text-align:right'],
                    'buttons' => array(
                        'ticket' => function ($url, $model) {
                            if ($model->status != \common\models\wrappers\EventToSeatWrapper::STATUS_AVAILABLE)
                                return;

                            return Html::a('<i class="fa fa-ticket"></i> ' . Yii::t('app', 'Generate Ticket'),
                                \yii\helpers\Url::to(['/ticket/dialog', 'seat_id' => $model->seat_id, 'event_id' => $model->event_id]),
                                [
                                    'title' => '',
                                    'class' => 'btn btn-default',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modalticket',
                                ]
                            );
                        },
                        'occupy' => function ($url, $model) {
                            if ($model->status !== \common\models\wrappers\EventToSeatWrapper::STATUS_BOOKED)
                                return;

                            return Html::a('<i class="fa fa-check"></i>' . Yii::t('app', 'Occupy'), "#", [
                                'class' => 'pjax-occupy-link',
                                'occupy-url' => \yii\helpers\Url::to(['/event-to-seat/occupy', 'id' => $model->id]),
                                'pjax-container' => 'pjax-event-to-seat-grid',
                                'class' => 'btn btn-success',
                                'title' => Yii::t('yii', 'Occupy')
                            ]);
                        }
                    ),
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>


    </div>

<?php } ?>
    <!-- Modal -->
    <div class="modal" id="modalticket" tabindex="-1" role="dialog" aria-labelledby="modalticketLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

<?php
$script = <<< JS
    //message dialog
    $("body").on("beforeSubmit", "form#ticket-form", function () {
        var form = $(this);
        if (form.find(".has-error").length) {
                return false;
        }
        $.ajax({
                url    : form.attr("action"),
                type   : "post",
                data   : form.serialize(),
                success: function (response) {
                        response=$.parseJSON(response);
                        if(response!==undefined){
                          if(response.status=='success'){
                            $.pjax.reload({container: '#pjax-event-to-seat-grid', async: false});
                            $("#modalticket").modal("toggle");
                          }else{
                            window.alert(response.message);
                          }
                        }
                },
                error  : function () {
                        //console.log("internal server error");
                }
        });
        return false;
    });
  
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
?>


<?php
$this->registerJs("
    $(document).on('ready pjax:success', function() {
        $('.pjax-occupy-link').on('click', function(e) {
            e.preventDefault();
            var occupyUrl = $(this).attr('occupy-url');
            var pjaxContainer = $(this).attr('pjax-container');
//            var result = confirm('Delete this item, are you sure?');                                
//            if(result) {
                $.ajax({
                    url: occupyUrl,
                    type: 'post',
                    error: function(xhr, status, error) {
                        alert('There was an error with your request.' + xhr.responseText);
                    }
                }).done(function(data) {
                    $.pjax.reload('#' + $.trim(pjaxContainer), {timeout: 3000});
                });
//            }
        });

    });
");
?>