<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\wrappers\PaymentWrapper */

$this->title = Yii::t('app', 'Create Payment Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payment Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
