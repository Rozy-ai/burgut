<?php
if($model->defaultLanguage!==$lang)
    $lang='_'.$lang;
else
    $lang='';

?>

<?= $form->field($model, 'name' . $lang)->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'description' . $lang)->textarea(['rows' => 6]) ?>
<?= $form->field($model, 'alias' . $lang)->textarea(['rows' => 6]) ?>
<?= $form->field($model, 'meta_description' . $lang)->textarea(['rows' => 6]) ?>
<?= $form->field($model, 'meta_keyword' . $lang)->textInput() ?>

