<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="seat-price-form">

    <?php
    $form = ActiveForm::begin([
        'options' => ['id' => 'seat-range-form', 'data-pjax' => true],
//        'enableAjaxValidation' => true,
//        'validationUrl' => \yii\helpers\Url::toRoute('seat/dialog')
    ]);
    ?>


    <div class="modal-header">
        <strong class="modal-title"><?php echo Yii::t('app', 'Edit event prices') ?></strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <?= $form->field($model, 'label_y')->textInput(['maxlength' => true, 'placeholder' => 'A or AA']) ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'label_x_start')->textInput(['type' => 'number', 'placeholder' => '1,2,...']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'label_x_end')->textInput(['type' => 'number', 'placeholder' => '1,2,...']) ?>
            </div>
        </div>

        <?= $form->field($model, 'seat_group_id')->dropDownList($model->getSeatGroupList(), ['prompt' => '--Select GROUP--']) ?>
    </div>
    <div class="modal-footer">
        <?php echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Cancel') ?></button>
    </div>

    <?php ActiveForm::end(); ?>
</div>