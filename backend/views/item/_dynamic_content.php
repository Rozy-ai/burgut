<?php

$items = [];

$dynamic_fields = $model->getDynamicFields(true);
$languages = Yii::$app->urlManager->languages;
if (isset($dynamic_fields)) {
    foreach ($languages as $lang){
        foreach ($dynamic_fields as $field) {
            $field_name = $field->field_name;
            if ($field->multilingual == 1 && $field->html_type == 0){
                $content =  $content.$form->field($model, $field_name.'_'.$lang)->textInput();
            }
            if ($field->multilingual == 1 && $field->html_type == 1){
                $content =  $content.$form->field($model, $field_name.'_'.$lang)->widget(\common\widgets\ckeditor\CKEditor::className(), [
                        'clientOptions' => ['rows' => 3, 'height' => 100],
                        'preset' => 'full',
                    ]);
            }
        }
        $items[] = [
            'label' => Yii::t('app', $lang),
            'content' => $content,
        ];
        unset($content);
    }
    echo \yii\bootstrap\Tabs::widget([
        'items' => $items
    ]);
    foreach ($dynamic_fields as $field) {
        $field_name = $field->field_name;
        if ($field->multilingual == 0 && $field->html_type == 0){
            echo $form->field($model, $field_name)->textInput();
        }
        if ($field->multilingual == 0 && $field->html_type == 1){
            $content =  $content.$form->field($model, $field_name)->widget(\common\widgets\ckeditor\CKEditor::className(), [
                    'clientOptions' => ['rows' => 3, 'height' => 100 ],
                    'preset' => 'full',
                ]);
        }
    }
}
?>
