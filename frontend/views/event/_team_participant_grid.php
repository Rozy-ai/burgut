<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<div class="col-md-6">
    <?php

    $eventToParticipantSearch = new \common\models\search\EventToParticipantSearch();
    if (isset($eventTeam))
        $eventToParticipantSearch->team_id = $eventTeam->team_id;
    $dataProvider = $eventToParticipantSearch->search([]);

    if ($dataProvider->getTotalCount() > 0) {
        echo '<h4> ' . $eventTeam->team->name . '</h4>';
        ?>

        <?php Pjax::begin(['id' => 'pjax-team-participant-grid-' . uniqid(), 'timeout' => 5000]); ?>
        <?php
        $column = [
            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'participant_id',
                'enableSorting' => false,
                'value' => function ($model) {
                    $name = $model->getCandidateName();
                    if (isset($name))
                        return $name;
                },
                'format' => 'html',
            ],
            [
                'options' => ['width' => '80px'],
                'attribute' => 'score_for',
                'enableSorting' => false,
                'format' => 'html',
            ],
        ];


        $eventToParticipant = new \common\models\wrappers\EventToParticipantWrapper();
        $eventToParticipant->category_id = $eventTeam->category_id;
        $fields = $eventToParticipant->getDynamicFields();

        foreach ($fields as $field) {
            $column[] = ['attribute' => $field->field_name, 'format' => 'html', 'options' => ['width' => '80px']];
        }
        ?>

        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => ['class' => 'table table-striped'],
            "summary" => '',
            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
            'columns' => $column,
        ]); ?>

        <?php Pjax::end(); ?>
    <?php } ?>
</div>
