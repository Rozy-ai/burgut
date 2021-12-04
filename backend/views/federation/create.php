<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\FederationWrapper */

$this->title = Yii::t('app', 'Create Federation Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Federation Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="federation-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
