<?php
use yii\helpers\Html;

$list = $this->context->list;

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
                    <div class="entry-title">
                        <span class="list-icon"><i class="fa fa-check-circle"></i></span>
                        <?php
                        $title = Yii::$app->controller->truncate($title, 20, 300);
                        echo Html::a($title, $data->url, array('rel' => 'bookmark'));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>

