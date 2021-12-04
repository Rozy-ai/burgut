<?php
use yii\helpers\Html;
use yii\helpers\Url;

$items = $this->context->items;
$title = $data->title;
?>
<?php
    $cat = [];
    foreach ($items as $item){
        if (!isset($cat[$item->category_id])){
            $cats[] = $item->category_id;
            $cat[$item->category_id] = 0;
        }
    }
?>
<!-- BUTTON GROUP FOR CATEGORIES -->
<div class="btn_group">
    <a href="#" class="category-button active" data-filter="all" data-toggle="tab">All</a>
    <?php
    foreach ($cats as $catId):
        $category =  \common\models\wrappers\CategoryWrapper::findOne($catId);
        ?>
        <?=html::a($category->name,'#',['class' => 'category-button', 'data-filter' => $category->code, 'data-toggle' => 'tab'])?>
    <?php
    endforeach;
    ?>
</div>
<!-- END BUTTON GROUP FOR CATEGORIES -->
<hr>

<div class="row">
    <?php
        foreach ($items as $item):
            $category = \common\models\wrappers\CategoryWrapper::findOne($item->category_id);
    ?>
            <div class="col-md-4 portfolio_item all <?=$category->code?>">
                <div class="portfolio_item_content">
                    <div class="portfolio_item_img_block">
                        <?=html::img($item->getThumbPath(), ['alt' => 'project', 'class' => 'my_img'])?>
                    </div>
                    <div class="portfolio_item_title">
                        <?=html::a('<h3>'.$item->title.'</h3>',$item->url)?>
                        <span class="category_portfolio"><?=$category->name?></span>
                    </div>
                </div>
            </div>
    <?php
        endforeach;
    ?>

</div>
