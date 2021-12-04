<?php
    use yii\helpers\Html;
    $items = \common\models\wrappers\ItemWrapper::find()->where(['category_id' =>$modelCategory->id, 'status' => '1'])->all();
 
?>
<section class="service_list">
            <div class="container move fade-up">
            <div class="row">
              <div class="col-12 col-sm-6">
              <h2>What do we excell in?</h2>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident unde tenetur placeat aliquam eligendi nulla, facilis pariatur sed praesentium odit.&nbsp;</p>
            </div>
            </div>
  </div>
    <div class="list_services">
        <div class="container-fluid" style="padding-left: 7%; padding-right: 7%">
<!--         <br><br><br>
            <h3 class="text-center animated bounce">Biziň müşderilerimiz biz bilen işlemegi söýýärler!</h3> -->
        <div class="row service_item" style="margin-top: 3%;" >
            <?php
          
                foreach ($items as $key => $item):
            ?>
                    <a href="<?=$item->url?>">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="blog-one__single">
                        <div class="blog-one__single-inner-block">
                        <div class="scale">
                          <img src="<?=$item->getThumbPath()?>" class="scale" alt="">
                        </div>                       
                            <h1 class="blog-one__title"><?=$item->title?></h1>
                            <p class="blog-one__text" style="margin-bottom: 10px">
                                <?=$item->description?>
                            </p>
                    <div style="position: absolute;bottom: 2%; left: 10%">
                        <?=html::a(yii::t('app', 'Doly maglumat').'  <i class="fa fa-long-arrow-right"></i>',$item->url, ['class' => 'blog-one__link button-underline'])?>
                    </div>
                        </div>
                    </div>
                  </div>
                </a>
               <?php if($key % 4 == 0): ?>
                            <div class="clearfix"></div>
                        <?php endif; ?>
            <?php
                endforeach;
            ?>
<!--             <form style="margin: 100px auto" action="#" class="site-footer__subscribe-form">
                <input type="text" name="email" placeholder="Email salgynyzy yazyn">
                <button type="submit">Ugrat</button>
            </form> -->
            </div>
        </div>
    </div>
</section>
<?php
// $this->registerJsFile('/source/js/wow.js', ['position' => \yii\web\View::POS_END]);

