<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\BannerTypeWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-type-wrapper-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_name')->textInput(['maxlength' => true, 'readonly' => isset($model->type_name)]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'width')->textInput() ?>

    <?= $form->field($model, 'height')->textInput() ?>

    <?= $form->field($model, 'type')->dropDownList($model->getTypeOptions()) ?>

    <?= $form->field($model, 'status')->dropDownList($model->getBoolOptions()) ?>

    <?= $form->field($model, 'is_mobile_enabled')->dropDownList($model->getBoolOptions()) ?>






    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
