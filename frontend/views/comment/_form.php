<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\CommentWrapper */
/* @var $form yii\widgets\ActiveForm */

//$field=\yii\widgets\ActiveField::className()
?>

<div class="comment-form">
    <h4 class="title">Leave a comment</h4>
    <form class="general-form clearfix " action="<?php echo \yii\helpers\Url::toRoute('item/add-comment'); ?>" method="post" name="contact" id="comment-form">

        <div class="field-group row">
            <div class="field col-sm-4">
                <h5>Your Name <span>*</span></h5>
                <input name="CommentWrapper[fullname]" type="text" class="required" title="Please type your name." value="<?=$model->fullname?>"
                       placeholder="Name...">
            </div>

            <div class="field col-sm-4">
                <h5>Your Email <span>*</span></h5>
                <input name="CommentWrapper[email]" type="text" class="required" title="Please type your email." value="<?=$model->email?>"
                       placeholder="Email...">
            </div>
            <div class="field col-sm-4">
                <h5>Your Site</h5>
                <input name="CommentWrapper[site]" type="text" placeholder="site" value="<?=$model->site?>" >
            </div>
        </div>

        <div class="field">
            <h5>Your Comment <span>*</span></h5>
            <textarea name="CommentWrapper[comment]" cols="15" rows="5" class="required" placeholder="Comment..." value="<?=$model->comment?>"
                      title="Please type a comment"></textarea>
        </div>

        <button class="btn big comment_submit"><i class="fa fa-paper-plane"></i>Add Comment</button>
    </form>
</div>



<?php


$script = <<< JS
        // $('body').on('beforeSubmit', 'form#comment-form', function () {
        // // $("form#comment-form").on("beforeSubmit",function () {
        //     debugger;
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

          $('body').on('click','button.comment_submit',function(e) {
            debugger;
            e.preventDefault();
            var form=$(this).parent('form');
            if(form!==undefined){
              var url=form.attr('action');
              var data=form.serializeArray();
             
              $.ajax({
                type: 'POST',
                cache: false,
                url: url,
                data: $('.default-view form').serializeArray(),
                success: function (data) {
                  debugger;
                },
            });
            }
          });          
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
?>


