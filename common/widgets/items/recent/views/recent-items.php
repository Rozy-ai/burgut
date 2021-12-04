<?php
use yii\helpers\Html;

$items = $this->context->items;

if (isset($items) && count($items) > 0) { ?>
    <div class="widget-title">

        <h2><?= Yii::t('app', 'Lenta') ?></h2>
    </div>
    <?php foreach ($items as $key => $data) { ?>
        <div class="list-item inline-block type-post ">
            <div class="inner_block">
                <?php
                $title = $data->title;
                ?>
                <div class="media-body">
                    <div class="entry-title">
                    <span class="entry-date">
                        <time
                            datetime="<?php echo Yii::$app->controller->dateToW3C($data->date_created); ?>"> <?php echo Yii::$app->controller->renderDate($data->date_created); ?></time>
                    </span>
                        <?php
                        $title = Yii::$app->controller->truncate($title, 20, 300);
                        echo Html::a($title, $data->url, array('rel' => 'bookmark'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    <?php } ?>
<?php } ?>
