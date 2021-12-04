<?php
use yii\helpers\Html;

$list = $this->context->list;
?>

<div class="event-box">
    <?php
    if (isset($list) && count($list) > 0) { ?>
        <div class="row">
            <?php foreach ($list as $key => $model) {
                $showModel = $model->show;
                $href = $showModel->url;
                $contentModel = $model->loadContent();
                if (isset($contentModel) && isset($showModel)) { ?>
                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                        <article class="entry-box">

                            <div class="entry-image">
                                <?php
                                $imgsrc = $contentModel->getThumbPath(415, 300);
                                echo Html::a(Html::img($imgsrc, ['alt' => '', 'class' => 'entry-featured-image-url']), $href);
                                ?>
                            </div>

                            <div class="entry-header">
                                <h6 class="entry-title">
                                    <?= Html::a($contentModel->title, $href) ?>
                                </h6>
                            </div>

                            <div class="entry-desc">
                                <?php
                                $location = $showModel->location;
                                if (isset($location)) {
                                    $desc = Yii::$app->controller->truncate($location->title, 20, 300);
                                    echo $desc;
                                }
                                ?>
                            </div>
                        </article>
                    </div>
                <?php } ?>
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
</div>
