<?php
use yii\helpers\Html;

$contentModel = $model->loadContent();
$locationModel = $model->loadLocation();
$href = $model->url;
?>


<div class="col-sm-12">
    <article class="entry-list">
        <div class="row">
            <div class="col-md-4">
                <div class="entry-image">
                    <?php
                    $imgsrc = $contentModel->getThumbPath(260, 150);
                    echo Html::a(Html::img($imgsrc, ['alt' => '', 'class' => 'entry-featured-image-url']), $href);
                    ?>
                </div>
            </div>
            <div class="col-md-8">
                <div class="entry-header">
                    <h6 class="entry-title">
                        <?= Html::a($contentModel->title, $href) ?>
                    </h6>
                </div>

                <div class="entry-desc">
                    <?php
                    $desc = Yii::$app->controller->truncate($contentModel->description, 20, 300);
                    echo $desc;
                    ?>
                </div>

                <?php if (isset($locationModel) && strlen(trim($locationModel->title)) > 0) { ?>
                    <div class="entry-location">
                        <span>
                            <i class="fa fa-map-marker"></i>
                            <a href="<?= $locationModel->url ?>"><?= $locationModel->title ?></a>
                        </span>
                    </div>
                <?php } ?>
            </div>
        </div>
    </article>
</div>
