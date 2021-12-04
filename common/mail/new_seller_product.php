<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $amzProduct common\models\AmzProduct */

$amzProduct->title = htmlspecialchars($amzProduct->title);
?>


<div class="seller-product">
    <p>Hi</p>
    <p>A new product was added by you and conqueramazon.com indexed it: <b> <?=mb_substr($amzProduct->title, 0, 100) ?></b></p>
    <p>Product ASIN: <?=$amzProduct->asin ?></p>

    <p>ConquerAmz</p>
</div>
