<?php
$dynamic_fields = $model->getDynamicFields(true);
if (isset($dynamic_fields)) {
    foreach ($dynamic_fields as $field) {
        $field_name = $field->field_name;
        echo $form->field($model, $field_name)->textInput();
    }
}
?>
