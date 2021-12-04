<?php
use common\models\wrappers\CategoryWrapper;
use common\models\wrappers\ItemWrapper;
use dosamigos\gallery\Carousel;
use common\widgets\SubscriptionWidget\SubscriptionWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\slider\Slider;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


$this->title = Yii::t('app', 'Home');
// $serviceCategory = CategoryWrapper::find()->where(['code' => 'service'])->andWhere(['OR', 'parent_id is null', 'parent_id=0'])->one();
// $overviewCategory = CategoryWrapper::find()->where(['code' => 'overview'])->andWhere(['OR', 'parent_id is null', 'parent_id=0'])->one();
// $categories = CategoryWrapper::find()->where(['status' => '1', 'top' => '1'])->all();
// foreach ($categories as $category) {
//     $categoryLink = [$category->code => $category->url];
// }
?>


  <!-- Carusel -->

  <section class="container-fluid corusel_top p-0">
  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">

  <div class="carousel-indicators">

    <?php
            foreach ($sliders as $key => $slide):
                if ($key == 0){
                    $class = 'active';
                } else {
                    $class = '';
                }
                    ?>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?=$key?>" class="<?=$class?>" aria-current="true" aria-label="Slide <?=$key?>"></button>
            <?php
                endforeach;
            ?>

  </div>

  <div class="carousel-inner">
        

    <?php foreach ($sliders as $key => $slider): ?>
    <?php 
        $imagePath = $slider->getThumbPath();
 ?>
 <div class="carousel-item <?= ($key==1)?'active':'' ?>" >
      <?=html::img($imagePath,['class'=>'corusel_top_img','alt'=>'...'])?>
                <div class="carousel-caption d-none d-md-block">
            <div class="slider_text_block">
              <div class="layer-3-3">
                <h1 class="a-1"><?=$slider->title?></h1>
              </div>
              <div class="layer-1-3">
                <p class="a-2"><?=$slider->description?></p>
              </div>
              <div class="layer-1-4">
                <?php if ($slider->btn_link != ''): ?>
                <p class="slider_btn_block a-6"><?=html::a($slider->btn_title,$slider->btn_link,['class' => 'btn btn_in_slider'])?></p>
              <?php endif; ?>
              </div>
            </div>
          </div>
    </div>
<?php endforeach; ?>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
  </section>
  <!-- end carusel -->

  <!-- Start advantages -->


  <section class="index_tab">
    <div class="container">
<ul class="nav nav-tabs" id="myTab">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><?= yii::t('app', 'New  ') ?></button>
  </li>

</ul>


 
    <div class="row">
        <div class="regular_tab slider">
            <?php foreach ($new_products as $key => $product): ?>
          <div class="card" style="width: 18rem;">
            <a href="<?= '/item/'.$product->id; ?>" class="hover14">
              <figure>
             
              <?=html::img($product->getThumbPath(),['class' => 'card-img-top']) ?>
                </figure>
              </a>
            <?php if(isset($product->skidka)){
                        echo " <span class='skidka'>".$product->skidka."</span>";
                    } ?>
            <div class="eye select_box d-flex justify-content-center align-items-center"><a href="<?= '/item/'.$product->id; ?>"><i class="fa fa-eye"></i></a></div>
         <!--    <div class="reload select_box d-flex justify-content-center align-items-center"><a href="/"><i class="fa fa-refresh"></i></a></div> -->
            <div class="like select_box d-flex justify-content-center align-items-center"><a class="like-Unlike" href="<?= Url::to(['site/like', 'id' => $product->id]) ?>" data-id="<?= $product->id?>"><i class="fa fa-heart-o"></i></a></div>
<!--             <div class="market select_box d-flex justify-content-center align-items-center"><a href="#"><i class="fa fa-cart-plus"></i></a></div> -->
            <div class="card-body">
              <h5 class="card-title text-center"><?= $product->title ?></h5>
              <p class="text-center"></p>
            </div>
          </div>
