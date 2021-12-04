<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\wrappers\LocationWrapper */

$this->title = Yii::t('app', 'Create Location Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Location Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="location-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
