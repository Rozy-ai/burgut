<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="team-to-seat-wrapper-index">

    <h1><?= Yii::t('app', 'Team Participants') ?></h1>

    <?php
    if (isset($model) && isset($model->id)) {
        echo Html::a('<i class="fa fa-chair"> </i> Add Athlete',
            \yii\helpers\Url::to(['/team-to-participant/dialog', 'team_id' => $model->id, 'type' => \common\models\wrappers\TeamToParticipantWrapper::PARTICIPANT_TYPE_ATHLETE]),
            [
                'title' => '',
                'class' => 'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#modalteamparticipant',
            ]
        );

        echo Html::a('<i class="fa fa-chair"> </i> Add Coach',
            \yii\helpers\Url::to(['/team-to-participant/dialog', 'team_id' => $model->id, 'type' => \common\models\wrappers\TeamToParticipantWrapper::PARTICIPANT_TYPE_COACH]),
            [
                'title' => '',
                'class' => 'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#modalteamparticipant',
            ]
        );


        $teamToParticipantSearch = new \common\models\search\TeamToParticipantSearch();
        $teamToParticipantSearch->team_id = $model->id;
        $dataProvider = $teamToParticipantSearch->search([]);
        ?>

        <?php Pjax::begin(['id' => 'pjax-team-to-participant-grid', 'timeout' => 5000]); ?>
        <?= \kartik\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $teamToParticipantSearch,
            'pjax' => false,
            'striped' => true,
            'hover' => true,
//            'panel' => ['type' => 'primary', 'heading' => 'Grid Grouping Example'],
            'toggleDataContainer' => ['class' => 'btn-group mr-2'],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
//                [
//                    'attribute' => 'team_id',
//                    'width' => '310px',
//                    'value' => function ($model, $key, $index, $widget) {
//                        return $model->team->name;
//                    },
//                    'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
//                    'filter' => $teamToParticipantSearch->getRelatedTeamList(),
//                    'filterWidgetOptions' => [
//                        'pluginOptions' => ['allowClear' => true],
//                    ],
//                    'filterInputOptions' => ['placeholder' => 'Any team'],
//                    'group' => true,  // enable grouping
//                    'groupedRow' => true,                    // move grouped column to a single grouped row
//                    'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
//                    'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
//                ],
                [
                    'attribute' => 'participant_id',
                    'width' => '310px',
                    'value' => function ($model, $key, $index, $widget) {
                        return $model->participant->fullName;
                    },
//                    'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
//                    'filter' => $teamToParticipantSearch->getRelatedTeamList(),
//                    'filterWidgetOptions' => [
//                        'pluginOptions' => ['allowClear' => true],
//                    ],
//                    'filterInputOptions' => ['placeholder' => 'Any team'],
                ],

                [
                    'attribute' => 'type',
                    'value' => function ($model, $key, $index, $widget) {
                        return $model->getTypeText();
                    },
                ],

                [
                    'attribute' => 'status',
                    'value' => function ($model, $key, $index, $widget) {
                        return $model->getStatusText();
                    },
                ],
                [
                    'attribute' => 'date_joined',
                    'value' => function ($model, $key, $index, $widget) {
                        if (isset($model->date_joined))
                            return \Yii::$app->formatter->asDate($model->date_joined, 'dd-MM-yyyy');
                    },
                ],
 [
                    'attribute' => 'date_leaved',
                    'value' => function ($model, $key, $index, $widget) {
                        if (isset($model->date_leaved))
                            return \Yii::$app->formatter->asDate($model->date_leaved, 'dd-MM-yyyy');
                    },
                ],


//                'date_joined:date',
//                'date_leaved:date',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{participant} {delete}',
                    'header' => Yii::t('app', 'Participant Edit'),
                    'headerOptions' => ['style' => 'width:15px', 'class' => 'activity-view-link',],
                    'contentOptions' => ['style' => 'text-align:right'],
                    'buttons' => array (
                        'participant' => function ($url, $model) {
                            return Html::a('<i class="fa fa-pencil"> </i>',
                                \yii\helpers\Url::to(['/team-to-participant/dialog', 'id' => $model['id'], 'type' => $model['type']]),
                                [
                                    'title' => '',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modalteamparticipant',
                                ]
                            );
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', false, [
                                'class' => 'pjax-delete-link',
                                'delete-url' => \yii\helpers\Url::to(['/team-to-participant/delete', 'id' => $model->id]),
                                'pjax-container' => 'pjax-team-to-participant-grid',
                                'title' => Yii::t('yii', 'Delete')
                            ]);
                        }
                    ),
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    <?php } else {
        echo Yii::t('app', 'You should first create team to set prices');
    } ?>


    <!-- Modal -->
    <div class="modal" id="modalteamparticipant" tabindex="-1" role="dialog"
         aria-labelledby="modalteamparticipantLabel"
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
    $("body").on("beforeSubmit", "form#team-to-participant-form", function () {
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
                            $.pjax.reload({container: '#pjax-team-to-participant-grid', async: false});
                            $("#modalteamparticipant").modal("toggle");
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

