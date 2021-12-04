<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\DashboardAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;

DashboardAsset::register($this);
$_SESSION['KCFINDER']['disabled'] = false; // enables the file browser in the admin
$_SESSION['KCFINDER']['uploadURL'] = Yii::getAlias('@uploadsUrl'); // URL for the uploads folder
$_SESSION['KCFINDER']['uploadDir'] = Yii::getAlias('@uploads'); // path to the uploads
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>

<div id="loader"></div>
<div class="wrapper">


    <?= $this->render('//common/header') ?>
    <?= $this->render('//common/sidebar') ?>


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">

            <div style="width: 100%" class="container">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>

                <?= $content ?>
            </div>
        </section>
    </div>


    <?= $this->render('//common/footer') ?>




</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
