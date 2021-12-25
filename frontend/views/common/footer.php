<?php
use yii\widgets\Menu;
// use common\models\wrappers\ItemWrapper;
// use yii\bootstrap\ActiveForm;
// use yii\helpers\Html;
// use yii\helpers\Url;


$ownInfo = \common\models\OwnerContact::find()->one();
?>


  <footer>
    <div class="container">
      <div class="row">
        <div class="col left_footer">
          <img src="/img/logo.jpg" alt="">
          <br><br>
          <p style="margin-right: 5%;text-transform:uppercase"><?= yii::t('app', 'site_name') ?>


          </p>
          <br>
        </div>
        <div class="col d-flex justify-content-center">
          <div class="center_footer">
            <h3><?= yii::t('app', 'Pages') ?></h3><br>
            <ul>
                              <?php
                            $menuItems == array_pop($menuItems);

                echo Menu::widget([
                    'items' => $menuItems,
                    'options' => [
                        'class' => '',
                    ],
                    'linkTemplate' => "<a href=\"{url}\"  role=\"button\"  aria-expanded=\"false\"><li>{label}</li></a>",
                    'submenuTemplate' => "\n<a href=\"{url}\"  role=\"button\"  aria-expanded=\"false\"><li>{items}</li></a>\n"
                ]);
                ?>
                    <a href="/site/a/privacy"> <li><?= yii::t('app', 'Privacy Policy') ?></li></a>
              
            </ul>
          </div>
        </div>
        <div class="col d-flex justify-content-center">
          <div class="right_footer">
            <h3><?= yii::t('app', 'Contact us') ?></h3>
            <br>

            <i class="fa fa-map-marker"></i> <span><?= yii::t('app', 'Address') ?>: <p>
              <?= $ownInfo->my_address ?></p></span>
 <?php 
            $string = $ownInfo->my_phone;
            $phones   = preg_split('/\s+/', $string); 
             ?>
            <i class="fa fa-phone"></i><span><?= yii::t('app', 'Phones') ?>:
             <?php foreach ($phones as $phone) : ?>
              <p style="margin-bottom: 0px"><a href="tel: <?=  $phone ?>">
              <?=  $phone ?></a> </p> 
            <?php endforeach; ?>
            </span> 

        <!--     <i class="fa fa-envelope"></i> <span><?php //echo yii::t('app', 'Email') ?>: <p> <a href="mailto:<?php //echo $ownInfo->my_email ?>">
              <?php //echo $ownInfo->my_email ?></a></p></span> -->

            
          </div>
        </div>
      </div>
    </div>
    <hr>
        <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Yii::t('app','All rights reserved.') ?><?= date('Y') ?> &copy; <?php //CommonInfo::info('footer_working_time') ?><?=yii::t('app', 'site_name')?>

            </div>

        </div>
    </div>
  </footer>
