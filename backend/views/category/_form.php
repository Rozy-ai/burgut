<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\CategoryWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-wrapper-form">

    <?php $form = ActiveForm::begin([
        'id' => 'category-form',
        'options' => ['enctype' => 'multipart/form-data']
    ]);

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
            ],
            [
                'label' => 'Fields',
                'content' => $this->render('_fields_tab', [
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
