<?php
use yii\helpers\Html;

$items = $this->context->items;

?>

<div class="container-fluid next-block ticker" >

    <div class="marquee-div">
        <marquee behavior="scroll" direction="left" id="marquee1">

            <?php
            $itemcount = 0;
            foreach ($items as $key => $data) {
                $title = $data->title;
                $date = Yii::$app->controller->renderDateToWord($data->date_created);

                $title = Yii::$app->controller->truncate($title, 10, 250);
                echo '<span class="mardate">' . $date . '</span> - ' . Html::a($title, $data->url, array('title' => $title, 'class' => 'marqueeitems'));
                $itemcount++;

                if ($itemcount < count($items))
                    echo "    /    ";
            }
            ?>
        </marquee>
    </div>

</div>



