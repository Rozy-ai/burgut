<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ItemWrapper */

//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Competitions'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = Yii::$app->controller->truncate($model->name, 8, 65);


$href = $model->url;
$eventParticipants = $model->getEventParticipants();
$homeParticipant = $eventParticipants[0]->participant;
$awayParticipant = $eventParticipants[1]->participant;

$fullName = $homeParticipant->getFullName() . ' - ' . $awayParticipant->getFullName() . ' ' . Yii::$app->controller->renderDate($model->start_time, true);
$this->title = $fullName;

//$path = $model->getThumbPath(600, 400, 'w', true);
?>
<!-- product-details-area are start-->

<?php if (count($eventParticipants) > 1) { ?>
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="layer">
                    <div class="header">
                        <h3 class="headerColor">
                            <?php
                            echo Html::encode($fullName);
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <?php if (isset($homeParticipant)) { ?>
                        <div class="col-md-5">
                            <div class="entry-image">
                                <?php
                                $imgsrc = $homeParticipant->getThumbPath(260, 150, 'auto');
                                echo Html::img($imgsrc, ['alt' => '', 'class' => 'entry-featured-image-url']);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="event_participant_name"><?= $homeParticipant->getFullName() ?></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="event_info">
                    <div class="event_score">
                        <?php
                        if (isset($eventParticipants) && isset($eventParticipants[0]) && isset($eventParticipants[1])) {
                            echo $eventParticipants[0]->score_for . ' : ' . $eventParticipants[1]->score_for;
                        }
                        ?>
                    </div>


                    <div class="event_competition">
                        <?php
                        $competition = $model->competition;
                        if (isset($competition)) {
                            $contentModel = $competition->loadContent();
                            if (isset($contentModel)) {
                                $link_name = $contentModel->title . " " . $model->getName();
                                echo Html::a($link_name, $competition->getUrl());
                            }
                        }
                        ?>
                    </div>

                    <div class="event_date">
                        <?= Yii::$app->controller->renderDate($model->start_time, true); ?>
                    </div>

                    <div class="event_location">
                        <?= $model->location; ?>
                    </div>

                    <?php
                    $judges = \common\models\wrappers\EventToParticipantWrapper::find()->where(['type' => \common\models\wrappers\EventToParticipantWrapper::PARTICIPANT_TYPE_JUDGE, 'event_id' => $model->id])->all();
                    if (isset($judges) && count($judges) > 0) { ?>
                        <label><?= Yii::t('app', 'Judges') ?></label>
                        <div class="event_judges">
                            <?php
                            foreach ($judges as $judge) {
                                echo $judge->participant->getFullName();
                            }
                            ?>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <div class="col-md-4">
                <?php if (isset($awayParticipant)) { ?>
                    <div class="col-md-7">
                        <div class="event_participant_name"><?= $awayParticipant->getFullName() ?></div>
                    </div>
                    <div class="col-md-5">
                        <div class="entry-image">
                            <?php
                            $imgsrc = $awayParticipant->getThumbPath(260, 150, 'auto');
                            echo Html::img($imgsrc, ['alt' => '', 'class' => 'entry-featured-image-url']);
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
