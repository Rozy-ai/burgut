<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ImageWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="image-wrapper-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
        echo $this->render('_content', [
            'model' => $model,
            'form' => $form,
        ])
    ?>

    <?= $form->field($model, 'type')->hiddenInput(array ('id' => 'image_type'))->label(false) ?>
    <?= $form->field($model, 'docs')->hiddenInput(['id' => "image"])->label("") ?>
    <?php
    echo \common\widgets\dropzone\DropZoneYii2::widget([
        'dropzoneName' => 'itemDropzone',
        'inputId' => 'image',
        'mockFiles' => $model->makeMockFiles($model->documents),
        'uploadUrl' => '/document/upload',
        'deleteUrl' => '/document/deleteupload',
        'options' => [
            'maxFilesize' => 100,
            'acceptedFiles' => 'image/*'
        ]
    ]);
    ?>

    <?php if (isset($model->type) && $model->type == \common\models\wrappers\ImageWrapper::IMAGE_VIDEO) {
        echo $form->field($model, 'video_docs')->hiddenInput(['id' => "video"])->label("");
        echo \common\widgets\dropzone\DropZoneYii2::widget([
            'dropzoneName' => 'itemVideoDropzone',
            'inputId' => 'video',
            'mockFiles' => $model->makeMockFiles($model->videoDocuments),
            'uploadUrl' => '/document/upload',
            'deleteUrl' => '/document/deleteupload',
            'options' => [
                'maxFilesize' => 100000,
                'acceptedFiles' => 'video/*'
            ]
        ]);
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

