<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


if (isset($modelCategory)) {
    $this->title = $title = $modelCategory->name;
    $this->params['breadcrumbs'] = $modelCategory->getBreadcrumbs();
}

$dataProvider = $searchModel->search([]);
?>

<div class="page-header">
    <div class="container">
        <h1 class="page-title text-center"><?php echo $title; ?></h1>
    </div>
</div>


<!-- Item Page -->
<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-8">
            <div class="row">

                <?= \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'id' => 'item-list',
                    'itemView' => '_view',
//                    'layout' => "{items}\n{pager}",
                    'viewParams' => [],
                    'itemOptions' => ['class' => 'item'],
                    'layout' => "{items}\n{pager}",
//                    'sorter' => [
//                        'class' => 'rsr\yii2\ButtonDropdownSorter',
//                        'label' => 'Sort Items',
//                    ],
                ]); ?>
            </div>
        </div>
        <div class="col-md-4">


            <div class="sidebox">
                <?php
                echo \common\widgets\items\listview\ListWidget::widget([
                    'category' => 'publications',
                    'view' => 'sidelist',
                    'limit' => 6
                ]);
                ?>
            </div>
        </div>
    </div>
</div>

