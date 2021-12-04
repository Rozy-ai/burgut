<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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
if (!isset($view)){
    if ($catCode == 'blog'){
        $view = 'blog-list';
    } elseif ($catCode == 'our_works'){
        $view = 'portfolio-list';
    } elseif ($catCode == 'partners'){
        $view = 'partners-list';
    } elseif ($catCode == 'magazin'){
        $view = 'category-list';
        $cat = 'magazin';
    }
    elseif ($catCode == 'about'){
        $view = 'about';
    }
    elseif ($catCode == 'categorytest'){
        $view = 'products-list';
    } else {
        if(empty($modelCategory->children)){
            $view = 'products-list';
        } else {
        $view = 'category-list';
         $cat = $catCode;
        }
      
    }
}
// if ($category->getThumbPath()){
//     $cateogryImage = $category->getThumbPath();
// //     background: rgb(204,43,94);
// // background: linear-gradient(90deg, rgba(204,43,94,1) 0%, rgba(117,58,136,1) 100%);
    
// }
?>
<!--     <div class="container-fluid" style="background: #F1F5FB;">
            <div class="container">
        <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Library</a></li>
    <li class="breadcrumb-item active" aria-current="page">Data</li>
  </ol>
</nav>
    </div>
    </div> -->
    <section class="breadcrumb_area_two parallaxie">

        <!-- <div class="overlay"></div> -->
        <div class="container-fluid" style="background: #F1F5FB;">
            <div class="container">
            <div class="row">
<!--                         <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Library</a></li>
    <li class="breadcrumb-item active" aria-current="page">Data</li>
  </ol>
</nav> -->
           <nav aria-label="breadcrumb">
      
                <?php if(isset($this->title) && !isset($this->params['no-title'])) { echo'<h1>'.$this->title.'</h1>'; } ?>
                <?php
                echo Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => Yii::t('app', 'Home'),
                        'url' => Yii::$app->homeUrl,
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
if(!isset($cat)){
       echo $this->render($view,[
            'dataProvider' => $dataProvider,
            'modelCategory' => $modelCategory,
    ]);
   } else {
           echo $this->render($view,[
            'cat' => $cat,
            'dataProvider' => $dataProvider,
            'modelCategory' => $modelCategory,
    ]);
   };


?>