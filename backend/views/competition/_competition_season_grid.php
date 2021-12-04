<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="event-to-season-wrapper-index">

    <h1><?= Yii::t('app', 'Seasons') ?></h1>

    <?php
    if (isset($model) && isset($model->id)) {

        echo Html::a('<i class="fa fa-calendar"> </i> Add Season',
            \yii\helpers\Url::to(['/season/dialog', 'competition_id' => $model->id]),
            [
                'title' => '',
                'class' => 'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#modalseason',
            ]
        );


        $seasonSearch = new \common\models\search\SeasonSearch();
        $seasonSearch->competition_id = $model->id;
        $dataProvider = $seasonSearch->search([]);
        ?>

        <?php Pjax::begin(['id' => 'pjax-season-grid', 'timeout' => 5000]); ?>
        <?= \kartik\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $seasonSearch,
            'pjax' => true,
            'striped' => true,
            'hover' => true,
//            'panel' => ['type' => 'primary', 'heading' => 'Grid Grouping Example'],
//            'toggleDataContainer' => ['class' => 'btn-group mr-2'],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                'name',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                    'header' => Yii::t('app', 'Action'),
                    'headerOptions' => ['style' => 'width:15px', 'class' => 'activity-view-link',],
                    'contentOptions' => ['style' => 'text-align:right'],
                    'buttons' => array (
                        'update' => function ($url, $model) {
                            return Html::a('<i class="glyphicon glyphicon-pencil"> </i>',
                                \yii\helpers\Url::to(['/season/dialog', 'id' => $model->id]),
                                [
                                    'title' => '',
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modalseason',
                                ]
                            );
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', false, [
                                'class' => 'pjax-delete-link',
                                'delete-url' => \yii\helpers\Url::to(['/season/delete', 'id' => $model->id]),
                                'pjax-container' => 'pjax-season-grid',
                                'title' => Yii::t('yii', 'Delete')
                            ]);
                        }
                    ),
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    <?php } else {
        echo Yii::t('backend', 'You should first create competition to attach seasons');
    } ?>


    <!-- Modal -->
    <div class="modal" id="modalseason" tabindex="-1" role="dialog" aria-labelledby="modalseasonLabel"
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
    $("body").on("beforeSubmit", "form#season-form", function () {
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
                            $.pjax.reload({container: '#pjax-season-grid', async: false});
                            $("#modalseason").modal("toggle");
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

