<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\CompetitionWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="competition-wrapper-form">

    <?php
    echo \yii\bootstrap\Tabs::widget([
        'items' => [
            [
                'label' => 'Competition',
                'content' => $this->render('_general', [
                    'model' => $model,
                    'form' => $form,
                    'contentItemModel' => $contentItemModel,
                ]),
            ],
            [
                'label' => 'Seasons',
                'content' => $this->render('_competition_season_grid', [
                    'model' => $model
                ]),
//                'active' => true
            ],
            [
                'label' => 'Groups/Teams/Players',
                'content' => $this->render('_tab_candidates', [
                    'model' => $model
                ]),
//                'active' => true
            ],
            [
                'label' => 'Phases',
                'content' => $this->render('_competition_phase_grid', [
                    'model' => $model
                ]),
//                'active' => true
            ],
            [
                'label' => 'Calendar',
                'content' => $this->render('_competition_event_grid', [
                    'model' => $model
                ]),
//                'active' => true
            ],
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
