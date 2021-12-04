<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\CompetitionGroupWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="competition-group-wrapper-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'competition_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
