<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\RouteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="route-wrapper-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'route_no') ?>

    <?= $form->field($model, 'from_point_id') ?>

    <?= $form->field($model, 'to_point_id') ?>

    <?= $form->field($model, 'length') ?>

    <?php // echo $form->field($model, 'cycle_min') ?>

    <?php // echo $form->field($model, 'planned_period_min') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
