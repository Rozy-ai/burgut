<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\SeasonWrapper */

$this->title = Yii::t('app', 'Create Season Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Season Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="season-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
