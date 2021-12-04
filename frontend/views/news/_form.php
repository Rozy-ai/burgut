<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ItemWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-wrapper-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'docs')->textInput(['id'=>"item"]) ?>
    <?php
    echo \common\widgets\dropzone\DropZoneYii2::widget([
        'dropzoneName'=>'itemDropzone',
        'inputId'=>'item',
        'mockFiles'=>$model->makeMockFiles($model->documents),
        'uploadUrl'=> '/document/upload',
        'deleteUrl' => '/document/deleteupload',
        'options'=>[
            'maxFilesize'=>100,
            'acceptedFiles'=>'image/*'
        ]
    ]);
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'parent_category_id')->textInput() ?>

    <?= $form->field($model, 'visited_count')->textInput() ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'is_main')->textInput() ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'edited_username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_created')->textInput() ?>

    <?= $form->field($model, 'date_modified')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
