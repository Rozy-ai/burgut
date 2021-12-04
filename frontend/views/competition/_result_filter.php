<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<div id="filter-form">
    <?php
    echo Html::activeDropDownList($searchModel, 'season_id', $searchModel->getRelatedSeasonList(),['id'=>'result-season-selector']);
    ?>
</div>