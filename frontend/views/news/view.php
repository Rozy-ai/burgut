<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ItemWrapper */

$this->title = $model->title;
$categoryModel = $model->category;
if (isset($categoryModel) && $categoryModel->top == true) {
    $this->params['breadcrumbs'] = $categoryModel->getBreadcrumbs(true);
}
$this->params['breadcrumbs'][] = Yii::$app->controller->truncate($model->title, 8, 65);


$href = $model->url;
$author = (isset($model->author) && strlen(trim($model->author)) > 0) ? $model->author : $model->create_username;
$date = $model->renderDateToWord($model->date_created);

?>
<!-- product-details-area are start-->
<section class="partners">
    <div class="container bg-white">
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row pd-50">
            <!-- BEGIN CONTENT -->
            <div class="col-md-8 col-sm-12">
                <h1><?= Html::encode($model->title) ?></h1>
                <div class="content-page mb-40">
                    <div class="blog_date"><?= $date ?></div>
                    <p><?= $model->content ?></p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <?php
                echo common\widgets\lastnews\LastNews::widget([
                    'category' => 'news',
                    'view' => '_recent_news',
                    'limit' => 5,
                ]);
                ?>
            </div>
        </div>
    </div>
</section>
