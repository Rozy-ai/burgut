<?php

use yii\helpers\Html;

?>
<div class="category-field-wrapper-index">

    <h1><?= Yii::t('app', 'Fields') ?></h1>

    <?php
    if (isset($model) && isset($model->id)) {
        echo Html::a('<i class="fa fa-chair"> </i> Add Field',
            \yii\helpers\Url::to(['/category-field/dialog', 'category_id' => $model->id]),
            [
                'title' => '',
                'class' => 'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#modalfield',
            ]
        );

        $searchModel = new \common\models\search\CategoryFieldSearch();
        $searchModel->category_id = $model->id;

        echo $this->render('/category-field/_field_grid', [
            'searchModel' => $searchModel,
        ]);

    } else {
        echo Yii::t('app', 'You should first category to add fields');
    } ?>


</div>
