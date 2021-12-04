<?php
$services = $this->context->services;

if (isset($services) && count($services) > 0) { ?>
    <?php foreach ($services as $key => $model) {
        $href = $model->url;
        ?>
        <div class="single-about">
            <?php
            $path = $model->getThumbPath(634, 634);
            echo \yii\helpers\Html::img($path, ['alt' => '', 'class' => '']);
            ?>
            <div class="about-content">
                <div class="about-table">
                    <div class="about-cell">
                        <p><?= $model->title ?></p>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>


<?php } ?>
