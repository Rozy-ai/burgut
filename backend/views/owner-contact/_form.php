<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\OwnerContactWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="owner-contact-wrapper-form">

    <?php $form = ActiveForm::begin(); ?>

    <fieldset>
        <legend> <?php echo Yii::t('backend', 'General and contact info'); ?></legend>
        <?= $form->field($model, 'my_title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'my_description')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'my_email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'my_phone')->textarea(['maxlength' => true, 'rows' => 3]) ?>
        <label>For example:<br>
            <span>+993 6* 12-23-34</span><br>
            <span>+993 12 56-67-78</span><br>
            <span>98-87-65</span>
        </label>
    </fieldset>

    <fieldset>
        <legend> <?php echo Yii::t('backend', 'Map Location'); ?></legend>
        <?= $form->field($model, 'my_address')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'my_latitude')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'my_longitude')->textInput(['maxlength' => true]) ?>
    </fieldset>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
