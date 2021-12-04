<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<h3><?= Yii::t('app', 'Groups') ?></h3>
<?php
if (isset($model) && isset($model->id)) {
    $searchModel = new \common\models\search\CompetitionGroupSearch();
    $searchModel->competition_id = $model->id;
    if (isset($_GET['CompetitionGroupSearch'])) {
        $searchModel->setAttributes($_GET['CompetitionGroupSearch']);
    }
    ?>

    <div class="row">
        <div class="col-md-6">
            <?php
            echo Html::a('<i class="fa fa-calendar"> </i> Add Group',
                \yii\helpers\Url::to(['/competition-group/dialog', 'competition_id' => $model->id]),
                [
                    'title' => '',
                    'class' => 'btn btn-success',
                    'data-toggle' => 'modal',
                    'data-target' => '#modalgroup',
                ]
            );
            ?>
        </div>
<!--        <div class="col-md-6">-->
<!--            <div id="filter-form" class="pull-right">-->
<!--                --><?php //echo Html::activeDropDownList($searchModel, 'season_id', $searchModel->competition->getSeasonsList(), ['id' => 'group-season-selector']); ?>
<!--            </div>-->
<!--        </div>-->
    </div>


    <?php Pjax::begin(['id' => 'pjax-group-grid', 'timeout' => 5000]); ?>
    <?= GridView::widget([
        'dataProvider' => $searchModel->search([]),
        "filterSelector" => "#season-selector",
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'header' => Yii::t('app', 'Action'),
                'headerOptions' => ['style' => 'width:15px', 'class' => 'activity-view-link',],
                'contentOptions' => ['style' => 'text-align:right'],
                'buttons' => array (
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fa fa-pencil"> </i>',
                            \yii\helpers\Url::to(['/competition-group/dialog', 'id' => $model->id]),
                            [
                                'title' => '',
                                'data-toggle' => 'modal',
                                'data-target' => '#modalgroup',
                            ]
                        );
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', false, [
                            'class' => 'pjax-delete-link',
                            'delete-url' => \yii\helpers\Url::to(['/competition-group/delete', 'id' => $model->id]),
                            'pjax-container' => 'pjax-group-grid',
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
<div class="modal" id="modalgroup" tabindex="-1" role="dialog" aria-labelledby="modalgroupLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>


<?php
$script = <<< JS
    //message dialog
    $("body").on("beforeSubmit", "form#group-form", function () {
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
                            $.pjax.reload({container: '#pjax-group-grid', async: false});
                            $("#modalgroup").modal("toggle");
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


