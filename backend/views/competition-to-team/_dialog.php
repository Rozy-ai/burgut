<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="category-field-form">

    <?php
    $form = ActiveForm::begin([
        'options' => ['id' => 'competition-to-team-form', 'data-pjax' => true],
//        'enableAjaxValidation' => true,
//        'validationUrl' => \yii\helpers\Url::toRoute('field/dialog')
    ]);
    ?>


    <div class="modal-header">
        <strong class="modal-title"><?php echo Yii::t('app', 'Edit competition teams') ?></strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">

        <?php
        echo \yii\bootstrap\Tabs::widget([
            'items' => [
                [
                    'label' => 'General',
                    'content' => $this->render('_general', [
                        'model' => $model,
                        'form' => $form,
                    ]),
                ],
                [
                    'label' => 'Dynamic Content',
                    'content' => $this->render('_dynamic_content', [
                        'model' => $model,
                        'form' => $form,
                    ]),
//                'active' => true
                ]
            ]
        ]);
        ?>
    </div>

    <div class="modal-footer">
        <?php echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Cancel') ?></button>
    </div>

    <?php ActiveForm::end(); ?>
</div>