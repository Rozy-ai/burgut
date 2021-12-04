<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\wrappers\AlbumWrapper */

$this->title = Yii::t('app', 'Create Album Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Album Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="album-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
