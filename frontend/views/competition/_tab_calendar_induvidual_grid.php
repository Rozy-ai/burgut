<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="event-to-seat-wrapper-index">

    <?php Pjax::begin(['id' => 'pjax-competition-event-grid', 'timeout' => 5000]); ?>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $searchModel->search([]),
        'tableOptions' => ['class' => 'table table-striped'],
        "summary" => '',
        "filterSelector" => "#" . Html::getInputId($searchModel, 'season_id'),
        'columns' => [
            [
                'options' => ['max-width' => '50px'],
                'attribute' => 'start_time',
                'format' => 'html',
            ],
//            [
//                'options' => ['max-width' => '120px'],
//                'attribute' => 'location',
//                'value' => function ($model) {
//                    $location = $model->location;
//                    if (isset($location))
//                        return $location->fullTitle;
//                },
//                'format' => 'html',
//            ],
            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'homeTeam',
                'value' => function ($model) {
                    $canditateName = $model->getSideCanditate(0);
                    if (isset($canditateName)) {
                        return Html::a($canditateName, ['event/view', 'id' => $model->id]);
                    }
                },
                'format' => 'html',
            ],
            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'score',
                'value' => function ($model) {
                    $eventSides = $model->getEventSides();
                    if (isset($eventSides) && isset($eventSides[0]) && isset($eventSides[1])) {
                        return Html::a($eventSides[0]->score_for . ' - ' . $eventSides[1]->score_for, ['event/view', 'id' => $model->id]);
                    }
                },
                'format' => 'html',
            ],
            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'awayTeam',
                'value' => function ($model) {
                    $canditateName = $model->getSideCanditate(1);
                    if (isset($canditateName)) {
                        return Html::a($canditateName, ['event/view', 'id' => $model->id]);
                    }
                },
                'format' => 'html',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>


