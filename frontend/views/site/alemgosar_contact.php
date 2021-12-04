<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\widgets\Breadcrumbs;

$this->title = Yii::t('app', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
$lat = isset($ownInfo->my_latitude) ? $ownInfo->my_latitude : "0";
$lng = isset($ownInfo->my_longitude) ? $ownInfo->my_longitude : "0";
$style = 'background: linear-gradient(90deg, rgba(204,43,94,1) 0%, rgba(117,58,136,1) 100%) center center no-repeat;background-size: cover;
        background-attachment: fixed;';
?>

    <section class="breadcrumb_area_two parallaxie" style="<?=$style?>">
        <div class="overlay"></div>
        <div class="container">
            <div class="breadcrumb_content">
                <?php if(isset($this->title) && !isset($this->params['no-title'])) { echo'<h1>'.$this->title.'</h1>'; } ?>
                <?php
                echo Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => Yii::t('app', 'Home'),
                        'url' => Yii::$app->homeUrl,
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'options' => [
                            'class' => 'nav'
                    ]
                ]);
                ?>
            </div>
        </div>
    </section>
<section class="header_page service_list_page">
    <div class="container">
        <div class="page_title">
            <div class="title_text_block">
                <div class="title_text_decoration"></div>
                <h1 style="margin-top: 2%"><?=$this->title?></h1>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="contact1">
        <div class="container-contact1">
            <div class="row">
<style type="text/css">

.address{
  margin-top: 4%;
  text-align: center;
}
.info_contact{
  margin-top: 2%!important;
}
.form-control {
  border: 1px solid 1E98FF;
  color: #1E98FF;
}
.form-control:focus {
  border-color: #1E98FF;
  outline: 0;
  box-shadow: none;
}
.btn-outline-success {
  color: #1E98FF;
  background-color: transparent;
  border-color: #1E98FF;
}
.btn-outline-success:hover {
  color: #fff;
  background-color: #1E98FF;
  border-color: #1E98FF;
}
.contact_info{
  padding: 60px 0;
}
.contact_info span{
  color: #A386F3;
  font-size: 30px;
}
.contact_info h4{
  color: #101010;
  font-size: 24px;
  margin-bottom: 14px;
}
.contact_info p{
  color: #777;
  font-size: 16px;
  margin-bottom: 16px;
}
</style>
<div class="col-12" style="margin-top: -18%; z-index: 99">
  <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A7f97c96cd8fb057cf1f914e75f4ef618bc4ba4097bab8d26e4cd324e54f8c48b&amp;source=constructor" width="100%" height="467" frameborder="0"></iframe>
</div>
<div class="col-md-3 col-sm-6 col-12 contact_info">
  <span class="fa fa-map-marker"></span>
  <h4><?= yii::t('app', 'Our address')?></h4>
  <p>Aşgabat şäher Gurtly 38-nji öý
</div>
<div class="col-md-3 col-sm-6 col-12 contact_info">
  <span class="fa fa-phone"></span>
  <h4><?= yii::t('app', 'Phone')?></h4>
  <p>+993 61 000000 <br>+993 61 000000</p>
</div>
<div class="col-md-3 col-sm-6 col-12 contact_info">
  <span class="fa fa-envelope"></span>
  <h4><?= yii::t('app', 'Our email')?></h4>
  <p>test@gmail.com <br>test@gmail.com</p>
</div>
<div class="col-md-3 col-sm-6 col-12 contact_info">
  <span class="fa fa-paper-plane"></span>
  <h4><?= yii::t('app', 'Social icons')?></h4>
  <ul class="list-unstyled social_link social_link_two">
    <li>
      <a title="linkedin" href="https://www.linkedin.com/company/turkmenportal">
        <i style="color: #FF33D3" class="fa fa-linkedin-square"></i>
        <i style="color: #FF33D3" class="fa fa-linkedin-square"></i>
      </a>
    </li>
    <li>
      <a title="facebook" href="https://www.facebook.com/tphabar">
        <i style="color: #FF33D3" class="fa fa-facebook"></i>
        <i style="color: #FF33D3" class="fa fa-facebook"></i>
      </a>
    </li>
    <li>
      <a title="twitter" href="https://twitter.com/turkmenportal">
        <i style="color: #FF33D3" class="fa fa-twitter"></i>
        <i style="color: #FF33D3" class="fa fa-twitter"></i>
      </a>
    </li>
    <li>
      <a title="instagram" href="https://www.instagram.com/turkmenportal">
        <i style="color: #FF33D3" class="fa fa-instagram"></i>
        <i style="color: #FF33D3" class="fa fa-instagram"></i>
      </a>
    </li>
       <li>
      <a title="vk" href="https://vk.com/turkmenportal">
        <i style="color: #FF33D3" class="fa fa-vk "></i>
        <i style="color: #FF33D3" class="fa fa-vk "></i>
      </a>
    </li>
       <li>
      <a title="youtube" href="https://www.youtube.com/channel/UCaVOiK81-Z30BGDnM2Udslw">
        <i style="color: #FF33D3" class="fa  fa-youtube-play"></i>
        <i style="color: #FF33D3" class="fa  fa-youtube-play"></i>
      </a>
    </li>
  </ul>
