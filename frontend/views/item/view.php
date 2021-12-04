
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;


/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ItemWrapper */

$this->title = $model->title;
// $category = $model->category;
// $imageBreadCrumb = $category;
$catCode = '';
if (isset($modelCategory)) {
    $catCode = $modelCategory->code;
    $this->title = $title = $modelCategory->name;
    $this->params['breadcrumbs'] = $modelCategory->getBreadcrumbs();
};
$catCode = $modelCategory->code;
// if ($category->parent_id){
//     while ($category->parent_id){
//         $category = \common\models\wrappers\CategoryWrapper::findOne($category->parent_id);
//         $catCode = $category->code;
//     }
// } else{
//     $catCode = $category->code;
// }
if (isset($modelCategory)) {
    $this->params['breadcrumbs'] = $modelCategory->getBreadcrumbs(true);
}
// $this->params['breadcrumbs'][] = Yii::$app->controller->truncate($model->title, 8, 65);


$href = $model->url;
$author = (isset($model->author) && strlen(trim($model->author)) > 0) ? $model->author : $model->create_username;
$date = $model->renderDateToWord($model->date_created);
if ($catCode == 'products'){
    $view = 'product_view';
} elseif ($catCode == 'blog'){
    $view = 'blog_view';
} elseif ($catCode == 'categorytest'){
    $view = 'product_view';
} else {
    $view = 'product_view';
}


// if ($imageBreadCrumb->getThumbPath()){
    // $style = 'background: url('.$imageBreadCrumb->getThumbPath().') center center no-repeat; height: 500px;margin-top:-50px ;background-size: cover;
    //     background-attachment: fixed;';
// }
?>       

<!-- product-details-area are start-->

<section class="breadcrumb_area_two parallaxie">

        <!-- <div class="overlay"></div> -->
        <div class="container-fluid" style="background: #F1F5FB;">
            <div class="container">
            <div class="row">
           <nav aria-label="breadcrumb">
      
                <?php if(isset($this->title) && !isset($this->params['no-title'])) { echo'<h1>'.$this->title.'</h1>'; } ?>
                <?php
                echo Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => Yii::t('app', 'Home'),
                        'url' => '/',
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'options' => [
                            'class' => 'breadcrumb'
                    ]
                ]);
                ?>
             
            </nav>
            </div>
 
            </div>
        </div>
 
    </section>

<?php
    echo $this->render($view, [
            'model' => $model,
            'contact' => $contact,
            'ownInfo' => $ownInfo,
    ])
?>