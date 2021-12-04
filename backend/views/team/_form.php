<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\TeamWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="competition-wrapper-form">

    <?php
    echo \yii\bootstrap\Tabs::widget([
        'items' => [
            [
                'label' => 'General',
                'content' => $this->render('_general', [
                    'model' => $model,
                    'form' => $form,
                    'contentItemModel' => $contentItemModel,
                ]),
            ],
            [
                'label' => 'Pariticipants',
                'content' => $this->render('_team_participant_grid', [
                    'model' => $model
                ]),
            ]
        ]
    ]);
    ?>

</div>


<?php
$this->registerJs("
    $(document).on('ready pjax:success', function() {
        $('.pjax-delete-link').on('click', function(e) {
            debugger;
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
