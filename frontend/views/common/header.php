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
        <div class="col-sm-0 col-md-6">
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
        <div class="lang_img col-sm-12 col-md-6 d-flex justify-content-end language_box">
        <!--    <form class="d-flex"> -->

<?php $form = ActiveForm::begin([
  'options' => ['class' => 'd-flex'],
  'action'=>['site/search'],
  'method'=>'get']); ?>

        <input style="padding: 4px 10px;" class="form-control me-2" type="search" placeholder="<?=Yii::t('app','Search')?>" aria-label="Search" class="search"  name="query">
                  <div class="col-1 icon d-flex justify-content-end">
                    <div class="input-group">             
  <button type="submit" style="margin-top: 30px" class="call_btn">
      <span class="fa fa-search" style="color: #fff"></span>
    </button>

      
      </div>

          </div>        
     <?php ActiveForm::end(); ?>
                              
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

        </div>
    </nav>
        </div>
  </div>








