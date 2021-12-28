<?php 
use yii\helpers\Html;
 ?>
 <section class="about_us_view" style="padding-top: 0">
 	<div class="container">
 		<div class="row">
 						<?php 
            $category = \common\models\wrappers\CategoryWrapper::find()->where(['code' => 'about'])->one();
$catId = $category->id;
$about = \common\models\wrappers\ItemWrapper::find()->where(['category_id' => $catId, 'status' => '1'])->with(['documents','translations'])->one();
?>

 			<div class="col-md-12">
 				 <h3 style="margin-bottom: 30px"> <?=$about->title?></h3>
                 <p><i><?=$about->description?></i></p>
                        <p style=" margin-bottom: 30px">
<?=$about->content?>
                        </p>

                        
 			</div>

 		</div>
 	</div>
 </section>


