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
$languages = $model->languages;
if (isset($languages)) {
    $items = [];
    foreach ($languages as $lang) {
        $items[] = [
            'label' => Yii::t('app', $lang),
            'content' => $this->render('_lang', [
                'model' => $model,
                'form' => $form,
                'lang' => $lang,
            ]),
        ];
    }

    echo \yii\bootstrap\Tabs::widget([
        'items' => $items
    ]);
}

?>
<?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'url_prefix')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'parent_id')->dropDownList($model->getParentCategoryList($model->id), ['prompt' => Yii::t('backend', 'Select Parent')]) ?>

<?= $form->field($model, 'sort_order')->textInput() ?>

<?= $form->field($model, 'top')->checkbox() ?>

<?= $form->field($model, 'status')->checkbox() ?>
