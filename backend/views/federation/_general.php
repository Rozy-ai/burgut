<?php

use kartik\widgets\Select2;

?>

<?php

?>


<?php
echo $this->render('_content', [
    'model' => $model,
    'form' => $form,
])
?>

<?php
$data = [];
$newsCategory = \common\models\wrappers\CategoryWrapper::find()->where(['code' => 'news'])->andWhere(['OR', 'parent_id is null', 'parent_id=0'])->one();
$newsCategories = \common\models\wrappers\CategoryWrapper::find()->where(['status' => 1])->andWhere(['parent_id' => $newsCategory->id])->orderBy('sort_order')->all();
foreach ($newsCategories as $cat) {
    $data[$cat->id] = $cat->name;
}
?>


<?php
//echo '<label class="control-label">Tag Multiple</label>';
//echo Select2::widget([
//    'name' => 'cats[]',
//    'value' => $model->cats, // initial value
//    'data' => $data,
//    'maintainOrder' => true,
//    'toggleAllSettings' => [
//        'selectLabel' => '<i class="fa fa-ok-circle"></i> Tag All',
//        'unselectLabel' => '<i class="fa fa-remove-circle"></i> Untag All',
//        'selectOptions' => ['class' => 'text-success'],
//        'unselectOptions' => ['class' => 'text-danger'],
//    ],
//    'options' => ['placeholder' => 'Select relaed categories ...', 'multiple' => true],
//    'pluginOptions' => [
//        'tags' => true,
//        'maximumInputLength' => 10
//    ],
//]);

echo $form->field($model, 'cats')->widget(Select2::classname(), [
    'data' => $data,
    'value' => $model->cats, // initial value
    'maintainOrder' => true,
    'toggleAllSettings' => [
        'selectLabel' => '<i class="fa fa-ok-circle"></i> Tag All',
        'unselectLabel' => '<i class="fa fa-remove-circle"></i> Untag All',
        'selectOptions' => ['class' => 'text-success'],
        'unselectOptions' => ['class' => 'text-danger'],
    ],
    'options' => ['placeholder' => 'Select relaed categories ...', 'multiple' => true],
    'pluginOptions' => [
        'tags' => true,
        'maximumInputLength' => 10
    ],
]);
?>


<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'status')->checkbox() ?>

