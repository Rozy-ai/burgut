<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="seat-price-form">

    <?php
    $form = ActiveForm::begin([
        'options' => ['id' => 'seat-group-form', 'data-pjax' => true],
    ]);
    ?>


    <div class="modal-header">
        <strong class="modal-title"><?php echo Yii::t('app', 'Edit event prices') ?></strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">

        <?php
        $languages = $model->languages;
        if (isset($languages)) {
            $items = [];
            foreach ($languages as $key => $lang) {
                $items[] = [
                    'label' => Yii::t('app', $lang),
                    'options' => ['id' => 'tab_seat_group_' . $key],
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
            'options' => ['placeholder' => 'Select a location ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
    </div>
    <div class="modal-footer">
        <?php echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Cancel') ?></button>
    </div>

    <?php ActiveForm::end(); ?>
</div>