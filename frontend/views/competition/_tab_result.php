<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="event-to-seat-wrapper-index">

    <?php
    echo $this->render('_tab_result_league', [
        'model' => $model,
    ]);

    echo $this->render('_tab_result_bracket', [
        'model' => $model,
    ]);
    ?>

</div>
