<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\CompetitionWrapper */

$this->title = Yii::t('app', 'Create Competition Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Competition Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="competition-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'contentItemModel' => $contentItemModel,
    ]) ?>

</div>
