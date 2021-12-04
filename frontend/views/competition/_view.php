<?php
use yii\helpers\Html;

$contentModel = $model->loadContent();
$href = $model->url;

//$path = $model->getThumbPath(365, 215, '', true, false, true);
if (isset($contentModel)) { ?>


    <div class="col-sm-12">
        <article class="entry-list">
            <div class="row">
                <div class="col-md-4">
                    <div class="entry-image">
                        <?php
                        $imgsrc = $contentModel->getThumbPath(260, 150,'auto');
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
                </div>
            </div>
        </article>
    </div>
<?php } ?>