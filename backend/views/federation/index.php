<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\FederationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Federation Wrappers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="federation-wrapper-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    $categories = \common\models\wrappers\CategoryWrapper::find()->all();
    $filter = [];
    foreach ($categories as $cat) {
        $filter[$cat->id] = $cat->name;
    }
    // echo $this->render('_search', ['model' => $searchModel]);
    ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Federation Wrapper'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            [
//                'options' => ['max-width' => '120px'],
//                'attribute' => 'category_id',
//                'filter' => $filter,
////                'filter' => \yii\helpers\ArrayHelper::map(\common\models\wrappers\CategoryWrapper::find()->asArray()->all(), 'id', 'name'),
//                'value' => function ($model) {
//                    $category = $model->category;
//                    if (isset($category))
//                        return $category->name;
//                },
//                'format' => 'html',
//            ],
            [
                'attribute' => 'title',
                'value' => function ($data) {
                    return Yii::$app->controller->truncate($data->title, 10, 80);
                },
                'format' => 'html',
                'options' => ['max-width' => '80px']
            ], [
                'attribute' => 'description',
                'value' => function ($data) {
                    return Yii::$app->controller->truncate(strip_tags($data->content), 10, 100);
                },
                'format' => 'html',
                'options' => ['max-width' => '230px']
            ],

//            [
//                'attribute'=>'text',
//                'value' => function ($data) {
//                   return mb_substr($data->text,0,250).' ...';
//                },
//                'format' => 'html',
//                'options' => ['width' => '280px']
//            ],
//            'text:ntext',
//            'alias',

            'status',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete} ',
                'headerOptions' => ['width' => '100px', 'class' => 'activity-view-link',],
                'contentOptions' => ['style' => 'text-align:right'],
                'buttons' => array (
//                    'crop' => function ($url, $model, $key) {
//                        $sizes = $model->getSizeByType($model->type);
//                        $returnUrl = \yii\helpers\Url::toRoute(['/federation/index', 'type' => $model->type]);
//                        if (isset($sizes) && is_array($sizes)) {
//                            $sizes = serialize($sizes);
//                        }
//
//                        $documents = $model->documents;
//                        if (isset($documents) && count($documents) > 0) {
//                            return Html::a('<span class="fa fa-crop"></span>', \yii\helpers\Url::toRoute(['/document/crop', 'id' => $documents[0]->id, 'ratios' => $sizes, 'returnUrl' => $returnUrl]), [
//                                'title' => Yii::t('yii', 'Crop'),
//                            ]);
//                        } else {
//                            return false;
//                        }
//                    },
                ),
                'options' => ['width' => '120'],
            ],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
