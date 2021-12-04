<?php
use yii\helpers\Html;

$list = $this->context->list;

if (isset($list) && count($list) > 0) { ?>
    <div class="row">
        <?php foreach ($list as $key => $model) {
            $href = $model->url;
            ?>
            <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <article id="post-34" class="entry-box">

                    <div class="entry-image">
                        <?php
                        $imgsrc = $model->getThumbPath(415, 300);
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
