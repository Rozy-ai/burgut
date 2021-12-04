<?php

use frontend\assets\IndexAsset;
use kartik\alert\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

\frontend\assets\IndexAsset::register($this);
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
        // $favicon = Yii::getAlias('@web') . '/source/img/favicon.ico';
        ?>

        <link rel="shortcut icon" type="image/ico" href="<?= $favicon ?>"/>
<!--         <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,700i&amp;subset=cyrillic-ext"
              rel="stylesheet"> -->
        <!-- Global site tag (gtag.js) - Google Analytics -->


    </head>


    <body class="corporate">


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
            $tempItem = array('label' => $categoryModel->name, 'url' => $categoryModel->getUrl());

            //submenu start
            $subItems = [];
            $categoryItems = \common\models\wrappers\CategoryWrapper::find()->where(['parent_id' => $categoryModel->id, 'top' => 1, 'status' => 1])->all();
            if (isset($categoryItems) && count($categoryItems) > 0) {
                foreach ($categoryItems as $item) {
                    if (isset($item->name) && strlen(trim($item->name)) > 0)
                        $subItems[] = array(
                            'label' => $item->name,
                            'url' => $item->getUrl(),
                            'options' => ['class' => 'nav-item'],
                            'template' =>"<a href=\"{url}\" class='nav-link'>{label}</a>",
                        );
                }
            }

            $itemWrappers = \common\models\wrappers\ItemWrapper::find()->where(['category_id' => $categoryModel->id, 'is_menu' => 1, 'status' => 1])->all();
            if (isset($itemWrappers) && count($itemWrappers) > 0) {
                foreach ($itemWrappers as $item) {
                    if (isset($item->title) && strlen(trim($item->title)) > 0)
                        $subItems[] = array(
                                'label' => $item->title,
                            'url' => $item->getUrl()
                        );
                }
            }

            if (count($subItems) > 0) {
                $tempItem['template'] ="<a href=\"#\" class='nav-link dropdown-toggle' data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">{label}</a>";
                $tempItem['items'] = $subItems;
                $tempItem['options'] = ['class' => 'nav-item dropdown submenu'];
            }
            //submenu end

            $catNavItems[] = $tempItem;
        }
    }
    $menuItems = [
        ['label' => Yii::t('app', 'Home'), 'url' => \yii\helpers\Url::base(true)],
    ];
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
    <div class="header-wrapper">
        <?= $this->render('//common/indexHeader', ['menuItems' => $menuItems]) ?>
    </div>



    <?= $content ?>

    <?= $this->render('//common/indexFooter', ['menuItems' => $menuItems]) ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>