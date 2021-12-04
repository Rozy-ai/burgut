<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<?php
if (isset($model) && isset($model->id)) { ?>

    <div class="row">
        <div class="col-md-12">
            <div id="filter-form" class="pull-right">
                <?php echo Html::activeDropDownList($model, 'season_id', $model->getSeasonsList(), ['id' => 'season-selector']); ?>
            </div>
        </div>
    </div>


    <?php
    echo $this->render('_competition_group_grid', ['model' => $model]);

    if (isset($model) && $model->is_team)
        echo $this->render('_competition_team_grid', ['model' => $model]);

    echo $this->render('_competition_participant_grid', ['model' => $model]);

} ?>




