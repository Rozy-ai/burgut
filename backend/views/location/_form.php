<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\LocationWrapper */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="location-wrapper-form">

    <?php $form = ActiveForm::begin([
        'id' => 'location-form',
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
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

            [
                'label' => 'Gallery',
                'content' => $this->render('_gallery', [
                    'model' => $model,
                    'form' => $form,
                ]),
//                'options' => ['id' => 'myveryownID'],
            ],
            [
                'label' => 'Seats',
                'content' => $this->render('_seats_tab', [
                    'model' => $model
                ]),
//                'active' => true
            ],
        ]
    ]);
    ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
