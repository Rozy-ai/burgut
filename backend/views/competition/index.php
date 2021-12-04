<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CompetitionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Competition Wrappers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="competition-wrapper-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Competition Wrapper'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
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
//            'description',
            [
//                'options' => ['max-width' => '120px'],
                'attribute' => 'location',
                'value' => function ($model) {
                    $category = $model->category;
                    if (isset($category))
                        return $category->name;
                },
                'format' => 'html',
            ],

            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'gender',
                'value' => function ($model) {
                    return $model->getGenderText();
                },
                'format' => 'html',
            ],
//            'category_id',
//            'season_id',
            'is_team',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
