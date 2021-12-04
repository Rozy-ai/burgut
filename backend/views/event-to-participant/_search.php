<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\EventToParticipantSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-to-participant-wrapper-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'event_id') ?>

    <?= $form->field($model, 'participant_id') ?>

    <?= $form->field($model, 'participant_type_id') ?>

    <?= $form->field($model, 'team_id') ?>

    <?php // echo $form->field($model, 'score_for') ?>

    <?php // echo $form->field($model, 'score_against') ?>

    <?php // echo $form->field($model, 'point') ?>

    <?php // echo $form->field($model, 'result_state') ?>

    <?php // echo $form->field($model, 'category_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
