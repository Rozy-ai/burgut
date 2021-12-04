<?php
use yii\helpers\Html;

$href = $model->url;
$author = (isset($model->author) && strlen(trim($model->author)) > 0) ? $model->author : $model->create_username;

//$path = $model->getThumbPath(365, 215, '', true, false, true);
?>


<div class="col-sm-12">
    <article class="entry-list">
        <div class="row">
            <div class="col-md-4">
                <div class="entry-image">
                    <?php
                    $imgsrc = $model->getThumbPath(260, 150);
                    echo Html::a(Html::img($imgsrc, ['alt' => '', 'class' => 'entry-featured-image-url']), $href);
                    ?>
                </div>
            </div>
            <div class="col-md-8">
                <div class="entry-header">
                    <h6 class="entry-title">
                        <?= Html::a($model->title, $href) ?>
                    </h6>
                </div>

                <div class="entry-desc">
                    <?php
                    $desc = Yii::$app->controller->truncate($model->description, 20, 300);
                    echo $desc;
                    ?>
                </div>

                <?php
                //                $events = $model->events;
                $events = \common\models\wrappers\EventWrapper::find()->where(['location_id' => $model->id])->limit(3)->all();
                if (isset($events) && count($events) > 0) { ?>
                    <div class="events">
                        <span>
                            <i class="fa fa-calendar"></i>
                            <?= Yii::t('app', 'Nearest events:') ?>
                        </span>

                        <ul class="event-list">
                            <?php
                            foreach ($events as $event) {
                                $contentModel = $event->loadContent();
                                if (isset($contentModel)) { ?>
                                    <li>
                                        <time
                                            datetime="<?php echo Yii::$app->controller->dateToW3C($event->start_time); ?>">
                                            <?php echo Yii::$app->controller->renderDateToWord($event->start_time, 'm', null); ?>
                                        </time>
                                        /<a href="<?= $event->url ?>"> <?= $contentModel->title ?> </a>
                                    </li>
                                <?php } ?>

                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
    </article>
</div>
