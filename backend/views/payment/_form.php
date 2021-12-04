<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\PaymentWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-wrapper-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'merchant_order_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'merchant_success_url')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'merchant_failure_url')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'submitted_order_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'response_order_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'response_form_url')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'response_error_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'merchant_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
