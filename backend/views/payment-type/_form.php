<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\PaymentTypeWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-type-wrapper-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo \yii\bootstrap\Tabs::widget([
        'items' => [
            [
                'label' => 'Common',
                'content' => $this->render('_general', [
                    'model' => $model,
                    'form' => $form,
                ]),
//                'active' => true
            ],
//            [
//                'label' => 'Gallery',
//                'content' => $this->render('_gallery', [
//                    'model' => $model,
//                    'form' => $form,
//                ]),
////                'options' => ['id' => 'myveryownID'],
//            ]
        ]
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
