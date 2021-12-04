<?php
use yii\helpers\Html;

$list = $this->context->list;

if (isset($list) && count($list) > 0) { ?>
    <?php foreach ($list as $key => $model) {
        $contentModel = $model->loadContent();
        $href = $model->url;
        ?>
        <article class="entry-list">
            <div class="row">
                <div class="col-md-6">
                    <div class="entry-image">
                        <?php
                        $imgsrc = $contentModel->getThumbPath(260, 150);
                        echo Html::a(Html::img($imgsrc, ['alt' => '', 'class' => 'entry-featured-image-url']), $href);
                        ?>
                    </div>
                </div>
                <div class="col-md-6 col-wide-left">
                    <div class="entry-header">
                        <h6 class="entry-title">
                            <?= Html::a($contentModel->title, $href) ?>
                        </h6>
                    </div>
                    <div class="entry-date">
                        <i class="fa fa-calendar"></i>
                        <time
                            datetime="<?php echo Yii::$app->controller->dateToW3C($model->start_time); ?>"> <?php echo Yii::$app->controller->renderDateTime($model->start_time, true); ?>
                        </time>
                    </div>
                </div>
            </div>
        </article>
    <?php } ?>
<?php } ?>

