<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="event-to-seat-wrapper-index">

    <?php
    $competitionGroups = \common\models\wrappers\CompetitionGroupWrapper::find()->where(['competition_id' => $model->id])->all();
    if (count($competitionGroups) > 0) {
        foreach ($competitionGroups as $competitionGroup) {
            if (count($competitionGroups) > 0) {
                echo '<h3> ' . $competitionGroup->name . '</h3>';
            }

            echo $this->render('_tab_result_league_grid', [
                'competitionGroup' => $competitionGroup,
                'model' => $model
            ]);
            ?>
        <?php } ?>
    <?php } else {
        echo $this->render('_tab_result_league_grid', [
            'model' => $model
        ]);
    } ?>
</div>

