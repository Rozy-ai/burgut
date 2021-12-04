<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\EventWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-wrapper-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo \yii\bootstrap\Tabs::widget([
        'items' => [
            [
                'label' => 'Event details',
                'content' => $this->render('_general', [
                    'model' => $model,
                    'form' => $form,
                ]),
            ],
            [
                'label' => 'Teams',
                'content' => $this->render('_event_team_grid', [
                    'eventModel' => $model,
                ]),
                'visible' => $model->competition->is_team
            ],
            [
                'label' => 'Participants',
                'content' => $this->render('_event_participant_grid', [
                    'eventModel' => $model,
                ]),
            ],
        ]
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



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

