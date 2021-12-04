<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\wrappers\BannerWrapper */

$this->title = Yii::t('app', 'Create Banner Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banner Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
