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
