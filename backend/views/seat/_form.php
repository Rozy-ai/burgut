<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\SeatWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seat-wrapper-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'label_x')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'label_y')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'seat_group_id')->dropDownList($model->getSeatGroupList(), ['prompt' => '--Select GROUP--']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
