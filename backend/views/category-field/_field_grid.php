<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<?php
if (isset($searchModel)) {
    Pjax::begin(['id' => 'pjax-field-grid', 'timeout' => 5000]); ?>
    <?= GridView::widget([
        'dataProvider' => $searchModel->search([]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'category_id',
            'target_model',
            'field_name',
            'field_description',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'header' => Yii::t('app', 'Action'),
                'headerOptions' => ['style' => 'width:15px', 'class' => 'activity-view-link',],
                'contentOptions' => ['style' => 'text-align:right'],
                'buttons' => array(
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fa fa-pencil"> </i>',
                            \yii\helpers\Url::to(['/category-field/dialog', 'id' => $model->id]),
                            [
                                'title' => '',
                                'data-toggle' => 'modal',
                                'data-target' => '#modalfield',
                            ]
                        );
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', false, [
                            'class' => 'pjax-delete-link',
                            'delete-url' => \yii\helpers\Url::to(['/category-field/delete', 'id' => $model->id]),
                            'pjax-container' => 'pjax-field-grid',
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
<div class="modal" id="modalfield" tabindex="-1" role="dialog" aria-labelledby="modalfieldLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>


<?php
$script = <<< JS
    //message dialog
    $("body").on("beforeSubmit", "form#field-form", function () {
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
                            $.pjax.reload({container: '#pjax-field-grid', async: false});
                            $("#modalfield").modal("toggle");
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


<?php
$this->registerJs("
    $(document).on('ready pjax:success', function() {
        $('.pjax-delete-link').on('click', function(e) {
            e.preventDefault();
            var deleteUrl = $(this).attr('delete-url');
            var pjaxContainer = $(this).attr('pjax-container');
            var result = confirm('Delete this item, are you sure?');                                
            if(result) {
                $.ajax({
                    url: deleteUrl,
                    type: 'post',
                    error: function(xhr, status, error) {
                        alert('There was an error with your request.' + xhr.responseText);
                    }
                }).done(function(data) {
                    $.pjax.reload('#' + $.trim(pjaxContainer), {timeout: 3000});
                });
            }
        });

    });
");
?>

