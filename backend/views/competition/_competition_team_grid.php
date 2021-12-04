<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="competition-to-seat-wrapper-index">

    <h3><?= Yii::t('app', 'Teams') ?></h3>

    <?php
    if (isset($model) && isset($model->id)) {
        echo Html::a('<i class="fa fa-chair"> </i> Add Team',
            \yii\helpers\Url::to(['/competition-to-team/dialog', 'competition_id' => $model->id]),
            [
                'title' => '',
                'class' => 'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#modalcompetitionteam',
            ]
        );


        $competitionToTeamSearch = new \common\models\search\CompetitionToTeamSearch();
        $competitionToTeamSearch->competition_id = $model->id;
        $dataProvider = $competitionToTeamSearch->search([]);
        ?>

        <?php Pjax::begin(['id' => 'pjax-competition-to-team-grid', 'timeout' => 5000]); ?>
        <?= \kartik\grid\GridView::widget([
            'dataProvider' => $dataProvider,
//            "filterSelector" => "#season-selector",
            'filterModel' => $competitionToParticipantSearch,
            'pjax' => false,
            'striped' => true,
            'hover' => true,
//            'panel' => ['type' => 'primary', 'heading' => 'Grid Grouping Example'],
            'toggleDataContainer' => ['class' => 'btn-group mr-2'],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'attribute' => 'group_id',
                    'width' => '310px',
                    'value' => function ($model, $key, $index, $widget) {
                        return $model->group->name;
                    },
                    'group' => true,  // enable grouping
                    'groupedRow' => true,                    // move grouped column to a single grouped row
                    'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                    'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                ],
                [
                    'attribute' => 'team_id',
                    'value' => function ($model, $key, $index, $widget) {
                        return $model->team->name;
                    },
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{competitionteam}',
                    'header' => Yii::t('app', 'On map'),
                    'headerOptions' => ['style' => 'width:15px', 'class' => 'activity-view-link',],
                    'contentOptions' => ['style' => 'text-align:right'],
                    'buttons' => array (
                        'competitionteam' => function ($url, $model) {
                            return Html::a('<i class="fa fa-pencil"> </i>',
                                \yii\helpers\Url::to(['/competition-to-team/dialog', 'id' => $model['id']]),
                                [
                                    'title' => '',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modalcompetitionteam',
                                ]
                            );
                        },

                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', false, [
                                'class' => 'pjax-delete-link',
                                'delete-url' => \yii\helpers\Url::to(['/competition-to-team/delete', 'id' => $model->id]),
                                'pjax-container' => 'pjax-competition-to-team-grid',
                                'title' => Yii::t('yii', 'Delete')
                            ]);
                        }
                    ),
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    <?php } else {
        echo Yii::t('app', 'You should first create competition to set prices');
    } ?>


    <!-- Modal -->
    <div class="modal" id="modalcompetitionteam" role="dialog" aria-labelledby="modalcompetitionteamLabel"
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
    $("body").on("beforeSubmit", "form#competition-to-team-form", function () {
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
                            $.pjax.reload({container: '#pjax-competition-to-team-grid', async: false});
                            $("#modalcompetitionteam").modal("toggle");
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

