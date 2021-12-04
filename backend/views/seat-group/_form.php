<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\SeatGroupWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seat-group-wrapper-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo \yii\bootstrap\Tabs::widget([
        'items' => [
            [
                'label' => 'Common',
                'content' => $this->render('_general', [
                    'model' => $model,
                    'form' => $form,
                ]),
//                'active' => true
            ],
            [
                'label' => 'Seats',
                'content' => $this->render('_seats_tab', [
                    'model' => $model,
                ]),
//                'active' => true
            ],
        ]
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
