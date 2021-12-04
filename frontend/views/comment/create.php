<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\wrappers\CommentWrapper */

$this->title = Yii::t('app', 'Create Comment Wrapper');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comment Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
