<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$catCode = '';
if (isset($modelCategory)) {
    $catCode = $modelCategory->code;
    $this->title = $title = $modelCategory->name;
    $this->params['breadcrumbs'] = $modelCategory->getBreadcrumbs();
}

$dataProvider = $searchModel->search([]);
?>
<div class="container bg-white">
    <div class="row">
        <div class="col-md-12">
            <div class="news-list pd-50">
                <?= \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'id' => 'item-list',
                    'itemView' => '_item_view',
                    'viewParams' => [],
                    'itemOptions' => ['class' => 'item'],
                    'layout' => "{items}\n{pager}",
                ]); ?>
            </div>
        </div>
    </div>
</div>
