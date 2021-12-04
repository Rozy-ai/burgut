<?php 
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\LoginAsset;
use common\widgets\Alert;

LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <?php $this->head() ?>
        
        <!--<link rel="shortcut icon" href="favicon.ico" /> -->
    </head>
<?php $this->beginBody() ?>

    <body class=" login">
        <div class="container">
            <div class="row">    
        <div class="col-12 col-md-6">
        
            <div class="row">
                <div class="offset-md-3 col-md-6 d-none d-md-block">
                    <img src="/source/img/traffic-barrier.png" class="img-fluid" alt="barer">
                </div>
            </div>
            
<!--
            <a href="index.html">
                <img src="../assets/pages/img/logo-big.png" alt=""> </a>-->
 
        <h1 class="text-center">Сайт находится в разработке</h1>
        <p class="text-center"><a href="mailto:info@turkmenportal.com">info@turkmenportal.com</a></p>

          </div>
          <div class="col-12 col-md-6">
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <div class="logo">
                    <img src="/source/img/takykcesme logo.png" class="img-fluid" alt="logo">
                </div>
               </div>
            </div>
              <div class="content">
                <div class="row">
                    <div class="offset-md-2 col-md-8">
                               <?=$content?>     
                    </div>
                </div>
        </div>
          </div>
           </div>
        </div>
        
        
        
        <?php $this->endBody() ?>
    </body>
</html>

<?php $this->endPage() ?>