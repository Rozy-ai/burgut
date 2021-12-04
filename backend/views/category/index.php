<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Category Wrappers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-wrapper-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Category Wrapper'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'description',
            // 'url_prefix:url',
            // 'related_category_id',
            // 'parent_id',
            [
                'options' => ['max-width' => '120px'],
                'attribute' => 'parent_id',
                'filter' => $filter,

                'value' => function($data){
                    return $data->parent->name ? $data->parent->name : 'Top category';
                }
            ],
             'code',
            // 'top',
            // 'sort_order',
            // 'status',
            // 'date_created',
            // 'date_modified',
            // 'edited_username',
            // 'create_username',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
