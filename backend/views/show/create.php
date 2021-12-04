<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ShowWrapper */

$this->title = Yii::t('app', 'Create Show Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Show Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="show-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'contentItemModel' => $contentItemModel,
        'model' => $model,
    ]) ?>

</div>
