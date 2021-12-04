<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\wrappers\MenuWrapper */

$this->title = Yii::t('app', 'Create Menu Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menu Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
