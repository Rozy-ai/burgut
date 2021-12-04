<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\BannerWrapper */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Banner Wrapper',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banner Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="banner-wrapper-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
