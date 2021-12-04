<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use common\models\wrappers\ItemWrapper;
	use common\widgets\items\listview\ListWidget;

$category = \common\models\wrappers\CategoryWrapper::find()->where(['code' => 'our_works'])->one();
$catId = $category->id;
$projects = \common\models\wrappers\ItemWrapper::find()->where(['parent_category_id' => $catId, 'status' => '1'])->orderBy('Rand()')->all();

?>
<style>
	.blog-one__single:hover .button-underline:after {
    width: 100%;
}
</style>
	<section class="portfolio">					
         <div class="row service_item" style="margin-top: 3%;" >
            <?php
                foreach ($projects as $key => $project):
            ?>
                   
                <div class="col-12">
                    <div class="blog-one__single">
                        <div class="row blog-one__single-inner-block">
                        	<div class="col-6">
                        <div class="product-preview" style="--product-accent: #f5f5f5">
                            <div class="product-preview__visual">
                          <img src="<?=$project->getThumbPath()?>" class="scale" alt="">
                          </div>
                          </div>
                        </div>  
                        <div class="col-6">
                        	                   
                            <h1 class=""><?=$project->title?></h1>
                            <p class="" style="margin-bottom: 10px">
                                <?=$project->description?>
                            </p>
                   
                        <?=html::a(yii::t('app', 'Doly maglumat').'  <i class="fa fa-long-arrow-right"></i>',$project->url, ['class' => 'blog-one__link button-underline'])?>
                  
                   
                        </div> 
                        </div>
                    </div>
                  </div>
               <div class="clearfix"></div>
             
            <?php
                endforeach;
            ?>
        </div>
						
								<!-- .isotope-wrapper-->
						

					<div class="divider-5"></div>
				</section>






