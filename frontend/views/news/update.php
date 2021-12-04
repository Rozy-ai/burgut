<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ItemWrapper */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Item Wrapper',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Item Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="item-wrapper-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
