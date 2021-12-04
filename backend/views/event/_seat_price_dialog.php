<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="seat-price-form">

    <?php
    $form = ActiveForm::begin([
        'options' => ['id' => 'dynamic-form', 'data-pjax' => true],
    ]);
    ?>


    <div class="modal-header">
        <strong class="modal-title"><?php echo Yii::t('app', 'Edit event prices') ?></strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <?= $form->field($model, 'event_id')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'seat_group_id')->hiddenInput()->label(false) ?>

        <div class="row">
            <div class="col-md-12">
                <?php
                $event = $model->event;
                if (isset($event))
                    echo $event->title;
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                $seatGroup = $model->seatGroup;
                if (isset($seatGroup)) {
                    echo $seatGroup->name;
                }
                ?>
            </div>
        </div>

        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="modal-footer">
        <?php echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Cancel') ?></button>
    </div>

    <?php ActiveForm::end(); ?>
</div>