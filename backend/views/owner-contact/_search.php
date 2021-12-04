<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\OwnerContactSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="owner-contact-wrapper-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'my_title') ?>

    <?= $form->field($model, 'my_description') ?>

    <?= $form->field($model, 'my_email') ?>

    <?= $form->field($model, 'my_phone') ?>

    <?php // echo $form->field($model, 'my_address') ?>

    <?php // echo $form->field($model, 'date_added') ?>

    <?php // echo $form->field($model, 'date_modified') ?>

    <?php // echo $form->field($model, 'edited_username') ?>

    <?php // echo $form->field($model, 'create_username') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
