<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\wrappers\MerchantWrapper */

$this->title = Yii::t('app', 'Create Merchant Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Merchant Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="merchant-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
