<?php
use yii\helpers\Html;
use yii\helpers\Url;

$items = $this->context->items;
$title = $data->title;
$class = ['nonid-icon-visualization', 'nonid-icon-target', 'nonid-icon-presentation', 'nonid-icon-laptop']
?>

<?php
    $i=0;
    foreach ($items as  $item):

?>
<div class="col-md-3 cards">
    <a href="<?=url::to($item->url)?>">
        <div class="func_cards">
            <div class="func_card_title">
                <i class="service-one__icon <?=$class[$i]?>"></i>
                <h3><?=$item->title?></h3>
            </div>
            <p><?=$item->description?></p>
            <div class="card_arr">
                <div class="card_arrow">
                    <span><i class="nonid-icon-left-arrow"></i></span>
                </div>
            </div>
        </div>
    </a>
</div>
<?php
        $i++;
        endforeach;
?>