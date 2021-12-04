<?php

use yii\helpers\Url;

$user = Yii::$app->user->identity;

?>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <!-- <?php /*if (isset($user)) { */ ?>
            <div class="user-panel">
                <div class="pull-left image">
                    <? /*= Html::img($user->profile->getAvatarUrl(50), [
                        'class' => 'img-circle',
                        'alt' => $user->username,
                    ]) */ ?>
                </div>
                <div class="pull-left info">
                    <p><? /*= $user->username */ ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
        --><?php /*} */ ?>
        <ul class="sidebar-menu">

            <li class="nav-item  ">
                <a href="<?= yii\helpers\Url::to(['/site/index']); ?>" class="nav-link ">
                    <i class="fa fa-home"></i>
                    <span class="title"><?= Yii::t('backend', 'Main page') ?></span>
                </a>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file"></i>
                    <span><?= Yii::t('backend', 'Content') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>

                <ul class="treeview-menu">
                    <li class="nav-item  ">
                        <a href="<?= yii\helpers\Url::to(['/item/index']); ?>" class="nav-link ">
                            <i class="fa fa-file-o"></i>
                            <span class="title"><?= Yii::t('backend', 'Items') ?></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?= yii\helpers\Url::to(['/category/index']); ?>" class="nav-link ">
                            <i class="fa fa-file-o"></i>
                            <span class="title"><?= Yii::t('backend', 'Categories') ?></span>
                        </a>
                    </li>


                    <!--                    <li class="nav-item  ">-->
                    <!--                        <a href="-->
                    <? //= yii\helpers\Url::to(['/show/index']); ?><!--" class="nav-link ">-->
                    <!--                            <i class="fa fa-ticket"></i>-->
                    <!--                            <span class="title">-->
                    <? //= Yii::t('backend', 'Shows') ?><!--</span>-->
                    <!--                        </a>-->
                    <!--                    </li>-->
                    <li class="nav-item  ">
                        <a href="<?= yii\helpers\Url::to(['/image/index', 'ImageSearch[type]' => \common\models\wrappers\ImageWrapper::IMAGE_SLIDER]); ?>"
                           class="nav-link ">
                            <i class="fa fa-image"></i>
                            <span class="title"><?= Yii::t('backend', 'Slider') ?></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="<?= yii\helpers\Url::to(['/image/index', 'ImageSearch[type]' => \common\models\wrappers\ImageWrapper::IMAGE_GALLERY]); ?>"
                           class="nav-link ">
                            <i class="fa fa-file-image-o"></i>
                            <span class="title"><?= Yii::t('backend', 'Gallery') ?></span>
                        </a>
                    </li>
                </ul>
            </li>


<!--            <li class="nav-item  ">-->
<!--                <a href="--><?php //echo yii\helpers\Url::to(['/competition/index']); ?><!--" class="nav-link ">-->
<!--                    <i class="fa fa-globe"></i>-->
<!--                    <span class="title">--><?php //echo Yii::t('backend', 'Competitions') ?><!--</span>-->
<!--                </a>-->
<!--            </li>-->


            <!--            <li class="nav-item  ">-->
            <!--                <a href="--><? //= yii\helpers\Url::to(['/ticket/index']); ?><!--" class="nav-link ">-->
            <!--                    <i class="fa fa-ticket"></i>-->
            <!--                    <span class="title">--><? //= Yii::t('backend', 'Tickets') ?><!--</span>-->
            <!--                </a>-->
            <!--            </li>-->
            <!---->
            <!--            <li class="nav-item  ">-->
            <!--                <a href="-->
            <? //= yii\helpers\Url::to(['/payment/index']); ?><!--" class="nav-link ">-->
            <!--                    <i class="fa fa-money"></i>-->
            <!--                    <span class="title">--><? //= Yii::t('backend', 'Payment orders') ?><!--</span>-->
            <!--                </a>-->
            <!--            </li>-->


            <li class="nav-item  ">
                <a href="<?= yii\helpers\Url::to(['/banner-type/index']); ?>"
                   data-method="post" class="nav-link ">
                    <i class="fa fa-file-image-o"></i>
                    <span class="title"><?= Yii::t('backend', 'banners') ?></span>
                </a>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-cog"></i>
                    <span><?= Yii::t('backend', 'Classificators') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>

                <ul class="treeview-menu">
