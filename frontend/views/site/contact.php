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
?>

<section class="breadcrumb_area_two parallaxie">
        <!-- <div class="overlay"></div> -->
        <div class="container">
            <div class="row">
            <div class="breadcrumb_content col-12">
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
        </div>
    </section>



<section class="contact" style="margin-bottom: 0">
    <div class="container bg-white">
        <div class="row justify-content-center">

      <div class="col-10 contact_info">
           <!--      <h3 style="margin-bottom: 30px;"><?= $ownInfo->my_title ?></h3> -->
                <div class="row">
                <div class="col-lg-4 contact_data">
                <div class="row">
                    <div class="col-4 d-flex align-self-start contact_icons">
                        <svg xmlns="http://www.w3.org/2000/svg" height="512px" viewBox="0 0 128 128" width="512px" class=""><g><g><path d="m78.777 37.021a14.777 14.777 0 1 0 -14.777 14.779 14.795 14.795 0 0 0 14.777-14.779zm-26.054 0a11.277 11.277 0 1 1 11.277 11.279 11.29 11.29 0 0 1 -11.277-11.279z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"></path><path d="m123.328 121.069-14.266-37.4a1.751 1.751 0 0 0 -1.635-1.126h-27c.165-.269.329-.53.494-.8 10.389-17.2 15.617-32.246 15.542-44.714a32.464 32.464 0 0 0 -64.928-.011c-.075 12.479 5.153 27.527 15.542 44.725.165.273.329.534.494.8h-27a1.751 1.751 0 0 0 -1.635 1.126l-14.264 37.4a1.748 1.748 0 0 0 1.635 2.374h115.386a1.748 1.748 0 0 0 1.635-2.374zm-88.292-84.048a28.964 28.964 0 1 1 57.928.01c.15 24.858-23.09 55.517-28.964 62.869-5.874-7.349-29.115-38-28.964-62.879zm27.631 66.779a1.75 1.75 0 0 0 2.666 0 185.716 185.716 0 0 0 12.9-17.759h27.987l2.24 5.875-54.691 19.451-19.494-25.329h15.49a185.716 185.716 0 0 0 12.902 17.762zm-8.959 11.3h.01l32.627-11.6 12.655 16.443h-58.9zm-31.93-29.062h8.08l20.442 26.562-20.643 7.342h-20.81zm81.643 33.905-13.609-17.682 19.9-7.077 9.443 24.759z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"></path></g></g></svg>
                    </div>
                    <div class="col-8">
                        <h4>Türkmenistan</h4>
                        <p><?= $ownInfo->my_address ?></p>
                    </div>
                </div>
                </div>
       

                <div class="col-lg-4 contact_data">
                <div class="row">
                    <div class="col-4 d-flex align-self-start contact_icons">
                        <svg xmlns="http://www.w3.org/2000/svg" height="512px" viewBox="0 0 512 512.00102" width="512px" class=""><g><path d="m274.601562 168.46875c38.007813 0 68.929688 30.921875 68.929688 68.929688 0 4.210937 3.414062 7.621093 7.621094 7.621093h30.496094c4.210937 0 7.625-3.410156 7.625-7.621093 0-63.230469-51.441407-114.671876-114.671876-114.671876-4.210937 0-7.625 3.414063-7.625 7.625v30.492188c0 4.210938 3.414063 7.625 7.625 7.625zm7.625-30.203125c48.753907 3.714844 87.792969 42.753906 91.507813 91.507813h-15.300781c-3.636719-40.34375-35.863282-72.570313-76.210938-76.210938v-15.296875zm0 0" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"></path><path d="m279.683594 106.816406c69.203125 0 125.5 56.296875 125.5 125.5 0 4.210938 3.414062 7.625 7.625 7.625h30.492187c4.210938 0 7.625-3.414062 7.625-7.625 0-94.421875-76.820312-171.242187-171.242187-171.242187-4.210938 0-7.621094 3.414062-7.621094 7.625v30.492187c0 4.210938 3.410156 7.625 7.621094 7.625zm7.625-30.3125c79.960937 3.867188 144.316406 68.226563 148.183594 148.1875h-15.265626c-3.839843-71.550781-61.367187-129.082031-132.917968-132.917968zm0 0" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"></path><path d="m284.769531 45.742188c100.074219 0 181.488281 81.417968 181.488281 181.492187 0 4.207031 3.414063 7.621094 7.625 7.621094h30.492188c4.210938 0 7.625-3.414063 7.625-7.621094 0-25.816406-4.261719-51.105469-12.667969-75.15625-1.386719-3.976563-5.734375-6.074219-9.710937-4.683594-3.972656 1.390625-6.070313 5.738281-4.683594 9.710938 7.011719 20.0625 10.933594 41.054687 11.683594 62.503906h-15.261719c-3.925781-102.425781-86.542969-185.042969-188.96875-188.96875v-15.261719c53.765625 1.886719 104.035156 23.71875 142.273437 61.957032 14.910157 14.910156 27.441407 31.769531 37.253907 50.109374 1.984375 3.714844 6.605469 5.113282 10.316406 3.128907 3.714844-1.988281 5.113281-6.605469 3.128906-10.320313-10.519531-19.664062-23.949219-37.730468-39.917969-53.699218-42.917968-42.917969-99.980468-66.554688-160.675781-66.554688-4.210937 0-7.625 3.414062-7.625 7.625v30.492188c0 4.210937 3.414063 7.625 7.625 7.625zm0 0" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"></path><path d="m426.28125 308.117188c-6.667969-6.671876-15.53125-10.34375-24.964844-10.34375-9.429687 0-18.296875 3.671874-24.964844 10.34375l-37.589843 37.589843c-16.453125 16.453125-43.222657 16.453125-59.675781 0l-112.792969-112.796875c-16.453125-16.453125-16.453125-43.222656-.003907-59.671875l37.59375-37.59375c6.667969-6.667969 10.34375-15.535156 10.34375-24.964843 0-9.429688-3.675781-18.296876-10.34375-24.964844l-75.386718-75.375c-13.765625-13.765625-36.164063-13.765625-49.929688 0l-28.871094 28.871094c-32.046874 32.039062-49.695312 74.644531-49.695312 119.957031 0 45.316406 17.648438 87.917969 49.695312 119.960937l13.964844 13.964844c2.976563 2.976562 7.804688 2.976562 10.78125 0 2.976563-2.980469 2.976563-7.804688 0-10.78125l-13.964844-13.964844c-29.164062-29.160156-45.230468-67.933594-45.230468-109.179687 0-38.691407 14.136718-75.207031 39.96875-103.652344l103.617187 103.617187-3.320312 3.320313c-22.398438 22.398437-22.398438 58.84375 0 81.238281l112.792969 112.796875c22.398437 22.394531 58.839843 22.394531 81.238281.003907l3.324219-3.328126 103.601562 103.605469c-17.449219 15.804688-38.339844 27.5-60.867188 33.976563-54.03125 15.507812-112.253906.480468-151.949218-39.222656l-143.796875-143.800782c-2.980469-2.976562-7.804688-2.976562-10.78125 0-2.976563 2.980469-2.976563 7.804688 0 10.78125l143.796875 143.800782c32.253906 32.261718 75.636718 49.699218 120.066406 49.695312 15.636719 0 31.417969-2.160156 46.875-6.597656 27.4375-7.890625 52.671875-22.792969 72.976562-43.097656l28.871094-28.871094c13.765625-13.765625 13.765625-36.164063 0-49.929688zm-360.414062-263.515626 23.480468-23.480468c7.820313-7.820313 20.546875-7.820313 28.367188 0l75.386718 75.375c3.789063 3.789062 5.875 8.828125 5.875 14.183594 0 5.359374-2.085937 10.394531-5.875 14.1875l-23.488281 23.484374zm425.011718 378.050782-23.484375 23.480468-103.746093-103.75 23.488281-23.484374c3.785156-3.789063 8.824219-5.875 14.179687-5.875 5.359375 0 10.398438 2.085937 14.183594 5.875l75.378906 75.386718c3.789063 3.789063 5.875 8.828125 5.875 14.183594s-2.085937 10.394531-5.875 14.183594zm0 0" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"></path></g></svg>
                    </div>
                    <div class="col-8">
                        <h4>Telefon belgiler</h4>
                        <p><a href="<?= $ownInfo->my_phone ?>" target="_blank"><?= $ownInfo->my_phone ?></a><br></p>
                    </div>
                </div>
            </div>

      
                <div class="col-lg-4 contact_data">
                <div class="row">
                    <div class="col-4 d-flex align-self-start contact_icons">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Layer_1" x="0px" y="0px" viewBox="0 0 469.333 469.333" style="enable-background:new 0 0 469.333 469.333;" xml:space="preserve" width="512px" height="512px" class=""><g><g> <g> <g> <path d="M469.333,181.26c-0.021-3.333-1.604-6.458-4.271-8.458l-38.396-28.797v-26.672c0-2.833-1.125-5.542-3.125-7.542     L316.875,3.125c-2-2-4.708-3.125-7.542-3.125h-224C61.812,0,42.667,19.135,42.667,42.667v101.339L4.271,172.802     c-2.667,2-4.25,5.125-4.271,8.458c0,0.026,0.017,0.047,0.017,0.073H0v245.333c0,23.531,19.146,42.667,42.667,42.667h384     c23.521,0,42.667-19.135,42.667-42.667V181.333h-0.017C469.316,181.307,469.333,181.286,469.333,181.26z M426.667,170.659     l14.417,10.81c-3.905,3.031-8.874,6.893-14.417,11.208V170.659z M320,36.417l70.25,70.25h-48.917     c-11.771,0-21.333-9.573-21.333-21.333V36.417z M64,42.667c0-11.76,9.563-21.333,21.333-21.333h213.333v64     c0,23.531,19.146,42.667,42.667,42.667h64v81.323c-14.94,11.681-32.137,25.18-49.859,39.198     c-5.341-8.363-12.677-15.422-21.641-19.979c-23.208-11.802-59.271-25.875-99.167-25.875s-75.958,14.073-99.167,25.875     c-8.997,4.576-16.355,11.664-21.707,20.061C96.095,234.577,78.921,221.068,64,209.38V42.667z M338.833,261.72     c-35.638,28.339-70.63,56.678-89.625,73.499c-4.479,3.948-18.542,9.625-29.417,0c-19.102-16.908-53.923-45.163-89.371-73.404     c3.322-6.081,8.396-11.023,14.746-14.253c21.146-10.75,53.813-23.563,89.5-23.563s68.354,12.813,89.5,23.563     C330.488,250.77,335.525,255.68,338.833,261.72z M42.667,170.664v22.042c-5.544-4.324-10.51-8.19-14.417-11.227L42.667,170.664z      M448,426.667c0,11.76-9.563,21.333-21.333,21.333h-384c-11.771,0-21.333-9.573-21.333-21.333V203.117     c44.484,34.622,147.363,115.349,184.333,148.081c8.479,7.5,18.375,11.469,28.667,11.469c10.354,0,20.646-4.073,29-11.469     C301.754,317.191,406.669,235.228,448,203.109V426.667z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"></path> <path d="M234.667,192c35.292,0,64-28.708,64-64c0-35.292-28.708-64-64-64s-64,28.708-64,64     C170.667,163.292,199.375,192,234.667,192z M234.667,85.333c23.521,0,42.667,19.135,42.667,42.667s-19.146,42.667-42.667,42.667     S192,151.531,192,128S211.146,85.333,234.667,85.333z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#FFFFFF"></path> </g> </g> </g></g> </svg>
                    </div>
                    <div class="col-8">
                        <h4>EMAIL</h4>
                                                <p> <a href="mailto:www.begleryoly.com" target="_blank"><?= $ownInfo->my_email ?><br></a></p>
                    </div>
                </div>
            </div>
        </div>
            </div>

            <div class="col-md-6 contact_form">
                <form id="contact-form" action="/site/a/contact" method="post">
