<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="event-to-seat-wrapper-index">

    <h1><?= Yii::t('app', 'Event Teams') ?></h1>

    <?php
    if (isset($eventModel) && isset($eventModel->id)) {
        echo Html::a('<i class="fa fa-chair"> </i> Add Team',
            \yii\helpers\Url::to(['/event-to-team/dialog', 'event_id' => $eventModel->id]),
            [
                'title' => '',
                'class' => 'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#modaleventteam',
            ]
        );


        $eventToTeamSearch = new \common\models\search\EventToTeamSearch();
        $eventToTeamSearch->event_id = $eventModel->id;
        $dataProvider = $eventToTeamSearch->search([]);
        ?>

        <?php Pjax::begin(['id' => 'pjax-event-to-team-grid', 'timeout' => 5000]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
//                'id',
                [
                    'attribute' => 'team_id',
                    'value' => function ($model, $key, $index, $widget) {
                        return $model->team->name;
                    },
                ],
                'score_for',
                'score_against',
                'point',
                'result_state',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{eventteam} {delete}',
                    'header' => Yii::t('app', 'On map'),
                    'headerOptions' => ['style' => 'width:15px', 'class' => 'activity-view-link',],
                    'contentOptions' => ['style' => 'text-align:right'],
                    'buttons' => array (
                        'eventteam' => function ($url, $model) {
                            return Html::a('<i class="fa fa-pencil"> </i>',
                                \yii\helpers\Url::to(['/event-to-team/dialog', 'id' => $model['id']]),
                                [
                                    'title' => '',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modaleventteam',
                                ]
                            );
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', [
                                'class' => 'pjax-delete-link',
                                'delete-url' => \yii\helpers\Url::to(['/event-to-team/delete', 'id' => $model->id]),
                                'pjax-container' => 'pjax-event-to-team-grid',
                                'title' => Yii::t('yii', 'Delete')
                            ]);
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
    <div class="modal" id="modaleventteam" role="dialog" aria-labelledby="modaleventteamLabel"
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
    $("body").on("beforeSubmit", "form#event-to-team-form", function () {
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
                            $.pjax.reload({container: '#pjax-event-to-team-grid', async: false});
                            $("#modaleventteam").modal("toggle");
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

