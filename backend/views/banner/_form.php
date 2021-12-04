<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\BannerWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-wrapper-form">

    <?php $form = ActiveForm::begin([
        'action' => !isset($model->id) ? Url::to(['banner/create']) : Url::to(['banner/update', 'id' => $model->id]),
        'id' => 'banner-form',
        'options' => ['enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-3 col-md-3',
                'offset' => 'col-sm-offset-3 ',
                'wrapper' => 'col-sm-9',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); ?>
    <?= $form->field($model, 'type')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'format_type')->dropDownList($model->getFormatTypeOptions()) ?>

    <?= $form->field($model, 'docs')->hiddenInput(['id' => "banner"])->label("") ?>
    <div class="form-group">
        <?php
        echo \common\widgets\dropzone\DropZoneYii2::widget([
            'dropzoneName' => 'itemDropzone',
            'inputId' => 'banner',
            'mockFiles' => $model->makeMockFiles($model->documents),
            'uploadUrl' => '/document/upload',
            'deleteUrl' => '/document/deleteupload',
            'options' => [
                'maxFilesize' => 100,
                'acceptedFiles' => 'image/*'
            ]
        ]);
        ?>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
