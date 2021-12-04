<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="album-wrapper-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>


    <?= $form->field($model, 'docs')->hiddenInput(['id' => "album"]) ?>

    <?php
    echo \common\widgets\dropzone\DropZoneYii2::widget([
        'dropzoneName' => 'musicDropzone',
        'inputId' => 'album',
        'mockFiles' => $model->makeMockFiles($model->documents),
        'uploadUrl' => '/document/upload',
        'deleteUrl' => '/document/deleteupload',
    ]);
    ?>

    <?= $form->field($model, 'item_id')->dropDownList($model->getItemList(), ['prompt' => Yii::t('backend', 'Select Related Restauarnt')]) ?>


    <?= $form->field($model, 'date_created')->textInput() ?>

    <?= $form->field($model, 'date_modified')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

