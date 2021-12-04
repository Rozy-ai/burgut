<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PaymentType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="payment-type-form">


    <?php
    $languages = $model->languages;
    if (isset($languages)) {
        $items = [];
        foreach ($languages as $lang) {
            $items[] = [
                'label' => Yii::t('app', $lang),
                'content' => $this->render('_lang', [
                    'model' => $model,
                    'form' => $form,
                    'lang' => $lang,
                ]),
            ];
        }

        echo \yii\bootstrap\Tabs::widget([
            'items' => $items
        ]);
    }
    ?>

    <?= $form->field($model, 'code')->textInput() ?>
    <?= $form->field($model, 'type')->dropDownList($model->getTypeOptions()) ?>
    <?= $form->field($model, 'status')->checkbox() ?>

</div>
