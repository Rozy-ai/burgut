<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>



<?php
$form = ActiveForm::begin([
    'options' => ['id' => 'group-form', 'data-pjax' => true],
//        'enableAjaxValidation' => true,
//        'validationUrl' => \yii\helpers\Url::toRoute('field/dialog')
]);
?>


<div class="modal-header">
    <strong class="modal-title"><?php echo Yii::t('app', 'Edit event prices') ?></strong>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'season_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'competition_id')->hiddenInput()->label(false) ?>
</div>

<div class="modal-footer">
    <?php echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Cancel') ?></button>
</div>

<?php ActiveForm::end(); ?>
