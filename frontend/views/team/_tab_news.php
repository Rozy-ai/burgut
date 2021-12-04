<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


if (isset($model)) {
    $searchModel = new \common\models\search\ItemSearch();
    $searchModel->tag_ids = $model->tagIds;
    $dataProvider = $searchModel->search([]);
    ?>

    <div class="row">
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'id' => 'item-list',
            'itemView' => '_item_view',
            'viewParams' => [],
            'itemOptions' => ['class' => 'item'],
            'layout' => "{items}\n{pager}",
        ]); ?>
    </div>

<?php } ?>

