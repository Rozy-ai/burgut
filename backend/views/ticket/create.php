<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\TicketWrapper */

$this->title = Yii::t('app', 'Create Ticket Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ticket Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
