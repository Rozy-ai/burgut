<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\wrappers\BannerTypeWrapper */

$this->title = Yii::t('app', 'Create Banner Type Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banner Type Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-type-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
