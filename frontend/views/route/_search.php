<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\RouteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="route-wrapper-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <!--    --><?php //$form = \yii\bootstrap\ActiveForm::begin([
    //        'enableClientValidation' => false,
    //        'action' => ['index'],
    ////                    'layout' => 'horizontal',
    //        'fieldConfig' => [
    //            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
    //            'horizontalCssClasses' => [
    //                'label' => 'col-sm-3 col-md-3',
    //                'offset' => 'col-sm-offset-3 ',
    //                'wrapper' => 'col-sm-9',
    //                'error' => '',
    //                'hint' => '',
    //            ],
    //        ],
    //    ]);
    ?>
    <div class="row ">
        <div class="col-md-2">
            <?= $form->field($model, 'route_no')->textInput(['placeholder'=>$model->getAttributeLabel('route_no')])->label(false) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'from_point_id')->dropDownList($model->getPointList(), ['prompt' => Yii::t('app', 'From point'), 'placeholder' => 'test'])->label(false) ?>

            <!--            --><? //= $form->field($model, 'firstname', ['horizontalCssClasses' => ['label' => 'col-sm-6 col-md-6', 'wrapper' => 'col-md-6', 'error' => 'test',]])->textInput()->label() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'to_point_id')->dropDownList($model->getPointList(), ['prompt' => Yii::t('app', 'To point')])->label(false) ?>
            <!--            --><? //= $form->field($model, 'lastname', ['horizontalCssClasses' => ['offset' => '', 'wrapper' => 'col-md-6']])->textInput(['maxlength' => true])->label(false) ?>
        </div>
        <div class="col-md-2">
            <?= Html::submitButton('<i class="fa fa-search"></i> ' . Yii::t('app', 'Search'), ['class' => 'btn btn-success btn-lg']) ?>
        </div>
    </div>

    <!--    --><? //= $form->field($model, 'from_point_id')->dropDownList($model->getPointList(),['prompt'=>Yii::t('app','Choose direction')]) ?>
    <!---->
    <!--    --><? //= $form->field($model, 'to_point_id')->dropDownList($model->getPointList(),['prompt'=>Yii::t('app','Choose direction')]) ?>

    <!--    --><? //= $form->field($model, 'length') ?>

    <?php // echo $form->field($model, 'cycle_min') ?>

    <?php // echo $form->field($model, 'planned_period_min') ?>

    <div class="form-group">
        <!--        --><? //= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <!--        --><? //= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>
    <!--    --><?php //\yii\bootstrap\ActiveForm::end(); ?>

    <?php ActiveForm::end(); ?>

    <?php
    //    $sorted_by = isset($_GET['sort']) ? $_GET['sort'] : '';
    //    echo "<ul>";
    //    echo '<li>' . Html::a(Yii::t('app', 'shortest length'), \yii\helpers\Url::to(['index', 'sort' => 'length']), ['class' => $sorted_by == 'length' ? "selected" : ""]) . '</li>';
    //    echo '<li>' . Html::a(Yii::t('app', 'shortest cycle_min'), \yii\helpers\Url::to(['index', 'sort' => 'cycle_min']), ['class' => $sorted_by == 'cycle_min' ? "selected" : ""]) . '</li>';
    ?>
</div>
