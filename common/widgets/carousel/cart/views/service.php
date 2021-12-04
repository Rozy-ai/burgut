<?php
$services = $this->context->services;

if (isset($services) && count($services) > 0) { ?>
    <?php foreach ($services as $key => $model) {
        $href = $model->url;
        ?>

        <div class="single-service-holder">
            <div class="col-md-5 col-sm-5 col-xs-12">
                <div class="holder-img">
                    <a href="<?= $href ?>">
                        <?php
                        $path = $model->getThumbPath(442, 443);
                        echo \yii\helpers\Html::img($path, ['alt' => '', 'class' => '']);
                        ?>
                    </a>
                </div>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12">
                <div class="holder-content sm-des">
                    <div class="hc-title">
                        <h2><?= $model->title ?></h2>
                    </div>
                    <p>
                        <?= $model->description ?>
                    </p>
                </div>
                <div class="holder-icon">
                    <div class="single-icon">
                        <img src="/img/author/icon01.png" alt="">
                    </div>
                    <div class="single-icon">
                        <img src="/img/author/icon02.png" alt="">
                    </div>
                    <div class="single-icon">
                        <img src="/img/author/icon03.png" alt="">
                    </div>
                    <div class="single-icon">
                        <img src="/img/author/icon04.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>


<?php } ?>
