<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ShowWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="show-wrapper-form">
    <?php
//    $data = \common\models\wrappers\ItemWrapper::find()
////        ->joinWith('translations')
//        ->multilingual()
//        ->joinWith('category cat')
//        ->where(['cat.code' => 'location'])
////        ->limit(20)
//        ->all();
//    $data = \yii\helpers\ArrayHelper::map($data, 'id', 'title');
//    echo $form->field($model, 'location_id')->widget(Select2::classname(), [
//        'data' => $data,
//        'options' => ['placeholder' => 'Select a state ...'],
//        'pluginOptions' => [
//            'allowClear' => true
//        ],
//    ]);
    ?>


    <?= $form->field($model, 'duration_min')->textInput() ?>
</div>
