<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\EventToSeatWrapper */

$this->title = Yii::t('app', 'Create Event To Seat Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Event To Seat Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-to-seat-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
