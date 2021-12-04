<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $productKeyword common\models\AmzProductKeyword*/

$amzProduct->title = htmlspecialchars($amzProduct->title);
$monitore_date = \Yii::$app->formatter->asDate($productKeyword->monitored_date, 'dd-MM-yyyy HH:mm:ss');
$keywrod = $productKeyword->keyword;

?>


<div class="keyword-monitor">
    <p>Hi</p>
    <p>On  <b> <?=$monitore_date ?></b>:</p>
    <p>The product with ASIN: <b><?=$amzProduct->asin ?></b> and Title: <b><?=mb_substr($amzProduct->title, 0, 100) ?></b></p>
    <p><b>"<?=$keywrod ?>"</b> keyword's position changed from: <?=$old_position?> to <?=$new_position ?></p>

    <p>ConquerAmz</p>
</div>
