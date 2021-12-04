<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\EventWrapper */

$competition = $model->competition;
$competition_name = isset($competition) ? $competition->loadContent()->title : $model->id;

$this->title = Yii::t('app', 'Update Event: ({name})', [
    'name' => $competition_name,
]);


$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Competitions'), 'url' => \yii\helpers\Url::to(['competition/index'])];
$this->params['breadcrumbs'][] = ['label' => $competition_name, 'url' => \yii\helpers\Url::to(['competition/update', 'id' => $competition->id])];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $model->getName();
?>
<div class="event-wrapper-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