<!--                    <li class="nav-item  ">-->
<!--                        <a href="--><?php //echo yii\helpers\Url::to(['/federation/index']); ?><!--" class="nav-link ">-->
<!--                            <i class="fa fa-calendar"></i>-->
<!--                            <span class="title">--><?//= Yii::t('backend', 'Federations') ?><!--</span>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item  ">-->
<!--                        <a href="--><?php //echo yii\helpers\Url::to(['/participant/index']); ?><!--" class="nav-link ">-->
<!--                            <i class="fa fa-globe"></i>-->
<!--                            <span class="title">--><?//= Yii::t('backend', 'Participants') ?><!--</span>-->
<!--                        </a>-->
<!--                    </li>-->
<!---->
<!--                    <li class="nav-item  ">-->
<!--                        <a href="--><?php //echo yii\helpers\Url::to(['/team/index']); ?><!--" class="nav-link ">-->
<!--                            <i class="fa fa-globe"></i>-->
<!--                            <span class="title">--><?//= Yii::t('backend', 'Teams') ?><!--</span>-->
<!--                        </a>-->
<!--                    </li>-->

                    <li class="nav-item  ">
                        <a href="<? yii\helpers\Url::to(['/tag/index']); ?>" class="nav-link ">
                            <i class="fa fa-tags"></i>
                            <span class="title"><?= Yii::t('backend', 'Tags') ?></span>
                        </a>
                    </li>

                    <!--                    <li class="nav-item  ">-->
                    <!--                        <a href="-->
                    <? //= yii\helpers\Url::to(['/location/index']); ?><!--" class="nav-link ">-->
                    <!--                            <i class="fa fa-calendar"></i>-->
                    <!--                            <span class="title">-->
                    <? //= Yii::t('backend', 'Locations') ?><!--</span>-->
                    <!--                        </a>-->
                    <!--                    </li>-->


                    <!--                    <li class="nav-item  ">-->
                    <!--                        <a href="-->
                    <? //= yii\helpers\Url::to(['/seat-group/index']); ?><!--" class="nav-link ">-->
                    <!--                            <i class="fa fa-ticket"></i>-->
                    <!--                            <span class="title">-->
                    <? //= Yii::t('backend', 'Seats Groups') ?><!--</span>-->
                    <!--                        </a>-->
                    <!--                    </li>-->
                    <!---->
                    <!--                    <li class="nav-item  ">-->
                    <!--                        <a href="-->
                    <? //= yii\helpers\Url::to(['/payment-type/index']); ?><!--" class="nav-link ">-->
                    <!--                            <i class="fa fa-money"></i>-->
                    <!--                            <span class="title">-->
                    <? //= Yii::t('backend', 'Payment Types') ?><!--</span>-->
                    <!--                        </a>-->
                    <!--                    </li>-->
                    <!--                    <li class="nav-item  ">-->
                    <!--                        <a href="-->
                    <? //= yii\helpers\Url::to(['/merchant/index']); ?><!--" class="nav-link ">-->
                    <!--                            <i class="fa fa-money"></i>-->
                    <!--                            <span class="title">-->
                    <? //= Yii::t('backend', 'Merchants') ?><!--</span>-->
                    <!--                        </a>-->
                    <!--                    </li>-->
                </ul>
            </li>

            <li class="nav-item  ">
                <a href="<?= yii\helpers\Url::to(['/owner-contact/index']); ?>" class="nav-link ">
                    <i class="fa fa-globe"></i>
                    <span class="title"><?= Yii::t('backend', 'Owner Contact') ?></span>
                </a>
            </li>

            <li class="nav-item start  ">
                <a href="<?= yii\helpers\Url::to(['/user/admin/index']); ?>">
                    <i class="fa fa-users"></i>
                    <span class="title"><?= Yii::t('backend', 'User/Role Management') ?></span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?= yii\helpers\Url::to(['/backuprestore']); ?>" class="nav-link ">
                    <i class="fa fa-database"></i>
                    <span class="title"><?= Yii::t('backend', 'Database backup/restore') ?></span>
                </a>
            </li>
            <li class="nav-item start  ">
                <a href="<?= yii\helpers\Url::to(['/setting/index']); ?>">
                    <i class="fa fa-cog"></i>
                    <span class="title"><?= Yii::t('backend', 'Settings') ?></span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="<?= yii\helpers\Url::to(['/user/security/logout']); ?>" data-method="post" class="nav-link ">
                    <i class="fa fa-power-off"></i>
                    <span class="title"><?= Yii::t('backend', 'Sign out') ?></span>
                </a>
            </li>


        </ul>
    </section>
    <!-- /.sidebar -->
</aside>