<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="competition-to-seat-wrapper-index">

    <h3><?= Yii::t('app', 'Participants') ?></h3>

    <?php
    if (isset($model) && isset($model->id)) {
        echo Html::a('<i class="fa fa-chair"> </i> Add Athlete',
            \yii\helpers\Url::to(['/competition-to-participant/dialog', 'competition_id' => $model->id, 'type' => \common\models\wrappers\CompetitionToParticipantWrapper::PARTICIPANT_TYPE_ATHLETE]),
            [
                'title' => '',
                'class' => 'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#modalcompetitionparticipant',
            ]
        );

        echo Html::a('<i class="fa fa-chair"> </i> Add Coach',
            \yii\helpers\Url::to(['/competition-to-participant/dialog', 'competition_id' => $model->id, 'type' => \common\models\wrappers\CompetitionToParticipantWrapper::PARTICIPANT_TYPE_COACH]),
            [
                'title' => '',
                'class' => 'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#modalcompetitionparticipant',
            ]
        );

        echo Html::a('<i class="fa fa-chair"> </i> Add Judge',
            \yii\helpers\Url::to(['/competition-to-participant/dialog', 'competition_id' => $model->id, 'type' => \common\models\wrappers\CompetitionToParticipantWrapper::PARTICIPANT_TYPE_JUDGE]),
            [
                'title' => '',
                'class' => 'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#modalcompetitionparticipant',
            ]
        );


        $competitionToParticipantSearch = new \common\models\search\CompetitionToParticipantSearch();
        $competitionToParticipantSearch->competition_id = $model->id;
        $dataProvider = $competitionToParticipantSearch->search([]);
        $dataProvider->setSort([
            'defaultOrder' => [
                'team_id' => SORT_DESC,
                'type' => SORT_DESC,
            ]
        ]);
        ?>

        <?php Pjax::begin(['id' => 'pjax-competition-to-participant-grid', 'timeout' => 5000]); ?>

        <?php if ($model->is_team) {
            echo \kartik\grid\GridView::widget([
                'dataProvider' => $dataProvider,
//                "filterSelector" => "#season-selector",
                'filterModel' => $competitionToParticipantSearch,
//                'pjax' => false,
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
                        'filter' => $competitionToParticipantSearch->getRelatedTeamList(),
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
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{participant} {delete}',
                        'header' => Yii::t('app', 'Participant Edit'),
                        'headerOptions' => ['style' => 'width:15px', 'class' => 'activity-view-link',],
                        'contentOptions' => ['style' => 'text-align:right'],
                        'buttons' => array (
                            'participant' => function ($url, $model) {
                                return Html::a('<i class="fa fa-pencil"> </i>',
                                    \yii\helpers\Url::to(['/competition-to-participant/dialog', 'id' => $model['id'], 'type' => $model['type']]),
                                    [
                                        'title' => '',
                                        'data-toggle' => 'modal',
                                        'data-target' => '#modalcompetitionparticipant',
                                    ]
                                );
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', false, [
                                    'class' => 'pjax-delete-link',
                                    'delete-url' => \yii\helpers\Url::to(['/competition-to-participant/delete', 'id' => $model->id]),
                                    'pjax-container' => 'pjax-competition-to-participant-grid',
                                    'title' => Yii::t('yii', 'Delete')
                                ]);
                            }
                        ),
                    ],
                ],
            ]);
        } else {
            echo \kartik\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $competitionToParticipantSearch,
                'pjax' => false,
                'striped' => true,
                'hover' => true,
//            'panel' => ['type' => 'primary', 'heading' => 'Grid Grouping Example'],
                'toggleDataContainer' => ['class' => 'btn-group mr-2'],
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn'],
                    [
                        'attribute' => 'type',
                        'width' => '310px',
                        'value' => function ($model, $key, $index, $widget) {
                            return $model->getTypeText();
                        },
//                        'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
//                        'filter' => $competitionToParticipantSearch->getRelatedGroupList(),
//                        'filterWidgetOptions' => [
//                            'pluginOptions' => ['allowClear' => true],
//                        ],
//                        'filterInputOptions' => ['placeholder' => 'Any group'],
                        'group' => true,  // enable grouping
                        'groupedRow' => true,                    // move grouped column to a single grouped row
                        'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                        'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                    ],

                    [
                        'attribute' => 'group_id',
                        'width' => '50px',
                        'value' => function ($model, $key, $index, $widget) {
                            return $model->group->name;
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
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{participant} {delete}',
                        'header' => Yii::t('app', 'Participant Edit'),
                        'headerOptions' => ['style' => 'width:15px', 'class' => 'activity-view-link',],
                        'contentOptions' => ['style' => 'text-align:right'],
                        'buttons' => array (
                            'participant' => function ($url, $model) {
                                return Html::a('<i class="fa fa-pencil"> </i>',
                                    \yii\helpers\Url::to(['/competition-to-participant/dialog', 'id' => $model['id'], 'type' => $model['type']]),
                                    [
                                        'title' => '',
                                        'data-toggle' => 'modal',
                                        'data-target' => '#modalcompetitionparticipant',
                                    ]
                                );
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', false, [
                                    'class' => 'pjax-delete-link',
                                    'delete-url' => \yii\helpers\Url::to(['/competition-to-participant/delete', 'id' => $model->id]),
                                    'pjax-container' => 'pjax-competition-to-participant-grid',
                                    'title' => Yii::t('yii', 'Delete')
                                ]);
                            }
                        ),
                    ],
                ],
            ]);
        } ?>

        <?php Pjax::end(); ?>
    <?php } else {
        echo Yii::t('app', 'You should first create competition to set prices');
    } ?>


    <!-- Modal -->
    <div class="modal" id="modalcompetitionparticipant" tabindex="-1" role="dialog"
         aria-labelledby="modalcompetitionparticipantLabel"
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
    $("body").on("beforeSubmit", "form#competition-to-participant-form", function () {
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
                            $.pjax.reload({container: '#pjax-competition-to-participant-grid', async: false});
                            $("#modalcompetitionparticipant").modal("toggle");
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

