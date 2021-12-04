<?php

/* @var $this yii\web\View */

use common\widgets\magnificpopup\MagnificPopup;
use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="about_us">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-12 bg-color1">
                <div class="box-body">
                    <div class="box-body-icon">
                        <i class="fa fa-line-chart" aria-hidden="true"></i>
                    </div>
                    <div class="box-body-content">
                        <h4 class="eltdf-iwt-title">ÝOKARY HIL</h4>
                        <p>Begler Ýoly hususy kärhanasy öz önümlerini mydama ýokary hil öndürmäge çalyşýar</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 bg-color2">
                <div class="box-body">
                    <div class="box-body-icon">
                        <i class="fa fa-cogs" aria-hidden="true"></i>
                    </div>
                    <div class="box-body-content">
                        <h4 class="eltdf-iwt-title">TEHNOLOGIK</h4>
                        <p>Plastik gaplama tehnologiýasy önümçilikde dünýäniň soňky ülüňlerine gabat gelýär</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 bg-color3">
                <div class="box-body">
                    <div class="box-body-icon">
                        <i class="fa fa-copyright" aria-hidden="true"></i>
                    </div>
                    <div class="box-body-content">
                        <h4 class="eltdf-iwt-title">SERTIFIKATLAŞDYRYLAN</h4>
                        <p>Plastik gaplary önümçilik etmek üçin gerek bolan dünýäde talap edilýän ähli sertifikatlara eýedir</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pd-50">
            <div class="col-xs-12">
                <?php
                    $content = \common\models\wrappers\ItemWrapper::findone(1668);
                    echo $content->content;
                    $imgsrc = $content->getThumbPath(428,255,'w');
                    echo html::img($imgsrc,['class' => 'img_in_about_page']);
                ?>
            </div>
        </div>
        <div class="row mb-40">
            <div class="col-xs-12">
                <div class="mb-40">
                    <h2 class="section-title center">
                        <small class="withdot"><?= Yii::t('app','Certificates') ?></small><br>
                        <?= Yii::t('app','Our Certificates') ?>
                    </h2>
                </div>
                <div class="certificates-list">
                    <?php
                        $certificate = \common\models\wrappers\ItemWrapper::findone(1669);

                        $images = $certificate->documents;


                    if(!is_null($images)) {
                        echo MagnificPopup::widget(
                            [
                                'target' => '.certificates-list',
                                'options' => [
                                    'delegate' => 'a',
                                    'type' => 'image',
                                    'gallery' => [
                                        'enabled' => true,
                                    ],
                                ]
                            ]
                        );

                        foreach ($images as $image):?>
                            <a href="<?=$image->getThumb()?>" style="height: 100%;">
                                <?=Html::img($image->getThumb(160,200 ,'w'), ['class' => 'img-responsive certificate-img'])?>
                            </a>
                            <?php
//                                echo Html::a(Html::img($image->getThumb(), ['class' => 'img-responsive certificate-img']), $image->getThumb());
                            ?>

                        <?php endforeach;
                    }
                     ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</section>
