<?php
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
     $date = yii::$app->controller->renderDateToWord($model->date_created);
?>

<div class="container">
        <div class="row">


        <div class="row main_product_info">
            <div class="col-md-8 test_slider">
                <h1>
                    <?= $model->title ?>                </h1>
<!--                 <p class="product_desc">
                    <?= $model->description ?>               </p> -->


        <!-- Carusel -->


  <div id="carouselExampleSlidesOnly" class="carousel slide" data-touch="true" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php 
                                    $documents = $model->documents;
                                    $counter=0;
                                    foreach($documents as $key => $document):
                                    $counter++; ?>
                                    <div class="carousel-item <?= ($counter==1)?'active':'' ?>" data-interval="true">
                                    <?= html::img($document->getThumb(), ['class' => 'img_blog']); ?>
                                        
                                    </div>
                                    <?php
                                    endforeach;
                                    ?>

                                </div>
                            </div>

 

  <!-- end carusel -->

                <div class="product_content_block">
                    <p>&nbsp;</p>

<?= $model->content ?>
                </div>

            </div>
            <div class="col-md-4">
                <div class="container">
                    <div class="row">
                <div class="search_blog col-12">
                
                        <?php $form = ActiveForm::begin(['action'=>['site/search'],'method'=>'get']); ?>
                    
                            <input type="text" autocomplete="off" placeholder="<?=Yii::t('app','Search')?>" name="query">
                   
                   
                            <button type="submit" class="search_submit"><?= Yii::t('app','Search') ?></button>
                       

        <?php ActiveForm::end(); ?>
               
               
       
                </div>
                </div>
                </div>

<h2 class="text-center" style="margin: 10% 0"><?= yii::t('app', 'Latest News') ?></h2>
                                            <?php
                                            $unset_id = $model->id;

                        echo \common\widgets\items\lastPosts\LastPosts::widget([
                            'message' => $unset_id
                        ]);
                    ?>
                          <!-- <div class="recent_posts"> -->
                                <?php
                        // echo \common\widgets\items\recent\RecentPosts::widget([

                        // ]);
                    ?>
                          <!-- </div> -->
                                          


            </div>
        </div>

</div>
</div>