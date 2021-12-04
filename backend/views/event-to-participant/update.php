<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\EventToParticipantWrapper */

$this->title = Yii::t('app', 'Update Event To Participant Wrapper: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Event To Participant Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="event-to-participant-wrapper-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
