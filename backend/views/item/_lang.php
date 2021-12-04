<?php
if($model->defaultLanguage!==$lang)
    $lang='_'.$lang;
else
    $lang='';

?>

<?= $form->field($model, 'title' . $lang)->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'description' . $lang)->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'content' . $lang)->widget(\common\widgets\ckeditor\CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'full',
]) ?>
