<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\wrappers\CategoryWrapper */

$this->title = Yii::t('app', 'Create Category Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Category Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
