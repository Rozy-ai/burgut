<?php
if($model->defaultLanguage!==$lang)
    $lang='_'.$lang;
else
    $lang='';

?>

<?= $form->field($model, 'field_description'.$lang)->textInput() ?>