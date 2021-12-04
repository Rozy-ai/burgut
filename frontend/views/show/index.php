<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ShowSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Show');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-header">
    <div class="container">
        <h1 class="page-title text-center">
            <?php
            echo $this->title;
            ?>
        </h1>
    </div>
</div>


<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-8">
            <div class="row">
                <?= \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_view',
//                      'filterModel' => $searchModel,
                    'viewParams' => [],
                    'itemOptions' => ['class' => 'show'],
                    'layout' => "{items}\n{pager}",
                ]); ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="sidebox">
                <?php
                echo \common\widgets\items\listview\ListWidget::widget([
                    'category' => 'location',
                    'view' => 'sidelist',
                    'limit' => 6
                ]);
                ?>
            </div>
        </div>
    </div>
</div>