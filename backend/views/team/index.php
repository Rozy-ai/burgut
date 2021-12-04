<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TeamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Team Wrappers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-wrapper-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Team Wrapper'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'content_item_id',
                'value' => function ($model) {
                    $contentModel = $model->loadContent();
                    if (isset($contentModel))
                        return $contentModel->title;
                },
                'format' => 'html',
            ],

            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'category_id',
                'value' => function ($model) {
                    $category = $model->category;
                    if (isset($category))
                        return $category->name;
                },
                'format' => 'html',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
