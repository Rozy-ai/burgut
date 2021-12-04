<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ShowWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="show-wrapper-form">

    <?php $form = ActiveForm::begin([
        'id' => 'show-form',
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <?php
    echo \yii\bootstrap\Tabs::widget([
        'items' => [
            [
                'label' => 'Common',
                'content' => $this->render('//item/_content', [
                    'model' => $contentItemModel,
                    'form' => $form,
                ]),
//                'active' => true
            ],
            [
                'label' => 'Gallery',
                'content' => $this->render('//item/_gallery', [
                    'model' => $contentItemModel,
                    'form' => $form,
                ]),
//                'options' => ['id' => 'myveryownID'],
            ],
            [
                'label' => 'Other details',
                'content' => $this->render('_show_form', [
                    'model' => $model,
                    'form' => $form,
                ]),
//                'options' => ['id' => 'myveryownID'],
            ]
        ]
    ]);
    ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
