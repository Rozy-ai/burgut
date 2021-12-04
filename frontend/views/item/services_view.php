<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
    $date = yii::$app->controller->renderDateToWord($model->date_created);
?>

<div class="container">
    <h1><?= $model->title; ?></h1>
    <p><?= $model->content; ?></p>
    <br>
    <br>
    <br>
<div class="row">
                        <h2 class="slick_arrow_text">Lorem ipsum dolor sit amet consectetur.</h2>
                        <section class="regular slider">
        <?php
$category = \common\models\wrappers\CategoryWrapper::find()->where(['code' => 'services'])->one();
$catId = $category->id;
$projects = \common\models\wrappers\ItemWrapper::find()->where(['category_id' => $catId, 'status' => '1'])->orderBy('Rand()')->limit(8)->all();

?>
                 <?php
                    foreach ($projects as $project):
                ?>

           <a href="<?= '/item/'.$project->id; ?>">
      <?=html::img($project->getThumbPath(),['class' => 'my_img', 'style' => 'height : 200px'])?>
      </a>

                    <?php
                    endforeach;
                ?>
            

        </section>
    </div>
  </div>

  <div class="container-fluid" style="background-color: #E9EFFF;">
<div class="container py-5">
    <div class="contact1">
        <div class="container-contact1">
            <div class="row">



<div class="row contact_inner">
<div class="col-md-6">
  <h1><?= yii::t('app', "Let's talk?")?></h1>
  <p style="margin-bottom: 35px">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et quam est. Mauris faucibus tellus ac auctor posuere.</p>

  <h4><?= yii::t('app', 'Phone')?></h4>
  <p>+993 61 000000 <br>+993 61 000000</p>

  <h4><?= yii::t('app', 'Our email')?></h4>
  <p>test@gmail.com <br>test@gmail.com</p>

  <h4><?= yii::t('app', 'Our address')?></h4>
  <p>Aşgabat şäher Gurtly 38-nji öý

</div>

                    <?php $form = ActiveForm::begin([
                        'id' => 'contact-form',
                        'options' => [
                            'class' => 'validate-form col-md-6 info_contact',
                        ],
                        'enableClientValidation' => false,
                        'enableAjaxValidation' => false]); ?>
                        <div class="row">
                    <div class="validate-input form-group col-md-6" style="width: 100%" data-validate="Name is required">
                        <?= $form->field($contact, 'name')->textInput(['autofocus' => true, 'class' => 'form-control', 'style' => 'background-color: #313C74', 'placeholder' => yii::t('app', 'Name')])->label(false)?>
                        <span class="shadow-input1"></span>
                    </div>

                    <div class="validate-input form-group col-6" style="width: 100%" data-validate="Number is required">
                        <?= $form->field($contact, 'phone')->textInput(['autofocus' => true, 'class' => 'form-control','style' => 'background-color: #313C74', 'placeholder' => yii::t('app', 'Phone')])->label(false)?>
                        <span class="shadow-input1"></span>
                    </div>

                    <div class="validate-input form-group col-6" style="width: 100%" data-validate="Subject is required">
                        <?= $form->field($contact, 'subject')->textInput(['class' => 'form-control', 'style' => 'background-color: #313C74','placeholder' => yii::t('app', 'Subject')])->label(false) ?>
                        <span class="shadow-input1"></span>
                    </div>

                    <div class="validate-input form-group col-md-6" style="float: right" data-validate="Valid email is required: ex@abc.xyz">
                        <?= $form->field($contact, 'email')->textInput(['class' => ' form-control','style' => 'background-color: #313C74', 'placeholder' => yii::t('app', 'Email')])->label(false) ?>
                        <span class="shadow-input1"></span>
                    </div>

                    <div class="validate-input form-group col-12" data-validate="Message is required">
                        <?= $form->field($contact, 'message')->textarea(['cols' => 100, 'rows' => 6,  'class' => 'form-control','style' => 'background-color: #313C74', 'placeholder' => yii::t('app', 'Message')])->label(false) ?>
                        <span class="shadow-input1"></span>
                    </div>
                    <div class="form-group col-12 text-right">
                    <button class="contact1-form-btn btn btn-outline-success my-2 my-sm-0">
<span>
<?=yii::t('app','Send')?>
    <i class="fa fa-long-arrow-right" style="color: #2ADFB4" aria-hidden="true"></i>
</span>
                    </button>
                        <?php ActiveForm::end(); ?>
    </div>
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
</div>


  <div class="service_view_cards container">
            <div class="row">
                <div class="col-md-3">
                    <div class="service_view_card_content">
                    <h2><?=yii::t('app','Take a look at our other skills')?></h2>
                </div>
                </div>
                <?php
                    if (isset($model->first_child_function) &&  $model->first_child_function != null):
                ?>
                <div class="col-md-3 child_func_block">
                    <div class="service_view_card d-flex w-100 h-100">
                        <div class="service_view_card_content">
                            <?=$model->first_child_function?>
                        </div>
                    </div>
                </div>
                <?php
                    endif;
                ?>
                <?php
                if (isset($model->second_child_function) &&  $model->second_child_function != null):
                    ?>
                    <div class="col-md-3 child_func_block">
                        <div class="service_view_card d-flex w-100 h-100">
                            <div class="service_view_card_content">
                                <?=$model->second_child_function?>
                            </div>
                        </div>
                    </div>
                <?php
                endif;
                ?>
                <?php
                if (isset($model->third_child_function) &&  $model->third_child_function != null):
                    ?>
                    <div class="col-md-3 child_func_block">
                        <div class="service_view_card d-flex w-100 h-100">
                            <div class="service_view_card_content">
                                <?=$model->third_child_function?>
                            </div>
                        </div>
                    </div>
                <?php
                endif;
                ?>
            </div>
        </div>