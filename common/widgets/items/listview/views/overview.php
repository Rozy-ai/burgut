<?php
use yii\helpers\Html;

$list = $this->context->list;

if (isset($list) && count($list) > 0) { ?>
    <div class=" row tm_pb_row tm_pb_row_1">

        <?php foreach ($list as $key => $model) {
            $href = $model->url;
            ?>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <h2><span style="color: #ffffff;">
                        <?= $model->title ?>
                        </span></h2>
                <div class="description">
                    <?= $model->content ?>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 ">
                <?php
                $imgPath = $model->getThumbPath(544, 351);
                echo Html::a(Html::img($imgPath, ['alt' => '', 'class' => 'about_us']), $href);
                ?>
            </div>
        <?php } ?>
        <div class="col-sm-12">
            <div class="widget-show-all">
                <?php if (isset($this->context->show_all_url)) { ?>
                    <a href="<?= $this->context->show_all_url ?>"><?= $this->context->show_all_title ?></a>
                <?php } ?>
            </div>
        </div>
    </div>


<?php } ?>

