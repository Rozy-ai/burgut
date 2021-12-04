<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\MenuWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-wrapper-form">


    <?php
    $form = ActiveForm::begin([
//                        'layout' => 'horizontal',
        'options' => ['id' => 'dynamic-form', 'data-pjax' => true,],
//                        'formConfig' => ['labelSpan' => 2, 'deviceSize' => ActiveForm::SIZE_SMALL],
//                        'fieldConfig' => [
//                            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
//                            'horizontalCssClasses' => [
//                                'label' => 'col-sm-3 col-md-3',
//                                'offset' => 'col-sm-offset-1 col-sm-offset-2',
//                                'wrapper' => 'col-sm-9',
//                                'error' => '',
//                                'hint' => '',
//                            ],
//                        ],
//                                    'enableAjaxValidation' => true,
//                        'id' => 'amz_product_quality'
    ]);
    ?>


    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Document metadata</h4>
    </div>
    <div class="modal-body">

        <?php
        echo $this->render('_languages_tab', [
            'model' => $model,
            'form' => $form,
        ]);
        ?>


        <?= $form->field($model, 'code')->textInput() ?>
        <?= $form->field($model, 'video_document_id')->hiddenInput(['id' => "videoContent"]) ?>

        <?php
        echo \common\widgets\dropzone\DropZoneYii2::widget([
            'dropzoneName' => 'videoDropzone',
            'inputId' => 'videoContent',
            'mockFiles' => $model->makeMockFiles([$model->videoDocument]),
            'uploadUrl' => '/document/upload',
            'deleteUrl' => '/document/deleteupload',
            'enableMetadataEdit' => false,
            'options' => [
                'maxFilesize' => 100,
                'maxFiles' => 1,
//                'acceptedFiles' => 'image/*'
            ]
        ]);
        ?>
    </div>
    <div class="modal-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>

    <?php ActiveForm::end(); ?>
</div>