<input type="hidden" name="_csrf-frontend" value="LV4UWaGshnLHKnl_9tcJaml3cg5KusLQiPAVMbPq9MdYGSAo7ujLKI8fGzjArj5dPC0dNwPWtuXrtE0D3aSrqg==">                <div class="row">
                    <div class="col-md-12">
                     <!--    <h5 class="uppercase" style="font-weight: 550;color: #1273ed;">Habarlaşmak</h5>
                        <h2 style="color:#000;margin-bottom: 40px;">Bize email ýollaň</h2> -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group field-contactwrapper-name required">

<input type="text" id="contactwrapper-name" class="form-control big-input" name="ContactWrapper[name]" placeholder="Adyňyz" aria-required="true">

<p class="help-block help-block-error"></p>
</div>                            </div>
                            <div class="col-md-6">
                                <div class="form-group field-contactwrapper-email required">

<input type="text" id="contactwrapper-email" class="form-control big-input" name="ContactWrapper[email]" placeholder="Email" aria-required="true">

<p class="help-block help-block-error"></p>
</div>                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group field-contactwrapper-subject required">

<input type="text" id="contactwrapper-subject" class="form-control big-input" name="ContactWrapper[subject]" placeholder="Mowzuk" aria-required="true">

<p class="help-block help-block-error"></p>
</div>                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group field-contactwrapper-message required">

<textarea id="contactwrapper-message" class="form-control big-input" name="ContactWrapper[message]" rows="6" placeholder="Mazmuny" aria-required="true"></textarea>

<p class="help-block help-block-error"></p>
</div>                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button style="width: 100%" type="submit" class="btn btn_send" name="contact-button">Ugrat</button>                        </div>
                    </div>
                </div>
                </form>            </div>
                <div class="col-md-6">
                    <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A7f97c96cd8fb057cf1f914e75f4ef618bc4ba4097bab8d26e4cd324e54f8c48b&amp;source=constructor" width="100%" height="467" frameborder="0"></iframe>
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




      