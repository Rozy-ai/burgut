<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ItemWrapper */

//$this->title = $model->getName();
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Competitions'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = Yii::$app->controller->truncate($model->name, 8, 65);


$href = $model->url;
//$path = $model->getThumbPath(600, 400, 'w', true);
?>
<!-- product-details-area are start-->

<div class="container">
    <?php
    $competition = $model->competition;
    if ($competition->is_team) {
        echo $this->render('_team_view', [
            'model' => $model,
        ]);
    } else {
        echo $this->render('_induvidual_view', [
            'model' => $model,
        ]);
    }
    ?>
</div>
