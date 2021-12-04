<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\AlbumWrapper */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Album Wrapper',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Album Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="album-wrapper-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'menuItemSearchModel' => $menuItemSearchModel,
        'menuItemDataProvider' => $menuItemDataProvider,
    ]) ?>

</div>
