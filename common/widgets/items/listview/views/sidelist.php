<?php
use yii\helpers\Html;

$list = $this->context->list;

if (isset($list) && count($list) > 0) { ?>
    <?php foreach ($list as $key => $model) {
        $href = $model->url;
        ?>
        <article class="entry-list">
            <div class="row">
                <div class="col-md-12">
                    <div class="entry-image">
                        <?php
                        $imgsrc = $model->getThumbPath(260, 150);
                        echo Html::a(Html::img($imgsrc, ['alt' => '', 'class' => 'entry-featured-image-url']), $href);
                        ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="entry-header">
                        <h6 class="entry-title">
                            <?= Html::a($model->title, $href) ?>
                        </h6>
                    </div>
                </div>
            </div>
        </article>
    <?php } ?>
<?php } ?>

