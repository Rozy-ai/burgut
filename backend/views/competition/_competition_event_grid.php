<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="event-to-seat-wrapper-index">

    <h1><?= Yii::t('app', 'Events') ?></h1>

    <?php
    if (isset($model) && isset($model->id)) {
        $searchModel = new \common\models\search\EventSearch();
        $searchModel->competition_id = $model->id;
        if (isset($_GET['EventSearch'])) {
            $searchModel->setAttributes($_GET['EventSearch']);
        }
        ?>

        <div class="row">
            <div class="col-md-6">
                <?php
                echo Html::a('<i class="fa fa-calendar"> </i> Add Event',
                    \yii\helpers\Url::to(['/event/create', 'competition_id' => $model->id]),
                    [
                        'title' => '',
                        'class' => 'btn btn-success',
//                'data-toggle' => 'modal',
//                'data-target' => '#modalevent',
                    ]
                );
                ?>
            </div>
            <div class="col-md-6">
                <div id="filter-form" class="pull-right">
                    <?php echo Html::activeDropDownList($searchModel, 'season_id', $searchModel->competition->getSeasonsList(), ['id' => 'result-season-selector']); ?>
                </div>
            </div>
        </div>

        <?php Pjax::begin(['id' => 'pjax-event-grid', 'timeout' => 5000]); ?>

        <?= \kartik\grid\GridView::widget([
            'dataProvider' => $searchModel->search([]),
//            'filterModel' => $searchModel,
            "filterSelector" => "#result-season-selector",
            'pjax' => true,
            'striped' => true,
            'hover' => true,
//            'panel' => ['type' => 'primary', 'heading' => 'Grid Grouping Example'],
//            'toggleDataContainer' => ['class' => 'btn-group mr-2'],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'attribute' => 'competition_group_id',
//                    'width' => '310px',
                    'value' => function ($model, $key, $index, $widget) {
                        return $model->competitionGroup->name;
                    },
//                    'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
//                    'filter' => $eventToParticipantSearch->getRelatedTeamList(),
//                    'filterWidgetOptions' => [
//                        'pluginOptions' => ['allowClear' => true],
//                    ],
//                    'filterInputOptions' => ['placeholder' => 'Any team'],
                    'group' => true,  // enable grouping
                    'groupedRow' => true,                    // move grouped column to a single grouped row
                    'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
                    'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                ],
                [
                    'attribute' => 'competition_phase_id',
//                    'width' => '310px',
                    'value' => function ($model, $key, $index, $widget) {
                        return $model->competitionPhase->name;
                    },
//                    'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
//                    'filter' => $eventToParticipantSearch->getRelatedTeamList(),
//                    'filterWidgetOptions' => [
//                        'pluginOptions' => ['allowClear' => true],
//                    ],
//                    'filterInputOptions' => ['placeholder' => 'Any team'],
                    'group' => true,  // enable grouping
//                    'groupedRow' => true,
                    'subGroupOf' => 1,
//                    'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
//                    'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                ],
                [
                    'options' => ['max-width' => '120px'],
                    'attribute' => 'location',
                    'value' => function ($model) {
                        return $model->location;
                    },
                    'format' => 'html',
                ],
                [
                    'options' => ['max-width' => '120px'],
                    'attribute' => 'home',
                    'value' => function ($model) {
                        $canditateName = $model->getSideCanditate(0);
                        if (isset($canditateName)) {
                            return $canditateName;
                        }
                    },
                    'format' => 'html',
                ],
                [
                    'options' => ['max-width' => '120px'],
                    'attribute' => 'score',
                    'value' => function ($model) {
                        $eventSides = $model->getEventSides();
                        if (isset($eventSides) && isset($eventSides[0]) && isset($eventSides[1])) {
                            return $eventSides[0]->score_for . ' - ' . $eventSides[1]->score_for;
                        }
                    },
                    'format' => 'html',
                ],

                [
                    'options' => ['max-width' => '120px'],
                    'attribute' => 'away',
                    'value' => function ($model) {
                        $canditateName = $model->getSideCanditate(1);
                        if (isset($canditateName)) {
                            return $canditateName;
                        }
                    },
                    'format' => 'html',
                ],

                [
                    'options' => ['max-width' => '50px'],
                    'attribute' => 'start_time',
                    'format' => 'html',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
//                    'template' => '{price}',
                    'options' => ['width' => '100px'],
                    'header' => Yii::t('app', 'On map'),
                    'headerOptions' => ['style' => 'width:25px', 'class' => 'activity-view-link',],
                    'contentOptions' => ['style' => 'text-align:right'],
                    'buttons' => array (
                        'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"> </span>',
                                \yii\helpers\Url::to(['/event/update', 'id' => $model->id]),
                                [
                                    'title' => '',
//                                    'data-toggle' => 'modal',
//                                    'data-target' => '#modalgroup',
                                ]
                            );
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', false, [
                                'class' => 'pjax-delete-link',
                                'delete-url' => \yii\helpers\Url::to(['/event/delete', 'id' => $model->id]),
                                'pjax-container' => 'pjax-event-grid',
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
    <div class="modal" id="modalevent" tabindex="-1" role="dialog" aria-labelledby="modaleventLabel"
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
                            $.pjax.reload({container: '#pjax-event-grid', async: false});
                            $("#modalevent").modal("toggle");
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

