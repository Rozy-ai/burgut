<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\LocationWrapper */
/* @var $form yii\widgets\ActiveForm */

?>
<?= $form->field($model, 'docs')->hiddenInput(['id' => "location"])->label("") ?>
<?php
echo \common\widgets\dropzone\DropZoneYii2::widget([
    'dropzoneName' => 'locationDropzone',
    'inputId' => 'location',
    'mockFiles' => $model->makeMockFiles($model->documents),
    'uploadUrl' => '/document/upload',
    'deleteUrl' => '/document/deleteupload',
    'options' => [
        'maxFilesize' => 100,
        'acceptedFiles' => 'image/*'
    ]
]);
?>

