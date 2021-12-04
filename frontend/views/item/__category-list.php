<?php 
use yii\helpers\Html;
$category = \common\models\wrappers\CategoryWrapper::find()->where(['code' => 'products'])->one();
$catId = $category->id;
$categories = \common\models\wrappers\CategoryWrapper::find()->where(['parent_id' =>$catId, 'status' => '1'])->all();
?>

<div class="container">
	<div class="row">

		<?php foreach ($categories as $key => $cat): ?>
			<?php if (isset($cat->documents) && count($cat->documents) > 0){
                $image=[];
        foreach ($cat->documents as $doc){
            $image[] = $doc->getThumb();
        }
    } ?>
		<div class="col-md-4 col-sm-6 col-12 clear3BoxItem">
    <div class="category_cart">
        <div class="img_block_cart_category">
            <div class="row">
                 <div class="col-md-8 ovh">
            <a href="<?= $cat->url; ?>">
             
                     
                     <?php if (isset($image[0]) && strlen($image[0])>0){
                                echo html::img($image[0],['class' => 'my_img2']);
                            } else{
                                echo html::img($image[0],['class' => 'my_img2']);
                            } ?>
                
            </a>
        </div>
        <div class="col-md-4 d-sm-none d-none d-md-block" style="border-left: 1px solid #e7eaf3;">
            <div class="col-md-12 small_cart_img ovh" style="border-bottom: 1px solid #e7eaf3;">
                <a href="<?= $cat->url; ?>">
             
                     <?php if (isset($image[1]) && strlen($image[1])>0){
                                echo html::img($image[1],['class' => 'my_img2']);
                            } else{
                                echo html::img($image[0],['class' => 'my_img2']);
                            } ?>
                
            </a>
            
            </div>
            <div class="col-md-12 small_cart_img ovh" style="border-bottom: 1px solid #e7eaf3;">
                <a href="<?= $cat->url; ?>">
             <?php if (isset($image[2]) && strlen($image[2])>0){
                                echo html::img($image[2],['class' => 'my_img2']);
                            } else{
                                echo html::img($image[0],['class' => 'my_img2']);
                            } ?>
                    
                
            </a>
            </div>
            
        </div>
        </div>





        </div>

<div class="row" style="box-sizing:border-box;border: 1px solid #e7eaf3;    background: #fff;">
    <div class="col-md-12">
            <div class="caption_cart" style="box-sizing:border-box">
                
                    <h4><?=$cat->name?></h4>
            
                <p>                             <?php
                  $length = strlen($cat->description);
                  if($length > 100){
                    $text = mb_substr($cat->description, 0, 100);
                    $firsPos = strripos($text, ' ');
                    $text = mb_substr($text, 0, $firsPos); 
                    echo ($text.'...');
                    } else{
                        echo ($cat->description);
                    } 
                   ?></p>
                <a href="<?= $cat->url; ?>" class="btn_in_detail">Giňişleýin</a>

            </div>
        </div>
        </div>

        </div>
</div>

<?php endforeach; ?>
	</div>
</div>






<!-- Gök bedre hojalyk harytlary üçin
 -->