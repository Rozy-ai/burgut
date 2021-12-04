<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="competition-result-bracket">
    <?php
    echo \common\widgets\bracketjs\Bracket::widget([
        'competition' => $model,
        'type' => 'single',
    ]);
    ?>
</div>

