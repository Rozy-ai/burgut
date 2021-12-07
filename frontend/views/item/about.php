<?php 
use yii\helpers\Html;
 ?>
 <section class="about_us_view">
 	<div class="container">
 		<div class="row">
 						<?php 
			$category = \common\models\wrappers\CategoryWrapper::find()->where(['code' => 'about'])->one();
?>

 			<div class="col-md-6">
 				 <h3 style="margin-bottom: 30px"> Saparmyrat Nyýazow adyndaky dokma toplumy</h3>
                 <p><i>"<?=$category->description?>"</i></p>
                        <p style=" margin-bottom: 30px">
                    
                          Esaslandyrlan sene: 12.05.1997
<br>
Önümler: Trikotaž geýimler we matalar
<br>
Gypjak şäherçesindäki Saparmyrat Nyýazow adyndaky dokma toplumy 1997-nji ýylyň 12-nji maýynda dabaraly ýagdaýda açylyp ulanylmaga berildi.
                        </p>
                        <div class="btn_black_div">
                          <?php 
$category_products = \common\models\wrappers\CategoryWrapper::find()->where(['code' => 'magazin'])->one();
                           ?>
                            <a href="<?=$category_products->url?>" class="about_us_view_button" role="button"><?= Yii::t('app', 'Products') ?> </a>
                        </div>
                        
 			</div>
 			<div class="col-md-6">
 				<?=html::img($category->getThumbPath(),['class' => 'about_view_img']) ?>
 			</div>
 		</div>
 	</div>
 </section>

  <section class="partners">
            <?php
$category = \common\models\wrappers\CategoryWrapper::find()->where(['code' => 'partners'])->one();
$catId = $category->id;
$partners = \common\models\wrappers\ItemWrapper::find()->where(['category_id' => $catId, 'status' => '1'])->orderBy('Rand()')->limit(8)->all();
$categoryLink = [$category->code => $category->url];
?>

    <div class="center slider">
 <?php foreach ($partners as $key => $partner): ?>

        <?=html::img($partner->getThumbPath(),['class' => 'my_img', 'style' => 'height : 150px'])?>
      <?php endforeach; ?>

    </div>
    <!--   <p class="text-center my-4"> -->
                <?php 
                // echo html::a(yii::t('app', 'Show all'),$category->url, ['class' => 'see_all_btn'])
                ?>
             <!--    <a href=" -->
                <?php  
                // echo $category->url
                ?>
              <!--   "><button type="button" class="btn btn-light" style="border:2px solid black"> --><?php 
                // echo yii::t('app', 'Show all') 
                ?>
                  
<!--                 </button></a>
</p> -->
  </section>
