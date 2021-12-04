<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\CompetitionToParticipantWrapper */
/* @var $form yii\widgets\ActiveForm */
?>


<?= $form->field($model, 'competition_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'category_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'type')->hiddenInput()->label(false) ?>

<?php
$participantDesc = empty($model->participant_id) ? '' : \common\models\wrappers\ParticipantWrapper::findOne($model->participant_id)->fullName;
if ($model->type == \common\models\wrappers\CompetitionToParticipantWrapper::PARTICIPANT_TYPE_ATHLETE) {
    $url = \yii\helpers\Url::to(['/participant/list', ['gender' => $model->competition->gender]]);
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
        'dropdownParent' => new yii\web\JsExpression('$("#modalcompetitionparticipant")'),
    ],
]);
?>


<?php if ($model->competition->is_team) { ?>
    <?php if ($model->type == \common\models\wrappers\CompetitionToParticipantWrapper::PARTICIPANT_TYPE_ATHLETE || $model->type == \common\models\wrappers\CompetitionToParticipantWrapper::PARTICIPANT_TYPE_COACH) { ?>
        <?= $form->field($model, 'team_id')->dropDownList($model->getRelatedTeamList()) ?>
    <?php } ?>
<?php } ?>


<?php
//echo "<pre>";
//print_r($model->getRelatedGroupList());
//echo "</pre>";

if (count($model->getRelatedGroupList()) > 0) {
    echo $form->field($model, 'group_id')->dropDownList($model->getRelatedGroupList(), ['prompt' => Yii::t('app', '--Choose group--')]);
}
?>
