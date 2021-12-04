<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\MenuWrapper */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$languages = $model->languages;
if (isset($languages)) {
    $items = [];
    foreach ($languages as $key => $lang) {
        $items[] = [
            'label' => Yii::t('app', $lang),
            'options' => ['id' => 'tab_' . $key],
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
