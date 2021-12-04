<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="event-to-seat-wrapper-index">

    <?php
    $searchModel = new \common\models\search\EventSearch();
    $searchModel->competition_id = $model->id;
    if (isset($_GET['EventSearch'])) {
        $searchModel->setAttributes($_GET['EventSearch']);
    }
//
//    echo $this->render('_calendar_filter', [
//        'searchModel' => $searchModel,
//    ]);

    echo $this->render('_tab_calendar_team_grid', [
        'model' => $model,
        'searchModel' => $searchModel,
    ]);
    ?>

</div>
