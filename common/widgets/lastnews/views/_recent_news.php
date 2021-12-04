<?php
use yii\helpers\Html;

?>

 <div class="blog_aside_wrapper">
<?php
foreach ($items as $key => $data) { ?>
    <?php $date = $data->renderDateToWord($data->date_created);?>
    <div class="aside_item">
        <div class="aside_date"><?= $date ?></div>
        <div class="aside_title">
            <?= Html::a(Html::encode($data->title),$data->newsurl) ?>
        </div>
    </div>
<?php } ?>
     <div class="btnArea"><?= Html::a(Yii::t('app','Show more'),['news/index'],['class'=>'btn showmore']) ?></div>
 </div>
