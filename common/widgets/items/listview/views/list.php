<?php
use yii\helpers\Html;

$list = $this->context->list;
?>

<?php
if (isset($list) && count($list) > 0) { ?>
    <?php foreach ($list as $key => $data) {
        $href = $data->url;
        ?>

        <div class="list-item inline-block type-post ">
            <div class="inner_block">
                <?php
                $title = $data->title;
                ?>
                <div class="media-body">
                    <span class="entry-date">
                        <time
                            datetime="<?php echo Yii::$app->controller->dateToW3C($data->date_created); ?>">
                            <?php echo Yii::$app->controller->renderDateToWord($data->date_created); ?>
                        </time>
                    </span>
                    <div class="entry-title">
                        <?php
                        $title = Yii::$app->controller->truncate($title, 20, 300);
                        echo Html::a($title, $data->url, array ('rel' => 'bookmark'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="widget-show-all">
        <?php if (isset($this->context->show_all_url)) { ?>
            <a href="<?= $this->context->show_all_url ?>"><?= $this->context->show_all_title ?></a>
        <?php } ?>
    </div>
<?php } ?>

