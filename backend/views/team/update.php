<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\TeamWrapper */

$this->title = Yii::t('app', 'Update Team Wrapper: {name}', [
    'name' => $contentItemModel->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Team Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $contentItemModel->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="team-wrapper-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'contentItemModel' => $contentItemModel,
    ]) ?>

</div>
