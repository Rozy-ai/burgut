<?php
if($model->defaultLanguage!==$lang)
    $lang='_'.$lang;
else
    $lang='';

?>

<?= $form->field($model, 'title' . $lang)->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'description' . $lang)->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'btn_title' . $lang)->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'btn_link' . $lang)->textInput(['maxlength' => true]) ?>



