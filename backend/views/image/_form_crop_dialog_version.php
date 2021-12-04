<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ImageWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="image-wrapper-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->hiddenInput( array('id' => 'image_type'))->label(false) ?>
    <?= $form->field($model, 'size')->dropDownList($model->getSizeOptions($model->type), array('id' => 'image_size', 'options' => $model->getSizeByType($model->type))) ?>


    <div class="cropper_wrapper">
        <?php \yii\widgets\Pjax::begin(['id' => 'cropper_wrapper', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET']]) ?>
        <?php
        echo $form->field($model, '_image')->widget(\bilginnet\cropper\Cropper::className(), [
            'cropperOptions' => [
                'width' => $cropper['option']['width'], // must be specified
                'height' => $cropper['option']['height'], // must be specified

                // optional
                // url must be set in update action
                'preview' => [
                    'url' => $cropper['url'], // set in update action // (!$model->isNewRecord) ? Yii::getAlias('@uploadUrl/$model->image') : ''
                    'width' => $cropper['preview']['width'], // default 100 // default is cropperWidth if cropperWidth < 100
                    'height' => $cropper['preview']['height'], // Will calculate automatically by aspect ratio if not set
                ],

                // optional // defaults following code
                // you can customize
                'icons' => [
                    'browse' => '<i class="fa fa-image"></i>',
                    'crop' => '<i class="fa fa-crop"></i>',
                    'close' => '<i class="fa fa-crop"></i>',
                ]
            ],

            // optional // defaults following code
            // you can customize
            'label' => '$model->attribute->label',

        ]);
        ?>
        <?php \yii\widgets\Pjax::end(); ?>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$script = <<< JS
    $('body').on('change',"#image_size",function (e) {
        var selected=$("#image_size :selected");
        var size=selected.val();
        var type=$("#image_type").val();
        
        if(size!==undefined && size!==null){
            $.pjax.reload({container: "#cropper_wrapper",url:document.location.pathname, data:{size:size,type:type}});   
        }else {
            // $('.field-itemwrapper-event_date').hide(200);
            // $('.field-itemwrapper-event_location').hide(200);
        }
    });   
    
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
?>
