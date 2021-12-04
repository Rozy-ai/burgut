<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CompetitionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Competition Wrappers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col-md-9 col-xs-12">
            <div class="layer">
                <div class="header">
                    <h3 class="headerColor">
                        <?php
                        echo $this->title;
                        ?>
                    </h3>
                </div>
                <div class="row">
                    <?= \yii\widgets\ListView::widget([
                        'dataProvider' => $dataProvider,
                        'id' => 'competition-list',
                        'itemView' => '_view',
                        'viewParams' => [],
                        'itemOptions' => ['class' => 'item'],
                        'layout' => "{items}\n{pager}",
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>

