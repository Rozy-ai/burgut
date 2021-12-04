<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\wrappers\OwnerContactWrapper */

$this->title = Yii::t('backend', 'Owner Contact');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="owner-contact-wrapper-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
