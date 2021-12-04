<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ItemWrapper */

$this->title = $model->title;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Item Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$href = $model->url;
$author = (isset($model->author) && strlen(trim($model->author)) > 0) ? $model->author : $model->create_username;
$date = $model->renderDateToWord($model->date_created);

$path = $model->getThumbPath(405, 405, 'w');
$big_img_path = $model->getThumbPath(900, 900, 'w');

$documents = $model->documents;
?>
<!-- product-details-area are start-->
<div class="product-details-area pt60 pb60 ">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="pd-img">
                            <?php
                            echo \yii\helpers\Html::a(\yii\helpers\Html::img($path, ['alt' => '', 'class' => '']), $big_img_path, ['class' => 'venobox', 'data-gall' => 'myGallery']);
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="pd-content">
                            <div class="section-title">
                                <h3><?= Html::encode($model->title) ?></h3>
                            </div>
                            <!--                            <p class="date"><span>-->
                            <? //= Yii::t('app', 'created_date') ?><!--:</span> -->
                            <? //= Html::encode($date) ?><!--</p>-->
                            <div class="sm-des">
                                <?= Html::encode($model->description) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <!-- des -review -->
                <div class="des-review">
                    <ul role="tablist">
                        <li class="active"><a href="#descrip" role="tab"
                                              data-toggle="tab"><?php echo Yii::t('app', 'Description'); ?></a></li>

                        <?php if (isset($menus) && count($menus) > 0) { ?>
                            <li><a href="#menu" role="tab" data-toggle="tab"><?php echo Yii::t('app', 'Menu'); ?></a>
                            </li>
                        <?php } ?>
                        <?php if (isset($documents) && count($documents) > 1) { ?>
                            <li><a href="#gallery" role="tab"
                                   data-toggle="tab"><?php echo Yii::t('app', 'Gallery'); ?></a></li>
                        <?php } ?>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="descrip">
                            <div class="des-content">
                                <div class="sm-des">
                                    <?php echo $model->text; ?>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($documents) && count($documents) > 1) { ?>
                            <div role="tabpanel" class="tab-pane" id="gallery">
                                <div class="des-content row">
                                    <div class="item-gallery">
                                        <?php
                                        foreach ($documents as $doc) {
                                            $thumb = $doc->resize(300, 250);
                                            $big_thumb = $doc->resize(900, 900);
                                            ?>
                                            <div class="single-gallery">
                                                <a class="venobox" data-gall="myGallery"
                                                   href="<?php echo $big_thumb; ?>"><img src="<?php echo $thumb; ?>"
                                                                                         alt=""></a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (isset($menus) && count($menus) > 0) { ?>
                            <div role="tabpanel" class="tab-pane" id="menu">
                                <div class="des-content our-special-menu-area pt60 pb60 ">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="section-title text-center pb40">
                                                <h1>Biziň</h1>
                                                <h2>Menýumyz</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 col-sm-2 col-xs-12"></div>

                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <?php foreach ($menus as $menuModel) { ?>
                                                <div class="special-menu text-center">
                                                    <div class="sma-img">
                                                        <?php
                                                        $img_path = $menuModel->getThumbPath(720, 280, 'w');
                                                        echo \yii\helpers\Html::img($img_path, ['alt' => '', 'class' => '']);
                                                        ?>
                                                        <div class="sma-heading">
                                                            <h3><?= $menuModel->name ?></h3>
                                                        </div>
                                                    </div>
                                                    <div class="total-menu-item carsoule-btn smp-carsoule">
                                                        <?php
                                                        $menuItems = $menuModel->menuItems;
                                                        foreach ($menuItems as $key => $menuItemModel) { ?>

                                                            <?php if ($key % 8 == 0) {
                                                                echo '<div class="total-menu-single">';
                                                            } ?>

                                                            <div class="single-menu-item">
                                                                <div class="smi-heading">
                                                                    <a href="#"><?= $menuItemModel->name ?></a>
                                                                </div>
                                                                <div class="smi-des">
                                                                    <span><?= $menuItemModel->description ?></span>
                                                                </div>
                                                                <div class="smi-price">
                                                                <span><?php
                                                                    echo $menuItemModel->price;
                                                                    ?></span>
                                                                </div>
                                                            </div>

                                                            <?php if (($key > 0 && $key % 8 == 0) || $key == (count($menuItems) - 1)) {
                                                                echo '</div>';
                                                            } ?>

                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- product-details-area are end-->
