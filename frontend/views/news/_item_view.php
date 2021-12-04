<?php
use yii\helpers\Html;

$href = $model->newsurl;
$author = (isset($model->author) && strlen(trim($model->author)) > 0) ? $model->author : $model->create_username;

//$path = $model->getThumbPath(365, 215, '', true, false, true);
?>


<div class="col-md-4 col-sm-6 col-xs-12" >
    <div class="articleBox">
        <div class="article-image-viewer">
            <a href="<?=$model->url?>">
                <?=html::img($model->getThumbPath(347,243,'w',true),['alt' => 'work-image','class' => 'img-responsive news-item-img'])?>
                <div class="image-overlay">
                    <div class="product-title">
                        <i class="fa fa-search search-btn"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="articleContent">
            <div class="caption">
                <h3><a href="<?=$model->url;?>" title="<?=$model->title;?>"><?=$model->title;?></a></h3>
                <p class="pfixed"><?=yii::$app->controller->truncate($model->description,20,200)?></p>
                <div class="pull-left">
                    <a class="readmore" href="<?=$model->url;?>" title="<?=$model->title;?>"><?=yii::t('app','Read more')?> <span>›</span></a>            </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
