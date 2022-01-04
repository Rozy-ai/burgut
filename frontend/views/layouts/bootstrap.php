<?php

use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php

        ?>
        <title><?= Html::encode($this->title).' - '.Yii::t('app','Site name') ?></title>
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>

        <?php
        $favicon = Yii::getAlias('@web') . '/source/img/logo.jpg';
        ?>

        <link rel="shortcut icon" type="image/ico" href="<?= $favicon ?>"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css" />
        

<!--         <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,700i&amp;subset=cyrillic-ext"
              rel="stylesheet"> -->
        <!-- Global site tag (gtag.js) - Google Analytics -->


    </head>


    <body>
<!--           <header>
    <div class="container">
      <div class="row header_top">
        <div class="col-sm-0 col-md-8">
          <p class="header_info"> <i class="fa fa-phone"></i> (+99312) 958662 </p>
          <p class="header_info"> <i class="fa fa-envelope"> test@gmail.com</i> </p>
          <p class="header_info"> <i class="fa fa-clock-o"> Du-Sb/ 9:00-8:00 </i> </p>
        </div>
        <div class="lang_img col-sm-12 col-md-4 d-flex justify-content-end">
          <img src="img/flag/russia.png" class="float-end" alt="russian">
          <img src="img/flag/turkmenistan.png" class="float-end" alt="turkmen">
          <img src="img/flag/turkmenistan.png" class="float-end" alt="turkmen">
        </div>
      </div>
    </div>

  </header> -->


    <?php

    $catNavItems = [];
    //item menu
    $pageMenuList = \common\models\wrappers\ItemWrapper::find()->joinWith('category cat')->where(['tbl_item.status' => 1, 'tbl_item.is_menu' => 1])->andWhere(['cat.code' => "infopage"])->orderBy('id desc')->all();
    foreach ($pageMenuList as $menu) {
        if (isset($menu->title) && strlen(trim($menu->title)) > 0) {
            $tempItem = array('label' => $menu->title, 'url' => $menu->getUrl());
            $catNavItems[] = $tempItem;
        }
    }

    //categories menu start
    $menuCategories = \common\models\wrappers\CategoryWrapper::find()->where(['top' => 1, 'status' => 1])->andWhere(['OR', 'parent_id is null', 'parent_id=0'])->orderBy('sort_order')->all();
    foreach ($menuCategories as $categoryModel) {
        if (isset($categoryModel->name) && strlen(trim($categoryModel->name)) > 0) {
            $tempItem = array('label' => $categoryModel->name,
             'url' => $categoryModel->getUrl());


            //submenu start
            $subItems = [];
            $categoryItems = \common\models\wrappers\CategoryWrapper::find()->where(['parent_id' => $categoryModel->id, 'top' => 1, 'status' => 1])->all();
            if (isset($categoryItems) && count($categoryItems) > 0) {
                foreach ($categoryItems as $item) {
                    if (isset($item->name) && strlen(trim($item->name)) > 0)
                        $subItems[] = array('label' => $item->name,
                         'url' => $item->getUrl());
                }
            }

            $itemWrappers = \common\models\wrappers\ItemWrapper::find()->where(['category_id' => $categoryModel->id, 'is_menu' => 1, 'status' => 1])->all();
            if (isset($itemWrappers) && count($itemWrappers) > 0) {
                foreach ($itemWrappers as $item) {
                    if (isset($item->title) && strlen(trim($item->title)) > 0)
                        $subItems[] = array('label' => $item->title, 'url' => $item->getUrl());
                }
            }

            if (count($subItems) > 0) {
                $tempItem['template'] = "<a href='{url}' class='nav-link dropdown-toggle' role='button' data-bs-toggle='dropdown'  aria-expanded='false'>{label}</a>";
                $tempItem['items'] = $subItems;
            }
            //submenu end

            $catNavItems[] = $tempItem;
        }
    }
    // $menuItems = [
    //     ['label' => Yii::t('app', 'Home'), 'url' => \yii\helpers\Url::base(true)],
    // ];
//    $menuItems[] =  ['label' => Yii::t('app', 'About Us'), 'url' => ['/site/about']];


    //    $federationModels = \common\models\wrappers\FederationWrapper::find()->where(['status' => \common\models\wrappers\FederationWrapper::STATUS_ENABLED])->all();
    //    $federationSubItems = [];
    //    foreach ($federationModels as $federationModel) {
    //        if (isset($federationModel->title) && strlen(trim($federationModel->title)) > 0)
    //            $federationSubItems[] = array('label' => $federationModel->title, 'url' => $federationModel->getUrl());
    //    }
    //
    //    $federationItem = array('label' => Yii::t('app', 'Federations'), 'url' => \yii\helpers\Url::to(['federation/index']));
    //    if (isset($federationSubItems) && count($federationSubItems) > 0) {
    //        $federationItem['items'] = $federationSubItems;
    //    }


    $menuItems[] = $catNavItems[0];
    //    $menuItems[] = $federationItem;

    unset($catNavItems[0]);
    $menuItems = yii\helpers\ArrayHelper::merge(
        $menuItems,
        $catNavItems
    );
    $menuItems[] = ['label' => Yii::t('app', 'Contact us'), 'url' => ['/site/contact']];
    ?>

    <?php $this->beginBody() ?>

    <?= $this->render('//common/header', ['menuItems' => $menuItems]) ?>
          
<?= Alert::widget([
    'options' => [
                'style' => 'opacity:1',
            ]
]); ?>


    <?= $content ?>
    <span class="basket_fixed">
    <a id="basket" href="<?= Url::to(['cart/add']) ?>" class="btn btn-default cart" data-bs-toggle="modal" data-bs-target="#cart">
                    <i class="fa fa-shopping-cart"></i>
                  </a>
    </span>

    <?= $this->render('//common/footer', ['menuItems' => $menuItems]) ?>

<!-- Modal -->
<div class="modal fade" id="cart" tabindex="-1" aria-labelledby="cart" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h2>Sebet</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Dowam etmek</button>
        <a href="<?= Url::to(['/cart/view']) ?>" class="btn btn-success">Sargamak</a>
        <button type="button" class="btn btn-danger" onclick="clearCart()">Arassalamak</button>
      </div>
    </div>
  </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js" data-cfasync="false"></script>
<script>
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#383b75"
    },
    "button": {
      "background": "#ffffff"
    }
  },
  "theme": "classic"
});
</script>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>