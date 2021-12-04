<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<?php
if ($model->is_team) {
    $eventToTeamSearch = new \common\models\search\EventToTeamSearch();
    $eventToTeamSearch->competition_id = $model->id;
    if (isset($competitionGroup))
        $eventToTeamSearch->competition_group_id = $competitionGroup->id;
    $dataProvider = $eventToTeamSearch->searchForLeague([]);
} else {
    $eventToParticipantSearch = new \common\models\search\EventToParticipantSearch();
    if (isset($competitionGroup))
        $eventToParticipantSearch->competition_group_id = $competitionGroup->id;
    $eventToParticipantSearch->competition_id = $model->id;
    $dataProvider = $eventToParticipantSearch->searchForLeague([]);
}


if ($dataProvider->getCount() > 0) { ?>

    <?php Pjax::begin(['id' => 'pjax-competition-league-grid-' . uniqid(), 'timeout' => 5000]); ?>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-striped'],
        "summary" => '',
        "filterSelector" => "#result-season-selector",
        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
        'columns' => [
            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'participant',
                'value' => function ($model) {
                    $name = $model->getCandidateName();
                    if (isset($name)) {
                        return $name;
                    }
                },
                'format' => 'html',
            ],
            [
                'options' => ['max-width' => '50px'],
                'attribute' => 'event_count',
                'format' => 'html',
            ],

            [
                'options' => ['max-width' => '50px'],
                'attribute' => 'total_win',
                'format' => 'html',
            ],
            [
                'options' => ['max-width' => '50px'],
                'attribute' => 'total_draw',
                'format' => 'html',
            ],
            [
                'options' => ['max-width' => '50px'],
                'attribute' => 'total_loss',
                'format' => 'html',
            ],
            [
                'options' => ['max-width' => '50px'],
                'attribute' => 'sum_score_for',
                'format' => 'html',
            ],
            [
                'options' => ['max-width' => '50px'],
                'attribute' => 'sum_score_against',
                'format' => 'html',
            ],
            [
                'options' => ['max-width' => '50px'],
                'attribute' => 'sum_point',
                'format' => 'html',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
<?php } ?>
