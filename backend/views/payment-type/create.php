<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\PaymentTypeWrapper */

$this->title = Yii::t('app', 'Create Payment Type Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payment Type Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-type-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
