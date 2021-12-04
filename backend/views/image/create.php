<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ImageWrapper */

$this->title = Yii::t('app', 'Create Image Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Image Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
