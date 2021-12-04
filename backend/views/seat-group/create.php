<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\SeatGroupWrapper */

$this->title = Yii::t('app', 'Create Seat Group Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Seat Group Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seat-group-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
