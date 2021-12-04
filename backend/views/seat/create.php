<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\SeatWrapper */

$this->title = Yii::t('app', 'Create Seat Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Seat Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seat-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
