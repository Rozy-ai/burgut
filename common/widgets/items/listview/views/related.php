<?php
use yii\helpers\Html;

$list = $this->context->list;

if (isset($list) && count($list) > 1) { ?>
    <?php if (isset($this->context->widget_title) && strlen(trim($this->context->widget_title)) > 1) { ?>
        <div class="widget-title">
            <h2><?php echo $this->context->widget_title; ?></h2>
        </div>
    <?php } ?>

    <div class="row">
        <?php foreach ($list as $key => $model) {
            $href = $model->url;
            ?>
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <article id="post-34" class="entry-box">

                    <div class="entry-image">
                        <?php
                        $imgsrc = $model->getThumbPath(415, 300,'auto');
                        echo Html::a(Html::img($imgsrc, ['alt' => '', 'class' => 'entry-featured-image-url']), $href);
                        ?>
                    </div>

                    <div class="entry-header">
                        <h6 class="entry-title">
                            <?= Html::a($model->title, $href) ?>
                        </h6>
                    </div>

<!--                    <div class="entry-desc">-->
<!--                        --><?php
//                        $desc = Yii::$app->controller->truncate($model->description, 20, 300);
//                        echo $desc;
//                        ?>
<!--                    </div>-->
                </article>
            </div>
        <?php } ?>
    </div>

<?php } ?>
