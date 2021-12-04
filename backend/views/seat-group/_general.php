<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SeatGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seat-group-form">


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


    <?php
    $locations = \common\models\wrappers\LocationWrapper::find()->multilingual()->all();
    $data = [];
    foreach ($locations as $location) {
        if ($location->getChildrenCount() == 0) {
            $data[$location->id] = $location->fullTitle;
        }
    }
    ?>

    <?php
    echo $form->field($model, 'location_id')->widget(\kartik\select2\Select2::classname(), [
        'data' => $data,
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

</div>
