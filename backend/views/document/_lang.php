<?php
if($model->defaultLanguage!==$lang)
    $lang='_'.$lang;
else
    $lang='';

if(!isset($model->{'title' . $lang})){
    $model->{'title' . $lang}=$model->org_filename;
}
?>

<?= $form->field($model, 'title' . $lang)->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'author' . $lang)->textInput(['maxlength' => true]) ?>

