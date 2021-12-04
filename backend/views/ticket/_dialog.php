<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="ticket-form-dialog">
    <?php
    $form = ActiveForm::begin([
        'options' => ['id' => 'ticket-form', 'data-pjax' => true],
//        'enableAjaxValidation' => true,
//        'validationUrl' => \yii\helpers\Url::toRoute('ticket/dialog')
    ]);
    ?>


    <div class="modal-header">
        <strong class="modal-title"><?php echo Yii::t('app', 'Edit event prices') ?></strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <?= $form->field($model, 'seat_id')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'event_id')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'location_id')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'unique_code')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'payment_type_id')->dropDownList(\common\models\wrappers\PaymentTypeWrapper::getPaymentTypeList(\common\models\wrappers\PaymentTypeWrapper::TYPE_BACKEND)) ?>
    </div>
    <div class="modal-footer">
        <?php echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Cancel') ?></button>
    </div>

    <?php ActiveForm::end(); ?>
</div>