<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\TeamWrapper */

$this->title = Yii::t('app', 'Create Team Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Team Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'contentItemModel' => $contentItemModel,
    ]) ?>

</div>
