<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\CompetitionWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="competition-wrapper-form" xmlns="http://www.w3.org/1999/html">
    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo $this->render('//item/_content', [
        'model' => $contentItemModel,
        'form' => $form,
    ]);
    ?>
    <hr>

    <?php
    echo $this->render('//item/_gallery', [
        'model' => $contentItemModel,
        'form' => $form,
    ]);
    ?>
    <hr>


    <?= $form->field($model, 'category_id')->dropDownList($model->getSportTypeList()) ?>


    <?= $form->field($model, 'tagNames')->widget(\dosamigos\selectize\SelectizeTextInput::className(), [
        // calls an action that returns a JSON object with matched
        // tags
        'loadUrl' => ['tag/list'],
        'options' => ['class' => 'form-control'],
        'clientOptions' => [
            'plugins' => ['remove_button'],
            'valueField' => 'name',
            'labelField' => 'name',
            'searchField' => ['name'],
            'create' => true,
        ],
    ])->hint('Use commas to separate tags') ?>


    <?= $form->field($model, 'season_id')->dropDownList($model->getSeasonsList()) ?>

    <?= $form->field($model, 'gender')->dropDownList($model->getGenderOptions()) ?>

    <?= $form->field($model, 'is_team')->checkbox() ?>
    <?= $form->field($model, 'is_international')->checkbox() ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
