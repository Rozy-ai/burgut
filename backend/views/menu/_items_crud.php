<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Menu Wrappers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-wrapper-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?=Html::a(Yii::t('app', 'Add menu item'),['menu-item/create'],['class' => 'btn btn-success','title'=>'Add Menu Item','data-toggle'=>"modal",'data-target'=>"#modalmenuitem"]);  ?>
    </p>
    <?php \yii\widgets\Pjax::begin(['id' => 'pjax-menu-item-list', 'enablePushState' => false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'options'=>['width'=>'180'],
                'attribute'=>'_image',
                'value' => function ($model) {
                    $path = $model->getThumbPath(150, 150);
                    return \yii\helpers\Html::img($path, ['alt' => '', 'class' => 'img-responsive bordered']);
                },
                'format' => 'raw',
            ],
            'name',
            [
                'attribute'=>'description',
                'value' => function ($model) {
                    if(isset($model['description']) && strlen(trim($model['description']))>0)
                        return mb_substr($model['description'],0,150)."...";
                },
                'format' => 'html',
                'options' => ['width' => '80']
            ],
//            'description:ntext',
            'price',
            'currency_id',
            // 'date_created',
            // 'date_modified',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>


<div class="modal remote fade" id="modalmenuitem">
    <div class="modal-dialog">
        <div class="modal-content loader-lg"></div>
    </div>
</div>



<?php
$script = <<< JS
        $("body").on("beforeSubmit", "form#dynamic-form", function () {
               // debugger;
                var form = $(this);
        
                // return false if form still have some validation errors
                if (form.find(".has-error").length) {
                        return false;
                }
        
                // submit form
                $.ajax({
                        url    : form.attr("action"),
                        type   : "post",
                        data   : form.serialize(),
                        success: function (response) {
                               $("#modalmenuitem").modal("toggle");
                               $.pjax.reload({container:"#pjax-menu-item-list"}); //for pjax update
                        },
                        error  : function () {
                                //console.log("internal server error");
                        }
                });
                return false;
         });
    
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
?>
