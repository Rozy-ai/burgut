<?php
use yii\helpers\Html;

$list = $this->context->list;
?>

<div class="event-box">
    <?php
    if (isset($list) && count($list) > 0) { ?>
        <div class="row">
            <?php foreach ($list as $key => $model) {
                $contentModel = $model->loadContent();
                $showModel = $model->show;
                if (isset($contentModel) && isset($showModel)) {
                    $href = $showModel->url;
                    ?>
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

                            <div class="entry-date">
                                <i class="fa fa-calendar"></i>
                                <time
                                    datetime="<?php echo Yii::$app->controller->dateToW3C($model->start_time); ?>">
                                    <?php echo Yii::$app->controller->renderDateToWord($model->start_time, 'm', null) . ' ' . Yii::$app->controller->renderDateTime($model->start_time, true, 'H:i', null); ?>
                                </time>
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
