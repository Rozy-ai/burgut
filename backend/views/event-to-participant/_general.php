<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\EventToParticipantWrapper */
/* @var $form yii\widgets\ActiveForm */
?>


<?= $form->field($model, 'event_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'category_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'type')->hiddenInput()->label(false) ?>

<?php
$participantDesc = empty($model->participant_id) ? '' : \common\models\wrappers\ParticipantWrapper::findOne($model->participant_id)->fullName;
if ($model->type == \common\models\wrappers\EventToParticipantWrapper::PARTICIPANT_TYPE_ATHLETE) {
    $url = \yii\helpers\Url::to(['/participant/list', 'gender' => $model->event->competition->gender, 'competition_id' => $model->event->competition_id]);
} else {
    $url = \yii\helpers\Url::to(['/participant/list', 'competition_id' => $model->event->competition_id]);
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
        'dropdownParent' => new yii\web\JsExpression('$("#modaleventparticipant")'),
    ],
]);
?>


<?php if ($model->competition->is_team) { ?>
    <?php if ($model->type == \common\models\wrappers\EventToParticipantWrapper::PARTICIPANT_TYPE_ATHLETE || $model->type == \common\models\wrappers\EventToParticipantWrapper::PARTICIPANT_TYPE_COACH) { ?>
        <?= $form->field($model, 'team_id')->dropDownList($model->getRelatedTeamList()) ?>
    <?php } ?>
<?php } ?>


<?= $form->field($model, 'score_for')->textInput() ?>

<?php if ($model->type == \common\models\wrappers\EventToParticipantWrapper::PARTICIPANT_TYPE_ATHLETE && !$model->event->competition->is_team) { ?>

    <?= $form->field($model, 'score_against')->textInput() ?>

    <?= $form->field($model, 'point')->textInput() ?>

    <?= $form->field($model, 'result_state')->dropDownList($model->getResultStateOptions()) ?>
<?php } ?>

