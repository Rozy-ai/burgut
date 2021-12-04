<?php 
use yii\helpers\Html;
$category = \common\models\wrappers\CategoryWrapper::find()->where(['code' => $cat])->one();
$catId = $category->id;
$categories = \common\models\wrappers\CategoryWrapper::find()->where(['parent_id' =>$catId, 'status' => '1'])->all();
?>

<div class="container" style="margin-bottom: 5%">
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
        
            <a href="<?= $cat->url; ?>">
             
                     
                     <?php if (isset($image[0]) && strlen($image[0])>0){
                                echo html::img($image[0],['class' => 'my_img2']);
                            } else{
                                echo html::img($image[0],['class' => 'my_img2']);
                            } ?>
                
            </a>
            <div class="signature"></div>
       





        </div>
            <div class="caption_cart" style="box-sizing:border-box">
                
                    <a href="<?= $cat->url; ?>"> <h4><?=$cat->name?></h4></a>
            
                <p>                             <?php
                  // $length = strlen($cat->description);
                  // if($length > 100){
                  //   $text = mb_substr($cat->description, 0, 100);
                  //   $firsPos = strripos($text, ' ');
                  //   $text = mb_substr($text, 0, $firsPos); 
                  //   echo ($text.'...');
                  //   } else{
                  //       echo ($cat->description);
                  //   } 

           echo Yii::$app->controller->getFragment(strip_tags($model->description), $query); 
                   ?></p>
               

            </div>
    

        </div>
</div>

<?php endforeach; ?>
	</div>
</div>






<!-- Gök bedre hojalyk harytlary üçin
 -->