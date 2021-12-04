<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\CategoryFieldWrapper */

$this->title = Yii::t('app', 'Create Category Field Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Category Field Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-field-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
