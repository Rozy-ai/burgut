<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $amzReview common\models\AmzReview */
$amzReview->content = htmlspecialchars($amzReview->content);
$data['product_title'] = htmlspecialchars($data['product_title']);
?>



<div class="password-reset">
    <p>Hi</p>
    <p>A critical review was changed for the product: <b> <?=mb_substr($data['product_title'], 0, 100) ?></b></p>
    <p>Star Rating: <?=$amzReview->rating ?></p>
    <p>Content: <?=$amzReview->content ?></p>
    <p>Review link: <?=htmlspecialchars($amzReview->url) ?></p>

    <p>ConquerAmz</p>
</div>
