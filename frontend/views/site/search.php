<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Search Page');
$this->params['breadcrumbs'][] = Yii::t('app', 'Search Page');
?>

<section class="header_page service_list_page" style="<?=$style?>">
    <div class="breadcrumb_overlay">
        <div class="container">
            <div class="page_title">
                <div class="title_text_block">
                    <div class="title_text_decoration"></div>
                    <h1><?=$this->title?></h1>
                    <hr>
                </div>
            </div>
        </div>
</section>
<!-- Item Page -->
<div class="container">
    <div class="row">
        <div class="col-md-9 col-sm-8">
            <h4 class="search_query_title"> <?php echo Yii::t('app', 'search_query') . ' <span class="query">"' . Html::encode($query) . '" </span>'; ?></h4><br><br>
        </div>
    </div>
     <!--    <div class="row"> -->

            <div class="total-event">
                <div class="total-product">
                    <div class="row">
                        <?php \yii\widgets\Pjax::begin(['id' => 'pjax-item-list', 'enablePushState' => false]); ?>
                        <?= \yii\widgets\ListView::widget([
                            'options' => [
                                'class' => 'row',
                            ],
                            'dataProvider' => $searchModel,
                            'viewParams' => ['query' => $query],
                            'id' => 'item-list',
                            'itemView' => '_search_view',
                            'layout' => "{items}\n{pager}",
                            'itemOptions' => ['class' => 'item col-md-4 col-sm-6 col-12 clear3BoxItem']
                        ]); ?>
                        <?php \yii\widgets\Pjax::end(); ?>
                    </div>
                </div>
            
            </div>
    <!--     </div> -->
    </div>

</div>

