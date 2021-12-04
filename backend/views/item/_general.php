<?php

//$kcfOptions = [
////    'uploadURL' => Yii::getAlias('@web').'/upload',
//    'uploadURL' => Yii::getAlias('@uploads'),
//    'access' => [
//        'files' => [
//            'upload' => true,
//            'delete' => false,
//            'copy' => false,
//            'move' => false,
//            'rename' => false,
//        ],
//        'dirs' => [
//            'create' => true,
//            'delete' => false,
//            'rename' => false,
//        ],
//    ],
//];
//
//// Set kcfinder session options
//Yii::$app->session->set('KCFINDER', $kcfOptions);
//
//echo "<pre>";
//print_r(Yii::$app->session->get('KCFINDER'));
//echo "</pre>";
?>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


<?php
echo $this->render('_content', [
    'model' => $model,
    'form' => $form,
])
?>

<?= $form->field($model, 'category_id')->dropDownList($model->getCategoryList(), ['prompt' => '--Select CATEGORY--',
    'options' => $model->getCategoryCodeDataList(),
//    'onchange' => '
//                            $.get( "' . \yii\helpers\Url::toRoute('/category/subcats') . '", { category_id: $(this).val() } )
//                                .done(function( data ) {
//                                        debugger;
//                                        $( "#' . Html::getInputId($model, 'sub_category') . '" ).html( data );
//                                }
//                            );'
]) ?>


<?php
//echo $this->render('_dynamic_content', [
//    'model' => $model,
//    'form' => $form,
//])
?>

<?= $form->field($model, 'tagNames')->widget(\dosamigos\selectize\SelectizeTextInput::className(), [
    // calls an action that returns a JSON object with matched
    // tags
    'loadUrl' => ['tag/list'],
    'options' => ['class' => 'form-control'],
    'clientOptions' => [
        'plugins' => ['remove_button'],
        'valueField' => 'name',
        'labelField' => 'name',
        'searchField' => ['name'],
        'create' => true,
    ],
])->hint('Use commas to separate tags') ?>

<?= $form->field($model, 'status')->checkbox() ?>
<?= $form->field($model, 'is_main')->checkbox() ?>
<?= $form->field($model, 'is_menu')->checkbox() ?>

