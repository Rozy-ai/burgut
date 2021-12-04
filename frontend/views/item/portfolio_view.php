<?php
    use yii\helpers\Html;
     $date = yii::$app->controller->renderDateToWord($model->date_created);
?>
<section class="portfolio_detail py-8">
<div class="container-fluid" style="padding: 0 10%">

<!--     <div class="slider_project">
        <div class="slide"> -->

<!--         </div>
    </div> -->
                            <div id="carouselExampleInterval" class="carousel slide" data-touch="true" data-ride="carousel">
                                <div class="carousel-inner portfolio_view_slider">
                                    <?php 
                                    $documents = $model->documents;
                                    $counter=0;
                                    foreach($documents as $document):
                                    $counter++; ?>
                                    <div class="carousel-item <?= ($counter==1)?'active':'' ?> twin-caro-cover" data-interval="true">
                                                    <?= html::img($document->getThumb(), ['class' => 'portfolio_view_slider_img']); ?>
                                        
                                    </div>
                                    <?php
                                    endforeach;
                                    ?>

                                    <div class="controls" style="background-color: #fff; position: absolute;bottom: 0;width: auto; height: 30px; right: 0;">
                                    <a style="padding: 0 10px" href="#carouselExampleInterval"
                                    role="button" data-slide="prev">
                                    <span style="color: #000;" aria-hidden="true"><?= Yii::t('app', 'Next') ?></span>
                     
                                </a> |
                                <a style="padding: 0 10px;" href="#carouselExampleInterval"
                                    role="button" data-slide="next">
                                    <span style="color: #000;" aria-hidden="true"><?= Yii::t('app', 'Previous') ?></span>
                     
                                </a>
                                    </div>

                                </div>
                            </div>



    <div class="py-5">

                    <h1 class="portfolio_view_h1"><?=$model->title?></h1>
                    <p><?=$model->content?></p>
                    <?php

                        if (isset($model->link_to_project)):
                    ?>
                    <a href="<?=$model->link_to_project?>" class="g_hover" target="_blank"><?= Yii::t('app', 'Live Project') ?></a>
                    <?php
                        endif;
                    ?>

    </div>
</div>
</section>
<!-- <section>
    <div class="container">
        <ul class="page-navigation">
            <li class="page-navigation__item page-navigation__previous">
                <a href="">
                    <i class="icon icon-arrow-long-left page-navigation__arrow"></i>
                    <span class="page-navigation__title">
                        <span class="inline-translation inline-translations--text">
                            Previous case
                        </span>
                    </span>
                    <span class="page-navigation__subtitle">Okay</span>
                </a>
                <div class="visual page-navigation__thumb">
                    <img src="/source/img/card.jpg" alt="">
                </div>
            </li>
        </ul>
    </div>
    <?php 
// $category = \common\models\wrappers\CategoryWrapper::find()->where(['code' => 'our_works'])->one();
// $catId = $category->id;
// $projects = \common\models\wrappers\ItemWrapper::find()->where(['parent_category_id' => $catId, 'status' => '1'])->one();
    ?>
    <a href="<?= '/item/'.$x; ?>">One</a>
    <?=$model->id?>
    <a href="<?= '/item/'.$y; ?>">Yza</a>
</section> -->
<section style="padding: 40px 0">
    <div class="container">
        <h2><?= Yii::t('app', 'Let’s be friends, vertel ons over jouw project') ?></h2>
                      <a href="/site/a/contact">   <button class="contact1-form-btn btn btn-outline-success my-2 my-sm-0">
<span>
<?=yii::t('app','Send')?>
    <i class="fa fa-long-arrow-right" style="color: #2ADFB4" aria-hidden="true"></i>
</span>
                    </button></a>
    </div>
</section>



<!-- 2 gezek
1de id ulylary 
2de kicileri sort bn almaly 

opacitu 0 gosmaly 1 nava -->

