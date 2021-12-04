<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\MainAsset;
use common\widgets\Alert;

\frontend\assets\AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= Html::encode("Nesipetsin Payment: " . $this->title) ?></title>
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>

        <?php
        // $favicon = Yii::getAlias('@web') . '/source/img/favicon.ico';
        ?>

        <link rel="shortcut icon" type="image/ico" href="<?= $favicon ?>"/>
        <link rel="stylesheet" type="text/css" href="css/animate.css">
    </head>


    <body>
    <?php $this->beginBody() ?>
    <div id="preloader"></div>

    <div class="content">
        <?= $content ?>
    </div>

    <!-- Go to top button -->
    <div id="back-to-top" class="fa fa-arrow-circle-up"></div>
    <div id="pause-player" class="fa fa-play-circle"></div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>