<?php
use yii\helpers\Html;
    $href = $model->url;

    if (isset($model->documents) && count($model->documents) > 0){
        foreach ($model->documents as $doc){
            $image[] = $doc->getThumb();
        }
    }
    ?>
    <div class="category_cart">
        <div class="img_block_cart_category">

            <a href="<?= $href; ?>">
             
                    
                     <?php if (isset($image[0]) && strlen($image[0])>0){
                                echo html::img($image[0],['class' => 'my_img2']);
                            } else{
                                echo html::img($image[0],['class' => 'my_img2']);
                            } ?>
                
            </a>
            <div class="signature"></div>
             </div>
            <div class="caption_cart" style="box-sizing:border-box">
                 <a href="<?= $href ?>"> <h4 class="text-center"><?=$model->title?></h4></a>
            
                <p>                             <?php
                  $length = strlen($model->description);
                  if($length > 100){
                    $text = mb_substr($model->description, 0, 100);
                    $firsPos = strripos($text, ' ');
                    $text = mb_substr($text, 0, $firsPos); 
                    echo ($text.'...');
                    } else{
                        echo ($model->description);
                    } 
                   ?></p>
                
            </div>
        </div>
      


     
  


<?php if($index % 4 == 0): ?>
                            <div class="clearfix"></div>
                        <?php endif; ?>


                   

