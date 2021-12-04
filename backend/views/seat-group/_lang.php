<?php
if($model->defaultLanguage!==$lang)
    $lang='_'.$lang;
else
    $lang='';

?>

<?= $form->field($model, 'name' . $lang)->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'description' . $lang)->textarea(['rows' => 6]) ?>