</div>
<hr style="height: 2px; width: 100%">
<div class="row contact_inner" style="padding: 80px 0">
<div class="col-md-6">
  <h1><?= yii::t('app', "Let's talk?")?></h1>
  <p style="margin-bottom: 35px">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et quam est. Mauris faucibus tellus ac auctor posuere.</p>
</div>
                    <?php $form = ActiveForm::begin([
                        'id' => 'contact-form',
                        'options' => [
                            'class' => 'contact1-form validate-form col-md-6 info_contact',
                        ],
                        'enableClientValidation' => false,
                        'enableAjaxValidation' => false]); ?>
                    <div class="wrap-input1 validate-input form-group col-12" data-validate="Name is required">
                        <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'class' => 'input1 form-control mr-sm-2', 'placeholder' => yii::t('app', 'Name')])->label()?>
                        <span class="shadow-input1"></span>
                    </div>
                    <div class="wrap-input1 validate-input form-group col-12" data-validate="Number is required">
                        <?= $form->field($model, 'phone')->textInput(['autofocus' => true, 'class' => 'input1 form-control mr-sm-2', 'placeholder' => yii::t('app', 'Phone')])->label()?>
                        <span class="shadow-input1"></span>
                    </div>

                    <div class="wrap-input1 validate-input form-group col-12" data-validate="Valid email is required: ex@abc.xyz">
                        <?= $form->field($model, 'email')->textInput(['class' => 'input1 form-control mr-sm-2', 'placeholder' => yii::t('app', 'Email')])->label() ?>
                        <span class="shadow-input1"></span>
                    </div>
                    <div class="wrap-input1 validate-input form-group col-12" data-validate="Subject is required">
                        <?= $form->field($model, 'subject')->textInput(['class' => 'input1 form-control mr-sm-2', 'placeholder' => yii::t('app', 'Subject')])->label() ?>
                        <span class="shadow-input1"></span>
                    </div>
                    <div class="wrap-input1 validate-input form-group col-12" data-validate="Message is required">
                        <?= $form->field($model, 'message')->textarea(['rows' => 6, 'class' => 'input1 form-control mr-sm-2', 'placeholder' => yii::t('app', 'Message')])->label() ?>
                        <span class="shadow-input1"></span>
                    </div>
                    <div class="form-group col-12">
                    <button class="contact1-form-btn btn btn-outline-success my-2 my-sm-0">
<span>
<?=yii::t('app','Send')?>
    <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
</span>
                    </button>
                        <?php ActiveForm::end(); ?>
    </div>
    </div>
            
<!--             <div class="container">
              <div class="row">
                <img src="/img/Contacts.png">
              </div>
            </div> -->
            </div>
        </div>
    </div>
</div>
<?php



$script = <<< JS

        // $('#contact-form').on('beforeSubmit', function(e) {
        //     var form = $(this);
        //     var formData = form.serialize();
        //     $.ajax({
        //         url: form.attr("action"),
        //         type: form.attr("method"),
        //         data: formData,
        //         success: function (data) {
        //             alert('Test');
        //         },
        //         error: function () {
        //             alert("Something went wrong");
        //         }
        //     });
        // }).on('submit', function(e){
        //     e.preventDefault();
        // });

      // var map_style=[{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"color":"#f7f1df"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#d0e3b4"}]},{"featureType":"landscape.natural.terrain","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.medical","elementType":"geometry","stylers":[{"color":"#fbd3da"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#bde6ab"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffe15f"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#efd151"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"color":"black"}]},{"featureType":"transit.station.airport","elementType":"geometry.fill","stylers":[{"color":"#cfb2db"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#a2daf2"}]}];

      function initMap() {
            var action=$('#action').val() || 'create';
            var lat=$lat;
            var lng=$lng;
            var infowindow = new google.maps.InfoWindow();
            
            if(lng!==undefined && lat!==undefined && lat!=0 && lng!=0){
              var center = new google.maps.LatLng(lat, lng);
              map = new google.maps.Map(document.getElementById('map'), {
                  center: center,
                  zoom: 16,
                  mapTypeId: google.maps.MapTypeId.ROADMAP,
                  // styles: map_style
                  // mapTypeId: 'satellite'
                  // gestureHandling: 'greedy'
              });
          
              marker = new google.maps.Marker({
                  map: map,
                  position: center,
                  draggable: action=='create',
              });
              
              infowindow.setContent("$ownInfo->my_address");
              infowindow.open(map, marker);
          }
      }
       
      initMap();

JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
?>
