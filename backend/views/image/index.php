<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $searchModel->getTypeText();
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-wrapper-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Add'), ['create', 'type' => $searchModel->type], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            [
                'options' => ['width' => '180'],
                'attribute' => '_image',
                'value' => function ($model) {
                    $path = $model->getThumbPath(150, 150);
                    return \yii\helpers\Html::img($path, ['alt' => '', 'class' => 'img-responsive bordered']);
                },
                'format' => 'raw',
            ],
            'title',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {crop}',
                'headerOptions' => ['width' => '100px', 'class' => 'activity-view-link'],
                'contentOptions' => ['style' => 'text-align:right'],
                'buttons' => array(
                    'crop' => function ($url, $model, $key) {
                        $sizes = $model->getSizeByType($model->type);
                        if (isset($sizes)) {
                            $returnUrl = \yii\helpers\Url::toRoute(['/image/index', 'type' => $model->type]);
                            if (isset($sizes) && is_array($sizes)) {
                                $sizes = serialize($sizes);
                            }

                            $documents = $model->documents;
                            if (isset($documents) && count($documents) > 0) {
                                return Html::a('<span class="fa fa-crop"></span>', \yii\helpers\Url::toRoute(['/document/crop', 'id' => $documents[0]->id, 'ratios' => $sizes, 'returnUrl' => $returnUrl]), [
                                    'title' => Yii::t('yii', 'Crop'),
                                ]);
                            }
                        }
                        return false;
                    },
                ),
                'options' => ['width' => '120'],
            ],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?></div>
