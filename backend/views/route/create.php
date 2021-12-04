<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\wrappers\RouteWrapper */

$this->title = Yii::t('app', 'Create Route Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Route Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="route-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
