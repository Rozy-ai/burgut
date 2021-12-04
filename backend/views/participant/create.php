<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ParticipantWrapper */

$this->title = Yii::t('app', 'Create Participant Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Participant Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participant-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
