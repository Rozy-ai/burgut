<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\assets\MainAsset;
use common\widgets\Alert;

MainAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= Html::encode($this->title) ?></title>
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>

        <?php
        // $favicon = Yii::getAlias('@web') . '/source/img/favicon2.ico';
        ?>

        <link rel="shortcut icon" type="image/ico" href="<?= $favicon ?>"/>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,700i&amp;subset=cyrillic-ext"
              rel="stylesheet">
    </head>


    <body>
    <?php $this->beginBody() ?>
    <div class="header-wrapper">
        <?= $this->render('//common/header',['test'=>'test']) ?>
    </div>
    <?= $content ?>
    <?= $this->render('//common/footer',['test'=>'test']) ?>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>