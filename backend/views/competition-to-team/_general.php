<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\EventToTeamWrapper */
/* @var $form yii\widgets\ActiveForm */
?>


<?= $form->field($model, 'competition_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'category_id')->hiddenInput()->label(false) ?>

<?php
$teamDesc = empty($model->team_id) ? '' : \common\models\wrappers\TeamWrapper::findOne($model->team_id)->name;

echo $form->field($model, 'team_id')->widget(\kartik\select2\Select2::classname(), [
    'initValueText' => $teamDesc,
    'options' => ['placeholder' => 'Search for a team...'],
    'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 1,
        'language' => [
            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
        ],
        'ajax' => [
            'url' => \yii\helpers\Url::to(['/team/list']),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {q:params.term}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function(team) { return team.text; }'),
        'templateSelection' => new JsExpression('function (team) { return team.text; }'),
        'dropdownParent' => new yii\web\JsExpression('$("#modalcompetitionteam")'),
    ],
]);

if (count($model->getRelatedGroupList()) > 0) {
    echo $form->field($model, 'group_id')->dropDownList($model->getRelatedGroupList());
}

?>
