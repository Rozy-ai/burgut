<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\EventToTeamWrapper */

$this->title = Yii::t('app', 'Create Event To Team Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Event To Team Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-to-team-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
