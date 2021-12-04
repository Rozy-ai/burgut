<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ItemWrapper */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Federations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::$app->controller->truncate($model->title, 8, 65);


$href = $model->url;
$date = $model->renderDateToWord($model->date_created);
$path = $model->getThumbPath(600, 400, 'w', true);
?>
<!-- product-details-area are start-->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="layer">
                <div class="header">
                    <h3 class="headerColor">
                        <?php
                        echo Html::encode($model->title);
                        ?>
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <?php if (isset($path) && strlen(trim($path)) > 0) { ?>
                <div class="ep-img">
                    <?php
                    echo \yii\helpers\Html::img($path, ['alt' => '', 'class' => '']);
                    ?>
                </div>
            <?php } ?>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">
                    <label><?php echo $model->getAttributeLabel('description') ?></label>
                </div>
                <div class="col-md-8">
                    <?php echo $model->description; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label><?php echo $model->getAttributeLabel('phone') ?></label>
                </div>
                <div class="col-md-8">
                    <?php echo $model->phone; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label><?php echo $model->getAttributeLabel('fax') ?></label>
                </div>
                <div class="col-md-8">
                    <?php echo $model->fax; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label><?php echo $model->getAttributeLabel('address') ?></label>
                </div>
                <div class="col-md-8">
                    <?php echo $model->address; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label><?php echo $model->getAttributeLabel('email') ?></label>
                </div>
                <div class="col-md-8">
                    <?php echo $model->email; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="layer">
        <div class="row">
            <div class="col-md-12">
                <?php
                echo \yii\bootstrap\Tabs::widget([
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Federation content'),
                            'content' => $this->render('_tab_content', [
                                'model' => $model,
                            ]),
                            'active' => true
                        ],
                        [
                            'label' => Yii::t('app', 'News'),
                            'content' => $this->render('_tab_related_news', [
                                'federationModel' => $model,
                            ]),
                        ],
                        [
                            'label' => Yii::t('app', 'Contact'),
                            'content' => $this->render('_tab_contact', [
                                'federationModel' => $model,
                            ]),
                        ]
                    ]
                ]);
                ?>


                <div class="related-blogs">
                    <?php
                    //                echo \common\widgets\items\listview\ListWidget::widget([
                    //                    'category' => $categoryModel->code,
                    //                    'view' => 'related',
                    //                    'limit' => 3,
                    //                    'widget_title' => Yii::t('app', 'Related')
                    //                ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
