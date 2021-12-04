<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$model = new \common\models\wrappers\ContactWrapper();
$model->federation_id = $federationModel->id;
?>


<div class="contact-text right-side">
    <?php $form = ActiveForm::begin([
        'id' => 'contact-form',
        'enableClientValidation' => false,
        'enableAjaxValidation' => false]); ?>

    <?= $form->field($model, 'federation_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'subject') ?>

    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

    <div class="form-group input-box submt">
        <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-success', 'name' => 'contact-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>


<?php
$script = <<< JS

        $('#contact-form').on('beforeSubmit', function(e) {
            var form = $(this);
            var formData = form.serialize();
            $.ajax({
                url: form.attr("action"),
                type: form.attr("method"),
                data: formData,
                success: function (data) {
                    alert('Test');
                },
                error: function () {
                    alert("Something went wrong");
                }
            });
        }).on('submit', function(e){
            e.preventDefault();
        });
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
?>
