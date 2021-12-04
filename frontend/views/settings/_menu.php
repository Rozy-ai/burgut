<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\Menu;

/** @var dektrium\user\models\User $user */
$user = Yii::$app->user->identity;
$networksVisible = count(Yii::$app->authClientCollection->clients) > 0;

?>

<div class="profile-sidebar">
    <!-- PORTLET MAIN -->
    <div class="portlet light profile-sidebar-portlet ">
        <!-- SIDEBAR USERPIC -->
        <div class="profile-userpic">
             <?= Html::img($user->profile->getAvatarUrl(24), [
                'class' => 'img-responsive',
                'alt'   => $user->username,
            ]) ?>
        <!-- END SIDEBAR USERPIC -->
        
        <!-- SIDEBAR USER TITLE -->
        <div class="profile-usertitle">
            <div class="profile-usertitle-name">  <?= $user->username ?> </div>
            <div class="profile-usertitle-job"> Seller </div>
        </div>
        <!-- END SIDEBAR USER TITLE -->
        <!-- SIDEBAR BUTTONS -->
        <div class="profile-userbuttons">
            <button type="button" class="btn btn-circle green btn-sm">Follow</button>
            <button type="button" class="btn btn-circle red btn-sm">Message</button>
        </div>
        <!-- END SIDEBAR BUTTONS -->
        <!-- SIDEBAR MENU -->
        <div class="profile-usermenu">
            <?= Menu::widget([
                'options' => [
                    'class' => 'nav',
                ],
                'items' => [
                    ['label' => Yii::t('user', 'Profile'), 'url' => ['/user/settings/profile']],
                    ['label' => Yii::t('user', 'Account'), 'url' => ['/user/settings/account']],
                    [
                        'label' => Yii::t('user', 'Networks'),
                        'url' => ['/user/settings/networks'],
                        'visible' => $networksVisible
                    ],
                ],
            ]) ?>
        </div>
        <!-- END MENU -->
    </div>
    </div>
    <!-- END PORTLET MAIN -->
    <!-- PORTLET MAIN -->
    <div class="portlet light ">
        <!-- STAT -->
        <div class="row list-separated profile-stat">
            <div class="col-md-4 col-sm-4 col-xs-6">
                <div class="uppercase profile-stat-title"> 37 </div>
                <div class="uppercase profile-stat-text"> Projects </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6">
                <div class="uppercase profile-stat-title"> 51 </div>
                <div class="uppercase profile-stat-text"> Tasks </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6">
                <div class="uppercase profile-stat-title"> 61 </div>
                <div class="uppercase profile-stat-text"> Uploads </div>
            </div>
        </div>
        <!-- END STAT -->
        <div>
            <h4 class="profile-desc-title">About Marcus Doe</h4>
            <span class="profile-desc-text"> Lorem ipsum dolor sit amet diam nonummy nibh dolore. </span>
            <div class="margin-top-20 profile-desc-link">
                <i class="fa fa-globe"></i>
                <a href="http://www.keenthemes.com">www.keenthemes.com</a>
            </div>
            <div class="margin-top-20 profile-desc-link">
                <i class="fa fa-twitter"></i>
                <a href="http://www.twitter.com/keenthemes/">@keenthemes</a>
            </div>
            <div class="margin-top-20 profile-desc-link">
                <i class="fa fa-facebook"></i>
                <a href="http://www.facebook.com/keenthemes/">keenthemes</a>
            </div>
        </div>
    </div>
    <!-- END PORTLET MAIN -->
</div>