<?php

use yii\helpers\Html;
$items = \common\models\wrappers\ItemWrapper::find()->where(['category_id' =>$modelCategory->id, 'status' => '1'])->all();

?>
<section id="">
    <div class="container">
        <div class="row">
        
                <h1 style="margin-top: 100px; font-size: 50px">Brands we work with</h1>
                <p>We are proud to work with some of the biggest entertainment, technology, and media companies in the world, along with many top consumer brands. You can see a selection of these companies below and see what they have to say about us in their testimonials.</p>

          <?php
                $count = count($items);
                $i=0;
                foreach ($items as $key => $item):
            ?>
                 <?php
                  $i++;
                 ?>
            <div class="col-xs-12 col-md-4" style="margin-bottom: 70px; margin-top: 70px; ">
                <p class="text-center"><img style="width: auto; height: 100px" src="<?= $item->getThumbPath()?>"></p>
                <?php if ($i<10): ?>
                <p><?=$item->description?></p>
                <h4><?=$item->title?></h4>
              <?php else: ?>

                 <?php
                        endif;
                    ?>
            </div>
            <?php
                         endforeach;
                    ?>

        </div>
    </div>
</section>

  

