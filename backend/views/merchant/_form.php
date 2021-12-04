<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\MerchantWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="merchant-wrapper-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_id')->dropDownList(\common\models\wrappers\MerchantWrapper::getUserOptions(), ['prompt' => Yii::t('app', 'Choose one')]) ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'language')->dropDownList(\common\models\wrappers\MerchantWrapper::getLanguageOptions()) ?>
    <?= $form->field($model, 'currency')->dropDownList(\common\models\wrappers\MerchantWrapper::getCurrencyOptions()) ?>
    <?= $form->field($model, 'status')->dropDownList(\common\models\wrappers\MerchantWrapper::getStatusOptions()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
