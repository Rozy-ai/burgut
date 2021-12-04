<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\CompetitionPhaseWrapper */

$this->title = Yii::t('app', 'Create Competition Phase Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Competition Phase Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="competition-phase-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
