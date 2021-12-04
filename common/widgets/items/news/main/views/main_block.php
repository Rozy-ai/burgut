<?php
use yii\helpers\Html;

$items = $this->context->items;
$data = $this->context->mainItem;
$title = $data->title;
?>

<div class="main-news-wrapper">
    <div class="row">
        <div class="col-md-5 col-xs-12">
            <div class="main_news_block">
                <div class="media-object responsive">
                    <?php
                    $path = $data->getThumbPath(500, 300, 'auto', true);
                    echo Html::a(Html::img($path, array('style' => 'max-width:100%', 'alt' => $title)), $data->url, array('class' => "thumb")); ?>
                </div>

                <div class="item_meta_wrapper">
                    <div class="entry-date inline">
                        <time
                            datetime="<?php echo Yii::$app->controller->dateToW3C($data->date_created); ?>"> <?php echo Yii::$app->controller->renderDate($data->date_created); ?></time>
                    </div>

                    <!--                --><?php
                    //                $categoryModel = $data->loadCategory();
                    //                if (isset($categoryModel)) { ?>
                    <!--                    <div class="item_category inline">-->
                    <!--                        --><?php
                    //                        echo Html::a($categoryModel->name, $categoryModel->url);
                    //                        ?>
                    <!--                    </div>-->
                    <!--                --><?php //} ?>


                    <h1 class="blog_header inline">
                        <?php
                        echo Html::a($title, $data->url, array('rel' => 'bookmark'));
                        ?>
                    </h1>
                </div>


                <div class="main_news_block_description">
                    <?php
                    $desc = Yii::$app->controller->truncate($data->description, 23, 300);
                    echo $desc;
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-7 col-xs-12 most_recent_news mobile_index_list">
            <div class="row">
                <?php
                echo $this->render('_recent_news', array('items' => $items));
                ?>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="widget-show-all">
                <?php if (isset($this->context->show_all_url)) { ?>
                    <a href="<?= $this->context->show_all_url ?>"><?= $this->context->show_all_title ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
