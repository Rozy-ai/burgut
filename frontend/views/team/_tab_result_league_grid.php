<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<?php

$eventToParticipantSearch = new \common\models\search\EventToParticipantSearch();
$eventToParticipantSearch->team_id = $model->id;
$dataProvider = $eventToParticipantSearch->searchForLeague([]);


if ($dataProvider->getCount() > 0) { ?>

    <?php Pjax::begin(['id' => 'pjax-competition-league-grid-' . uniqid(), 'timeout' => 5000]); ?>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        "filterSelector" => "#result-season-selector",
        'tableOptions' => ['class' => 'table table-striped'],
        "summary" => '',
        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
        'columns' => [
            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'participant',
                'value' => function ($model) {
                    $name = $model->getCandidateName();
                    if (isset($name))
                        return $name;
                },
                'format' => 'html',
            ],
            [
                'options' => ['width' => '120px'],
                'attribute' => 'event_count',
                'format' => 'html',
            ],
            [
                'options' => ['width' => '120px'],
                'attribute' => 'sum_score_for',
                'format' => 'html',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
<?php } ?>
