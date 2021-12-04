<?php

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


//if (isset($modelCategory)) {
$this->title = $title = Yii::t('app', 'Federations');
//}

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Federations'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

$dataProvider = $searchModel->search([]);
?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="layer">
                <div class="header">
                    <h3 class="headerColor">
                        <?php
                        echo $title;
                        ?>
                    </h3>
                </div>
                <div class="row">
                    <?= \yii\widgets\ListView::widget([
                        'dataProvider' => $dataProvider,
                        'id' => 'item-list',
                        'itemView' => '_view',
                        'viewParams' => [],
                        'itemOptions' => ['class' => 'item'],
                        'layout' => "{items}\n{pager}",
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="layer">
                <div class="header">
                    <h3 class="headerColor">
                        <?php echo Yii::t('app', 'Competitions') ?>
                    </h3>
                </div>

                <?php
                //                echo \common\widgets\items\listview\ListWidget::widget([
                //                    'category' => 'competitions',
                //                    'view' => 'sidelist',
                //                    'limit' => 6
                //                ]);
                ?>
            </div>
        </div>
    </div>
</div>

