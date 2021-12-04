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

?>


<?php
echo $this->render('_content', [
    'model' => $model,
    'form' => $form,
])
?>

<?= $form->field($model, 'category_id')->dropDownList($model->getCategoryList(), ['prompt' => '--Select CATEGORY--',
    'options' => $model->getCategoryCodeDataList()]) ?>


<?php
$parentLocations = \common\models\wrappers\LocationWrapper::find()->multilingual()->hasNoParent()->all();
$parentLocationsOption = \yii\helpers\ArrayHelper::map($parentLocations, 'id', 'title');
?>

<?= $form->field($model, 'parent_id')->dropDownList($parentLocationsOption, ['prompt' => Yii::t('app', 'Choose one parent if location is hall')]) ?>
<?= $form->field($model, 'merchant_id')->dropDownList($model->getMerchantOptions(), ['prompt' => Yii::t('app', 'Choose one related merchant')]) ?>

<?= $form->field($model, 'status')->checkbox() ?>
