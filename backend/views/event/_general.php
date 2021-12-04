<?php

use kartik\widgets\Select2;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\EventWrapper */
/* @var $form yii\widgets\ActiveForm */
?>


<?php
//$data = \common\models\wrappers\CompetitionWrapper::find()
////        ->multilingual()
////    ->joinWith('content')
////        ->joinWith('content cat')
////        ->where(['cat.code' => 'location'])
////        ->limit(20)
//    ->all();
//
//
//$data = \yii\helpers\ArrayHelper::map($data, 'id', 'id');
echo $form->field($model, 'competition_id')->hiddenInput()->label(false)
?>


<?php
echo $form->field($model, 'start_time')->widget(\kartik\datetime\DateTimePicker::classname(), [
    'type' => \kartik\datetime\DateTimePicker::TYPE_COMPONENT_PREPEND,
//        'convertFormat' => true,
    'options' => ['autocomplete' => 'off'],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd-mm-yyyy H:i:s',
//            'startDate' => '01-Mar-2014 12:00 AM',
        'todayHighlight' => true
    ]
]);
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

<?php echo $form->field($model, 'location')->textInput(); ?>

    <div class="event_phase_type">
        <?php
        $phases = \common\models\wrappers\CompetitionPhaseWrapper::find()
            ->where(['competition_id' => $model->competition_id])
            ->all();

        $phasesData = \yii\helpers\ArrayHelper::map($phases, 'id', function ($phase) {
            return $phase->name . ' (' . $phase->getTypeText() . ')';
        });
        $phaseTypeList = [];
        foreach ($phases as $phase) {
            $phaseTypeList[$phase->id] = ['data-type' => $phase->type];
        }
        echo $form->field($model, 'competition_phase_id')->dropDownList($phasesData, ['options' => $phaseTypeList]);
        ?>
    </div>

<?php
$initial_sources_css = 'hidden';
$initial_groups_css = '';
if (isset($model->type) && $model->type == \common\models\wrappers\CompetitionPhaseWrapper::TYPE_PLAYOFF) {
    $initial_sources_css = "";
    $initial_groups_css = "hidden";
}
?>

    <div class="event_sources <?= $initial_sources_css ?>">
        <?php
        echo $form->field($model, 'sources')->widget(Select2::classname(), [
            'data' => $model->getSourceEventList(),
            'options' => [
                'placeholder' => 'Select 2 source event ...',
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'multiple' => true,
                'maximumSelectionLength' => 2
            ],
        ])->label(Yii::t('app', 'Source events'));
        ?>
    </div>


<!--    <div class="event_groups --><?//= $initial_groups_css ?><!--">-->
    <div class="event_groups">
        <?php
        $groups = \common\models\wrappers\CompetitionGroupWrapper::find()
            ->where(['competition_id' => $model->competition_id])
//    ->where(['season_id' => $model->season_id])
            ->all();

        $groups = \yii\helpers\ArrayHelper::map($groups, 'id', 'name');
        if (isset($groups) && count($groups) > 0)
            echo $form->field($model, 'competition_group_id')->dropDownList($groups, ['prompt' => Yii::t('backend', '--Select Group--')]);
        ?>
    </div>


<?php
$script = <<< JS
$(document).on('change', '.event_phase_type select', function() {

    debugger;
    var type=$(this).find("option:selected" ).data('type');
    var event_sources=$(this).parents('form').find('.event_sources');
    var event_groups=$(this).parents('form').find('.event_groups');
    $('select#eventwrapper-sources').val('').trigger('change');
    event_sources.removeClass('hidden');
    if(type==2){
        event_sources.slideDown();      
        // event_groups.slideUp();      
    }else{
        event_groups.slideDown();      
        // event_sources.slideUp();      
    }
});

JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>