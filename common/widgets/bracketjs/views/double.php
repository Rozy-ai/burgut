<?php
$services = $this->context->services;

if (isset($services) && count($services) > 0) { ?>
    <?php foreach ($services as $key => $model) {
        $href = $model->url;
        ?>

        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="single-service text-center">
                <div class="service-icon">
                    <?php
                    $pathicon = $model->getThumbPath(90, 75);
                    echo \yii\helpers\Html::img($pathicon, ['alt' => '', 'class' => '']);
                    ?>
                </div>
                <div class="service-title">
                    <h2><?= $model->title ?></h2>
                </div>
                <div class="service-text sm-des">
                    <p>
                        <?= $model->description ?>
                    </p>
                </div>
                <div class="read-btn">
                    <a href="<?= $href ?>">Dowamyny oka</a>
                </div>
            </div>
        </div>
    <?php } ?>


<?php } ?>
