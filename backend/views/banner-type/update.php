<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\BannerTypeWrapper */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Banner Type Wrapper',
    ]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banner Type Wrappers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="banner-type-wrapper-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


    <?php if (isset($model) && isset($model->id)) { ?>
        <div class="row">
            <div class=" col-md-12">
                <div class="tab-content"
                     style="margin-top: 95px; border-top: 1px solid #ddd; background: #FDFDFD; margin-bottom: 50px;">
                    <div class="relations last ">
                        <h2><?php echo Yii::t('app', 'Banners'); ?></h2>
                        <?php
                        if ($model->type == \common\models\wrappers\BannerTypeWrapper::TYPE_ADSENSE) {
                            $columns[0] = array(
                                'name' => 'format_type',
                                'type' => 'raw',
                                'value' => '$data->getFormatTypeText()',
                            );
                            $columns[2] = array(
                                'name' => 'adsense_code',
                                'type' => 'raw',
                                'value' => 'CHtml::encode($data->adsense_code)',
                            );

                        }
                        Pjax::begin(['id' => 'pjax-banner-list', 'enablePushState' => false]); ?>
                        <?= GridView::widget([
                            'dataProvider' => $bannerGridModel->search(Yii::$app->request->queryParams),
                            'filterModel' => $bannerGridModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'options' => ['width' => '180'],
                                    'attribute' => '_image',
                                    'value' => function ($model) {
                                        $path = $model->getThumbPath(150, 150);
                                        return \yii\helpers\Html::img($path, ['alt' => '', 'class' => 'img-responsive bordered']);
                                    },
                                    'format' => 'raw',
                                ],
                                'description',
                                'url:url',
                                [
                                    'attribute' => 'format_type',
                                    'value' => function ($data) {
                                        return $data->getFormatTypeText();
                                    },
                                    'format' => 'html',
                                    'options' => ['width' => '80px']
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{update} {leadDelete}',
                                    'buttons' => [
                                        'update' => function ($url, $model) {
                                            $url = \yii\helpers\Url::to(['banner-type/update', 'id' => $model->type, 'banner_id' => $model->id]);
                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => 'update']);
                                        },
                                        'leadDelete' => function ($url, $model) {
                                            $url = \yii\helpers\Url::to(['banner/delete', 'id' => $model->id]);
                                            return Html::a('<span class="fa fa-trash"></span>', $url, [
                                                'title' => 'delete',
                                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                'data-method' => 'post',
                                            ]);
                                        },
                                    ],
                                ],
                            ]
                        ]); ?>

                        <?php Pjax::end(); ?>
                    </div>


                    <div class="addChild">
                        <h2 style="padding-top: 50px; border-top: 1px solid #ddd; margin-top: 50px;">
                            <?php echo Yii::t('backend', 'Add Banner'); ?>
                        </h2>

                        <?php if ($bannerModel !== null) { ?>

                            <?php
                            if ($model->type == \common\models\wrappers\BannerTypeWrapper::TYPE_ADSENSE) {
                                $this->renderPartial('/banner/_form_adsense', array(
                                    'model' => $bannerModel,
                                ));
                            } else {
                                echo $this->render('/banner/_form', array(
                                    'model' => $bannerModel,
                                ));
                            }
                            ?>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>

    <?php } ?>
</div>


<?php
$pjaxUrl = \yii\helpers\Url::to(['banner-type/update', 'id' => $model->id]);
$script = <<< JS
$('#banner-form').on('beforeSubmit', function(e) {
    debugger;
    var form = $(this);
    var formData = form.serialize();
    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: formData,
        success: function (data) {
            $.pjax.reload({container:"#pjax-banner-list",url:"$pjaxUrl"}); //for pjax update
        },
        error: function () {
            alert("Something went wrong");
        }
    });
}).on('submit', function(e){
    e.preventDefault();
});
JS;

$this->registerJs($script, yii\web\View::POS_READY);

?>

