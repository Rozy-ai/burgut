<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\ItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-wrapper-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'alias') ?>

    <?= $form->field($model, 'id') ?>
    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'visited_count') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'event_date') ?>

    <?php // echo $form->field($model, 'event_location') ?>

    <!--    <div class="form-group">-->
    <!--        --><? //= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    <!--        --><? //= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    <!--    </div>-->

    <?php ActiveForm::end(); ?>

</div>
