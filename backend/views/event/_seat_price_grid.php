<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="event-to-seat-wrapper-index">

    <h1><?= Yii::t('app', 'Seat Prices') ?></h1>

    <?php
    if (isset($eventModel) && isset($eventModel->id)) {
        $eventToSeatSearch = new \common\models\search\EventToSeatSearch();
        $eventToSeatSearch->event_id = $eventModel->id;
        $dataProvider = $eventToSeatSearch->searchBySeatGroup([]);

        ?>

        <?php Pjax::begin(['id' => 'pjax-price-grid', 'timeout' => 5000]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
//                'id',
//                'seat_group_id',
                [
                    'options' => ['max-width' => '120px'],
                    'attribute' => 'seat_group_id',
                    'value' => function ($model) {
                        $seatGroup = $model->seatGroup;
                        if (isset($seatGroup))
                            return $seatGroup->name;
                    },
                    'format' => 'html',
                ],
                'price',
                'discount',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{price}',
                    'header' => Yii::t('app', 'On map'),
                    'headerOptions' => ['style' => 'width:15px', 'class' => 'activity-view-link',],
                    'contentOptions' => ['style' => 'text-align:right'],
                    'buttons' => array (
                        'price' => function ($url, $model) {
                            return Html::a('<i class="fa fa-pencil"> </i>',
                                \yii\helpers\Url::to(['/event/seat-price', 'event_id' => $model['event_id'], 'seat_group_id' => $model['seat_group_id']]),
                                [
                                    'title' => '',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modalseatprice',
                                ]
                            );
                        }
                    ),
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    <?php } else {
        echo Yii::t('app', 'You should first create event to set prices');
    } ?>


    <!-- Modal -->
    <div class="modal" id="modalseatprice" tabindex="-1" role="dialog" aria-labelledby="modalseatpriceLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

</div>


<?php
$script = <<< JS
    //message dialog
    $("body").on("beforeSubmit", "form#dynamic-form", function () {
        var form = $(this);
        if (form.find(".has-error").length) {
                return false;
        }
        $.ajax({
                url    : form.attr("action"),
                type   : "post",
                data   : form.serialize(),
                success: function (response) {
                        debugger;
                        response=$.parseJSON(response);
                        if(response!==undefined){
                          if(response.status=='success'){
                            $.pjax.reload({container: '#pjax-price-grid', async: false});
                            $("#modalseatprice").modal("toggle");
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

