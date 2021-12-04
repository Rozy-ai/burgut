<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ItemWrapper */


$href = $model->url;
$contentModel = $model->loadContent();
$path = $contentModel->getThumbPath(260, 150, 'auto');
$this->title = $contentModel->title;


$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Competitions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::$app->controller->truncate($this->title, 8, 65);

?>
<!-- product-details-area are start-->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="layer">
                <div class="header">
                    <h3 class="headerColor">
                        <?php
                        echo Html::encode($contentModel->title);
                        ?>
                    </h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <?php if (isset($path) && strlen(trim($path)) > 0) { ?>
                <div class="ep-img">
                    <?php
                    echo \yii\helpers\Html::img($path, ['alt' => '', 'class' => '']);
                    ?>
                </div>
            <?php } ?>
        </div>
        <div class="col-md-8">
            <?php if (isset($contentModel) && isset($contentModel->description) && strlen(trim($contentModel->description)) > 0) { ?>
                <div class="row">
                    <div class="col-md-4">
                        <label><?php echo $contentModel->getAttributeLabel('description') ?></label>
                    </div>
                    <div class="col-md-8">
                        <?php echo $contentModel->description; ?>
                    </div>
                </div>
            <?php } ?>

            <?php
            $coaches = \common\models\wrappers\TeamToParticipantWrapper::find()->where(['type' => \common\models\wrappers\EventToParticipantWrapper::PARTICIPANT_TYPE_COACH, 'team_id' => $model->id])->all();
            if (isset($coaches) && count($coaches) > 0) { ?>
                <div class="row">
                    <div class="col-md-4">
                        <label><?= Yii::t('app', 'Coaches') ?></label>
                    </div>
                    <div class="col-md-8">
                        <?php
                        foreach ($coaches as $coach) {
                            echo $coach->participant->getFullName();
                        }
                        ?>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>

    <div class="layer">
        <div class="row">
            <div class="col-md-12">
                <?php
                echo \yii\bootstrap\Tabs::widget([
                    'items' => [
                        [
                            'label' => Yii::t('app', 'News'),
                            'content' => $this->render('_tab_news', [
                                'model' => $model,
                            ]),
                        ],
                        [
                            'label' => Yii::t('app', 'Calendar'),
                            'content' => $this->render('_tab_calendar', [
                                'model' => $model
                            ]),
                        ],
                        [
                            'label' => Yii::t('app', 'Result'),
                            'content' => $this->render('_tab_result_league_grid', [
                                'model' => $model
                            ]),
                        ],
                        [
                            'label' => Yii::t('app', 'Participants'),
                            'content' => $this->render('_team_participant_grid', [
                                'model' => $model
                            ]),
                        ],

                    ]
                ]);
                ?>

            </div>
        </div>
    </div>
</div>
