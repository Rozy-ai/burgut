<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\AlbumWrapper */
/* @var $form yii\widgets\ActiveForm */
?>



    <?php
        $items=[
            [
                'label' => 'Menu Info',
                'content' => $this->render('_general', [
                    'model' => $model,
                    'form' => $form,
                ]),
                'active' => true
            ]
        ];

        if(Yii::$app->controller->action->id=='update'){
            array_push($items, [
                'label' => 'Menu Item',
                'content' => $this->render('_items_crud', [
                    'searchModel' => $menuItemSearchModel,
                    'dataProvider' => $menuItemDataProvider,
                    'model' => $model,
                ]),
            ]);
        }

        echo \yii\bootstrap\Tabs::widget([
            'items' => $items
        ]);
    ?>

