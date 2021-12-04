<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\CategoryFieldWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-field-wrapper-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'field_name')->textInput(['maxlength' => true]) ?>

    <?php
    $languages = $model->languages;
    if (isset($languages)) {
        $items = [];
        foreach ($languages as $lang) {
            $items[] = [
                'label' => Yii::t('app', $lang),
                'options' => ['id' => uniqid()],
                'content' => $this->render('_lang', [
                    'model' => $model,
                    'form' => $form,
                    'lang' => $lang,
                ]),
            ];
        }
//    echo "<pre>";
//    var_dump($items);
        echo \yii\bootstrap\Tabs::widget([
            'items' => $items
        ]);
    }

    ?>

    <?= $form->field($model, 'multilingual')->checkbox() ?>
    <?= $form->field($model, 'html_type')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