<?php endforeach; ?>

        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-12 d-flex justify-content-center">
          <a href="<?=$category->url?>"><button type="button" class="btn btn-light" style="border:2px solid black; background: #fff"><?= yii::t('app', 'Show all') ?></button></a>
        </div>
      </div>
  


    </div>
  </section>

    <section class="about_us">
    <div class="container">
      <?php 

       ?>
      <div class="row justify-content-between">
        <?php foreach ($advantages as $advantage): ?>
          <?php 
          $icon = json_decode($advantage->icon , true);
       

           ?>
                      <div class="col-lg-4 col-sm-12 bg-white function_box">
                <div class="overlay_function_box">
                    <div class="overlay_function_box_top"></div>
                    <div class="overlay_function_box_bottom"></div>
                </div>
                <div class="box-body">
                  <div class="box-body-img">
              
                        <i class="<?=$icon['class']?>"> </i>
                        <h3 class=""><?=$advantage->title?></h3>
                    </div>
                 
                    <div class="box-body-content">
                        <p><?= $advantage->content ?></p>
                    </div>
                    
                </div>
            </div>

   

        <?php endforeach; ?>
      </div>
    </div>

  </section>

  
  <section class="blog">
    <div class="container">

      <h2><?= yii::t('app' , 'News') ?></h2>
      <div class="row">
        <div class="regular slider">


           <?php foreach ($blogs as $key => $blog): ?>
            <?php  $date = yii::$app->controller->renderDateToWord($blog->date_created);
?>

          <div class="card" style="width: 18rem;">
            <?=html::img($blog->getThumbPath(),['class' => 'card-img-top','alt'=>'$blog->title']) ?>
            <div class="card-body">
              <span><?= $date ?></span>
              <a href="<?= $blog->url; ?>" style="text-decoration: none; color: #000;"> 
              <h5 class="card-title"><?= $blog->title; ?></h5>
            </a>
              <p class="card-text"><?= $blog->description; ?></p>
            </div>
          </div>
           <?php endforeach; ?>

        </div>

        <div class="col-12 d-flex justify-content-center">
          <a href="<?=$category_blog->url?>"><button type="button" class="btn btn-light" style="border:2px solid black"><?= yii::t('app', 'Show all') ?></button></a>
        </div>
      </div>
    </div>

  </section>

  <section class="about">


    <div class="parallax">
    <div class="container">
      <div class="row">
        <div class="col-md-5 about_data">
          <h3> <?= $ownInfo->my_title ?></h3>
          <p><?= $ownInfo->my_description ?></p>
        </div>

      </div>
    </div>
    </div>
  </section>

  <section class="write">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-sm-5 d-flex justify-content-center">
          <h3><?= yii::t("app", "Subscribe to us") ?></h3>
          
        </div>
        <div class="col-sm-7 d-flex justify-content-end">

    <?php $form = ActiveForm::begin([
            'action' => yii\helpers\Url::to(['site/subscribe'])]); ?>
        <div class="row write_form_in">
          <div class="col-8">
            <?=$form->field($model, 'email')->textInput(['placeholder'=>yii::t('app', 'Enter your email address'), 'class' =>'form-control'])->label(false);?>
          </div>
          <div class="col-4">
            <?=Html::submitButton(yii::t("app", "subscribe") ,  ['class' => 'btn btn-primary mb-2']); ?>
          </div>
        </div>
    
    
    <?php ActiveForm::end(); ?>

    <div style="clear:both;"></div>

       
        </div>

      </div>
    </div>
  </section>
  <section class="partners">


    <div class="center slider">
 <?php foreach ($partners as $partner): ?>

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

  <?php
  // $this->registerJS('
    
  //   var next = "'.yii::t('app','next').'"
  //   var prev = "'.yii::t('app','prev').'"

  //   $(".regular_tab").slick({
  //       dots: false,
  //       infinite: true,
  //       fade: false,
  //       slidesToShow: 4,
  //       slidesToScroll: 1,
  //       prevArrow: "<div class=\'slick_prev\'> "+prev+"</div>",
  //       nextArrow: "<div class=\'slick_next\'> "+next+"<span>" + " | "+" </span></div>",
  //         responsive: [
  //     {
  //       breakpoint: 750,
  //       settings: {
  //         slidesToShow: 2,
  //         slidesToScroll: 1
  //       }
  //     },
  //     {
  //       breakpoint: 550,
  //       settings: {
  //         slidesToShow: 1,
  //         slidesToScroll: 1
  //       }
  //     },
  //   ]
  //     });

  // ',\yii\web\View::POS_END);





