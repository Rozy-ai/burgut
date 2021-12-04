<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<?php
if (isset($model) && isset($model->id)) {
    $searchModel = new \common\models\search\CompetitionPhaseSearch();
    $searchModel->competition_id = $model->id;
    if (isset($_GET['EventSearch'])) {
        $searchModel->setAttributes($_GET['EventSearch']);
    }
    ?>


    <div class="row">
        <div class="col-md-6">
            <?php
            echo Html::a('<i class="fa fa-calendar"> </i> Add Phase',
                \yii\helpers\Url::to(['/competition-phase/dialog', 'competition_id' => $model->id]),
                [
                    'title' => '',
                    'class' => 'btn btn-success',
                    'data-toggle' => 'modal',
                    'data-target' => '#modalphase',
                ]
            );
            ?>
        </div>
        <div class="col-md-6">
            <div id="filter-form" class="pull-right">
                <?php echo Html::activeDropDownList($searchModel, 'season_id', $searchModel->competition->getSeasonsList(), ['id' => 'phase-season-selector']); ?>
            </div>
        </div>
    </div>

    <?php Pjax::begin(['id' => 'pjax-phase-grid', 'timeout' => 5000]); ?>
    <?= GridView::widget([
        'dataProvider' => $searchModel->search([]),
        "filterSelector" => "#phase-season-selector",
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'type',
                'value' => function ($model) {
                    return $model->getTypeText();
                },
                'format' => 'html',
            ],
            'sort_order',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'header' => Yii::t('app', 'Action'),
                'headerOptions' => ['style' => 'width:15px', 'class' => 'activity-view-link',],
                'contentOptions' => ['style' => 'text-align:right'],
                'buttons' => array (
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fa fa-pencil"> </i>',
                            \yii\helpers\Url::to(['/competition-phase/dialog', 'id' => $model->id]),
                            [
                                'title' => '',
                                'data-toggle' => 'modal',
                                'data-target' => '#modalphase',
                            ]
                        );
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', false, [
                            'class' => 'pjax-delete-link',
                            'delete-url' => \yii\helpers\Url::to(['/competition-phase/delete', 'id' => $model->id]),
                            'pjax-container' => 'pjax-phase-grid',
                            'title' => Yii::t('yii', 'Delete')
                        ]);
                    }
                ),
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
<?php } ?>


<!-- Modal -->
<div class="modal" id="modalphase" tabindex="-1" role="dialog" aria-labelledby="modalphaseLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>


<?php
$script = <<< JS
    //message dialog
    $("body").on("beforeSubmit", "form#phase-form", function () {
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
                            $.pjax.reload({container: '#pjax-phase-grid', async: false});
                            $("#modalphase").modal("toggle");
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


