<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="category-field-form">

    <?php
    $form = ActiveForm::begin([
        'options' => ['id' => 'field-form', 'data-pjax' => true],
//        'enableAjaxValidation' => true,
//        'validationUrl' => \yii\helpers\Url::toRoute('field/dialog')
    ]);
    ?>


    <div class="modal-header">
        <strong class="modal-title"><?php echo Yii::t('app', 'Edit event prices') ?></strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">

        <?= $form->field($model, 'target_model')->textInput(['maxlength' => true]) ?>

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

    </div>

    <div class="modal-footer">
        <?php echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Cancel') ?></button>
    </div>

    <?php ActiveForm::end(); ?>
</div>