<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="team-to-seat-wrapper-index">


    <?php
    $teamToParticipantSearch = new \common\models\search\TeamToParticipantSearch();
    $teamToParticipantSearch->team_id = $model->id;
    $teamToParticipantSearch->type = \common\models\wrappers\TeamToParticipantWrapper::PARTICIPANT_TYPE_ATHLETE;
    $dataProvider = $teamToParticipantSearch->search([]);
    ?>

    <?php Pjax::begin(['id' => 'pjax-team-to-participant-grid', 'timeout' => 5000]); ?>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        "filterSelector" => "#result-season-selector",
        'tableOptions' => ['class' => 'table table-striped'],
        "summary" => '',
        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
        'columns' => [
            [
                'attribute' => 'participant_id',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->participant->fullName;
                },
            ],
//            [
//                'attribute' => 'type',
//                'value' => function ($model, $key, $index, $widget) {
//                    return $model->getTypeText();
//                },
//            ],
//            [
//                'attribute' => 'status',
//                'value' => function ($model, $key, $index, $widget) {
//                    return $model->getStatusText();
//                },
//            ],
            [
                'attribute' => 'date_joined',
                'options' => ['width' => '120px'],
                'value' => function ($model, $key, $index, $widget) {
                    if (isset($model->date_joined))
                        return \Yii::$app->formatter->asDate($model->date_joined, 'dd-MM-yyyy');
                },
            ],
            [
                'attribute' => 'date_leaved',
                'options' => ['width' => '120px'],
                'value' => function ($model, $key, $index, $widget) {
                    if (isset($model->date_leaved))
                        return \Yii::$app->formatter->asDate($model->date_leaved, 'dd-MM-yyyy');
                },
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>


