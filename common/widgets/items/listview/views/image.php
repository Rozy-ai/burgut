<?php
use yii\helpers\Html;

$list = $this->context->list;
$item_class = isset($this->context->item_class) ? $this->context->item_class : 'col-sm-4 col-md-4 col-lg-4 col-xl-4';

if (isset($list) && count($list) > 0) { ?>
    <div class="row">
        <?php foreach ($list as $key => $model) {
            $href = $model->url;
            ?>
            <div class="<?= $item_class ?>">
                <div class="entry-box">
                    <div class="entry-image">
                        <?php
                        $imgsrc = $model->getThumbPath(450, 250, 'auto');
                        echo Html::a(Html::img($imgsrc, ['alt' => '', 'class' => 'entry-featured-image-url']), $href);
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

<?php } ?>
