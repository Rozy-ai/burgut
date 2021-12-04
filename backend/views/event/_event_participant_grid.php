<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="event-to-seat-wrapper-index">

    <h1><?= Yii::t('app', 'Event Participants') ?></h1>

    <?php
    if (isset($eventModel) && isset($eventModel->id)) {
        echo Html::a('<i class="fa fa-chair"> </i> Add Athlete',
            \yii\helpers\Url::to(['/event-to-participant/dialog', 'event_id' => $eventModel->id, 'type' => \common\models\wrappers\EventToParticipantWrapper::PARTICIPANT_TYPE_ATHLETE]),
            [
                'title' => '',
                'class' => 'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#modaleventparticipant',
            ]
        );

        echo Html::a('<i class="fa fa-chair"> </i> Add Coach',
            \yii\helpers\Url::to(['/event-to-participant/dialog', 'event_id' => $eventModel->id, 'type' => \common\models\wrappers\EventToParticipantWrapper::PARTICIPANT_TYPE_COACH]),
            [
                'title' => '',
                'class' => 'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#modaleventparticipant',
            ]
        );

        echo Html::a('<i class="fa fa-chair"> </i> Add Judge',
            \yii\helpers\Url::to(['/event-to-participant/dialog', 'event_id' => $eventModel->id, 'type' => \common\models\wrappers\EventToParticipantWrapper::PARTICIPANT_TYPE_JUDGE]),
            [
                'title' => '',
                'class' => 'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#modaleventparticipant',
            ]
        );


        $eventToParticipantSearch = new \common\models\search\EventToParticipantSearch();
        $eventToParticipantSearch->event_id = $eventModel->id;
        $dataProvider = $eventToParticipantSearch->search([]);
        $dataProvider->setSort([
            'defaultOrder' => [
                'team_id' => SORT_DESC,
                'type' => SORT_DESC,
            ]
        ]);
        ?>

        <?php Pjax::begin(['id' => 'pjax-event-to-participant-grid', 'timeout' => 5000]); ?>
        <?= \kartik\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $eventToParticipantSearch,
            'pjax' => false,
            'striped' => true,
            'hover' => true,
//            'panel' => ['type' => 'primary', 'heading' => 'Grid Grouping Example'],
            'toggleDataContainer' => ['class' => 'btn-group mr-2'],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'attribute' => 'team_id',
                    'width' => '310px',
                    'value' => function ($model, $key, $index, $widget) {
                        return $model->team->name;
                    },
                    'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                    'filter' => $eventToParticipantSearch->getRelatedTeamList(),
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Any team'],
                    'group' => true,  // enable grouping
                    'groupedRow' => true,                    // move grouped column to a single grouped row
                    'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                    'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                ],
                [
                    'attribute' => 'type',
                    'width' => '50px',
                    'value' => function ($model, $key, $index, $widget) {
                        return $model->getTypeText();
                    },
                    'group' => true,  // enable grouping
                    'subGroupOf' => 1 // supplier column index is the parent group
                ],
                [
                    'attribute' => 'participant_id',
                    'width' => '310px',
                    'value' => function ($model, $key, $index, $widget) {
                        return $model->participant->fullName;
                    },
//                    'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
//                    'filter' => $eventToParticipantSearch->getRelatedTeamList(),
//                    'filterWidgetOptions' => [
//                        'pluginOptions' => ['allowClear' => true],
//                    ],
//                    'filterInputOptions' => ['placeholder' => 'Any team'],
                ],
//                'team_id',
                'score_for',
                'score_against',
                'point',
                'result_state',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{participant} {delete}',
                    'header' => Yii::t('app', 'Participant Edit'),
                    'headerOptions' => ['style' => 'width:15px', 'class' => 'activity-view-link',],
                    'contentOptions' => ['style' => 'text-align:right'],
                    'buttons' => array (
                        'participant' => function ($url, $model) {
                            return Html::a('<i class="fa fa-pencil"> </i>',
                                \yii\helpers\Url::to(['/event-to-participant/dialog', 'id' => $model['id'], 'type' => $model['type']]),
                                [
                                    'title' => '',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modaleventparticipant',
                                ]
                            );
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', false, [
                                'class' => 'pjax-delete-link',
                                'delete-url' => \yii\helpers\Url::to(['/event-to-participant/delete', 'id' => $model->id]),
                                'pjax-container' => 'pjax-event-to-participant-grid',
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
    <div class="modal" id="modaleventparticipant" tabindex="-1" role="dialog"
         aria-labelledby="modaleventparticipantLabel"
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
    $("body").on("beforeSubmit", "form#event-to-participant-form", function () {
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
                            $.pjax.reload({container: '#pjax-event-to-participant-grid', async: false});
                            $("#modaleventparticipant").modal("toggle");
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

