<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
use yii\bootstrap\ActiveForm;

$ownerDetails = \common\models\OwnerContact::find()->one();

$language = yii::$app->language;
switch ($language){
    case 'en': $logo = 'logo-en.png'; break;
    case 'ru': $logo = 'logo-ru.png'; break;
    default: $logo = 'logo-tm.png'; break;
}



// $category = \common\models\wrappers\CategoryWrapper::find()->where(['code' => 'services'])->one();
// $categorysecond = \common\models\wrappers\CategoryWrapper::find()->where(['code' => 'our_works'])->one();
// $catId = $category->id;
// $catIdsecond = $categorysecond->id;
// $services = \common\models\wrappers\ItemWrapper::find()->where(['category_id' => $catId, 'status' => '1'])->orderBy('Rand()')->limit(8)->all();
// $works = \common\models\wrappers\ItemWrapper::find()->where(['parent_category_id' => $catIdsecond, 'status' => '1'])->orderBy('Rand()')->all();
?>
  <header>
    <div class="container">
      <div class="row header_top">
        <div class="col-sm-0 col-md-8">
          <p class="header_info">
            <?php 
            $string = $ownerDetails->my_phone;
            $phones   = preg_split('/\s+/', $string); 
             ?>
           <i class="fa fa-phone"></i> 
           <?php foreach ($phones as $phone) : ?>
<a href="tel: <?= $phone ?>"> <?= $phone?> ;</a>
            <?php endforeach; ?>
            </p>
       <!--    <p class="header_info"> <i class="fa fa-envelope"> </i> <a href="mailto:<?php// echo $ownerDetails->my_email ?>">
              <?php// echo $ownerDetails->my_email ?></a></p> -->
         
        </div>
        <div class="lang_img col-sm-12 col-md-4 d-flex justify-content-end language_box">
                              
                        <?php
                        echo \common\widgets\language\LanguageSwitcherDropdownWidget::widget([
                           // 'showFlags' => true
                        ]);0
                        
                        ?>
                 
        </div>
      </div>
    </div>

  </header>
  <div class="container bottom_header">
    <div class="row">

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <div class="col-4 logo">
            <a class="navbar-brand" href="<?= Url::to(['/']) ?>"><img src="/source/img/logo.jpg" alt="Logo"></a>
          </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php
                echo Menu::widget([
                    'items' => $menuItems,
                    'options' => [
                        'class' => 'col-12 navbar-nav d-flex justify-content-around',
                    ],
                    'linkTemplate' => "<a href=\"{url}\" class='nav-link ' role=\"button\"  aria-expanded=\"false\">{label}</a>",
                    'submenuTemplate' => "\n<ul class='dropdown-menu' aria-labelledby=\"navbarDropdown\"><li><a class='dropdown-item' href=\"{url}\">\n{items}\n</a></li></ul>\n",
                    'itemOptions' => ['class' => 'nav-item dropdown'],
                ]);
                ?>
            </div>
          <div class="col-1 icon d-flex justify-content-end">
            <!-- BEGIN TOP SEARCH -->
            
            <!-- END TOP SEARCH -->
                   
                    <div class="input-group">             
  <button type="button" id="show" class="call_btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
      <span class="fa fa-search"></span>
    </button>



<!--     <button type="button" id="hide" class="call_btn">
      <span class="fa fa-search"></span>
    </button> -->


 
     
   <!--    <input type="submit" class="search_submit"> -->
      
      </div>

    <!--         <a href=""><i class="fa fa-user"></i></a>
            <a href=""><i class="fa fa-shopping-cart"></i></a> -->
          </div>        
        </div>
    </nav>
        </div>
  </div>

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static" data-bs-focus="false">
  <div class="modal-dialog">
    <div class="modal-content">
<!--       <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div> -->
      <div class="modal-body">
        <button type="button" class="close_modal" data-bs-dismiss="modal"><i class="fa fa-remove"></i></button>
        <span class="i_input_search"><i class="fa fa-search"></i></span>
                <?php $form = ActiveForm::begin(['action'=>['site/search'],'method'=>'get']); ?>
               <input type="text" placeholder="<?=Yii::t('app','Search')?>" class="search"  name="query">
       <button type="submit" class="search_submit"><?= Yii::t('app','Search') ?></button>
        <?php ActiveForm::end(); ?>
      </div>
<!--       <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>



