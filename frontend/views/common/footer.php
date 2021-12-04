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
          <p><?= yii::t('app', 'Production of various plastic products for household, food and technical purposes.') ?>


          </p>
          <br>
          <hr><br>

          <div class="social_icons">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-send "></i></a>
            <a href="#"><i class="fa fa-youtube-play "></i></a>
            <a href="#"><i class="fa fa-instagram "></i></a>



          </div>

        </div>
        <div class="col d-flex justify-content-center">
          <div class="center_footer">
            <h3><?= yii::t('app', 'Useful') ?></h3><br>
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

            <i class="fa fa-phone"></i><span><?= yii::t('app', 'Phone') ?>: <p><a href="tel: <?= $ownInfo->my_phone ?>">
              <?= $ownInfo->my_phone ?></a> </p> </span> 

            <i class="fa fa-envelope"></i> <span><?= yii::t('app', 'Email') ?>: <p> <a href="mailto:<?= $ownInfo->my_email ?>">
              <?= $ownInfo->my_email ?></a></p></span>

            <i class="fa fa-clock-o"></i> <span><?= yii::t('app', 'Working time') ?>: <p>
              <?= yii::t('app', 'Mon - Sun / 9:00 AM - 8:00 PM') ?></p></span>
          </div>
        </div>
      </div>
    </div>
  </footer>
