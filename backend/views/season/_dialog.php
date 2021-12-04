<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>



<?php
$form = ActiveForm::begin([
    'options' => ['id' => 'season-form', 'data-pjax' => true],
//        'enableAjaxValidation' => true,
//        'validationUrl' => \yii\helpers\Url::toRoute('field/dialog')
]);
?>


<div class="modal-header">
    <strong class="modal-title"><?php echo Yii::t('app', 'Edit seasons') ?></strong>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'competition_id')->hiddenInput()->label(false) ?>

    <?php
    echo $form->field($model, 'start_date')->widget(\kartik\date\DatePicker::classname(), [
        'type' => \kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
//                'min' => time(),
//                'startDate' => "0d",
            'format' => 'dd-mm-yyyy',
        ]
    ]);
    ?>

    <?php
    echo $form->field($model, 'end_date')->widget(\kartik\date\DatePicker::classname(), [
        'type' => \kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
//                'min' => time(),
//                'startDate' => "0d",
            'format' => 'dd-mm-yyyy',
        ]
    ]);
    ?>

    <hr>

    <?php
    echo $this->render('_dynamic_content', [
        'model' => $model,
        'form' => $form,
    ]);
    ?>
</div>

<div class="modal-footer">
    <?php echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Cancel') ?></button>
</div>

<?php ActiveForm::end(); ?>
