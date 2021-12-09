<?php 
use yii\helpers\Html;
 ?>
 <section class="about_us_view">
 	<div class="container">
 		<div class="row">
 						<?php 
            $category = \common\models\wrappers\CategoryWrapper::find()->where(['code' => 'about'])->one();
$catId = $category->id;
$about = \common\models\wrappers\ItemWrapper::find()->where(['category_id' => $catId, 'status' => '1'])->with(['documents','translations'])->one();
?>

 			<div class="col-md-6">
 				 <h3 style="margin-bottom: 30px"> <?=$about->title?></h3>
                 <p><i><?=$about->description?></i></p>
                        <p style=" margin-bottom: 30px">
<?=$about->content?>
                        </p>
                        <div class="btn_black_div">
                          <?php 
$category_products = \common\models\wrappers\CategoryWrapper::find()->where(['code' => 'magazin'])->one();
                           ?>
                            <a href="<?=$category_products->url?>" class="about_us_view_button" role="button"><?= Yii::t('app', 'Products') ?> </a>
                        </div>
                        
 			</div>
 			<div class="col-md-6">
 				<?=html::img($about->getThumbPath(),['class' => 'about_view_img']) ?>
 			</div>
 		</div>
 	</div>
 </section>


