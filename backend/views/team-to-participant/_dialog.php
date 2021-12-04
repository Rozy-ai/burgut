<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="category-field-form">

    <?php
    $form = ActiveForm::begin([
        'options' => ['id' => 'team-to-participant-form', 'data-pjax' => true],
//        'enableAjaxValidation' => true,
//        'validationUrl' => \yii\helpers\Url::toRoute('field/dialog')
    ]);
    ?>


    <div class="modal-header">
        <strong class="modal-title"><?php echo Yii::t('app', 'Edit Team Participants') ?></strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <?= $form->field($model, 'team_id')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'type')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'status')->hiddenInput()->label(false) ?>


        <?php
        $participantDesc = empty($model->participant_id) ? '' : \common\models\wrappers\ParticipantWrapper::findOne($model->participant_id)->fullName;
        if ($model->type == \common\models\wrappers\TeamToParticipantWrapper::PARTICIPANT_TYPE_ATHLETE) {
            $url = \yii\helpers\Url::to(['/participant/list', ['gender' => $model->team->gender]]);
        } else {
            $url = \yii\helpers\Url::to(['/participant/list']);
        }

        echo $form->field($model, 'participant_id')->widget(\kartik\select2\Select2::classname(), [
            'initValueText' => $participantDesc,
            'options' => ['placeholder' => 'Search for a participant...'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 1,
                'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax' => [
                    'url' => $url,
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(participant) { return participant.text; }'),
                'templateSelection' => new JsExpression('function (participant) { return participant.text; }'),
                'dropdownParent' => new yii\web\JsExpression('$("#modalteamparticipant")'),
            ],
        ]);
        ?>


        <?php
        echo $form->field($model, 'date_joined')->widget(\kartik\date\DatePicker::classname(), [
            'type' => \kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
            'pluginOptions' => [
//                'min' => time(),
//                'startDate' => "0d",
                'format' => 'dd-mm-yyyy',
            ]
        ]);
        ?>


        <?php
        echo $form->field($model, 'date_leaved')->widget(\kartik\date\DatePicker::classname(), [
            'type' => \kartik\date\DatePicker::TYPE_COMPONENT_APPEND,
            'pluginOptions' => [
//                'min' => time(),
//                'startDate' => "0d",
                'format' => 'dd-mm-yyyy',
            ]
        ]);
        ?>

        <hr>

        <?php
        echo $this->render('_dynamic_content', [
            'model' => $model,
            'form' => $form,
        ]);
        ?>
    </div>

    <div class="modal-footer">
        <?php echo Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= Yii::t('app', 'Cancel') ?></button>
    </div>

    <?php ActiveForm::end(); ?>
</div>