<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\wrappers\ItemWrapper */

//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Competitions'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = Yii::$app->controller->truncate($model->name, 8, 65);


$href = $model->url;
$eventTeams = $model->getEventTeams();
$homeTeam = $eventTeams[0]->team;
$homeTeamContentModel = $homeTeam->loadContent();
$awayTeam = $eventTeams[1]->team;
$awayTeamContentModel = $awayTeam->loadContent();

$fullName = $homeTeam->name . ' - ' . $awayTeam->name . ' ' . Yii::$app->controller->renderDate($model->start_time, true);
$this->title = $fullName;

//$path = $model->getThumbPath(600, 400, 'w', true);
?>
<!-- product-details-area are start-->

<?php if (count($eventTeams) > 1) { ?>
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
                    <?php if (isset($homeTeam)) { ?>
                        <div class="col-md-5">
                            <div class="entry-image">
                                <?php
                                $imgsrc = $homeTeamContentModel->getThumbPath(260, 150, 'auto');
                                echo Html::a(Html::img($imgsrc, ['alt' => '', 'class' => 'entry-featured-image-url']), $homeTeam->url);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <a class="event_team_name" href="<?= $homeTeam->url ?>"><?= $homeTeam->name ?></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="event_info">
                    <div class="event_score">
                        <?php
                        if (isset($eventTeams) && isset($eventTeams[0]) && isset($eventTeams[1])) {
                            echo $eventTeams[0]->score_for . ' : ' . $eventTeams[1]->score_for;
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
                <?php if (isset($awayTeam)) { ?>
                    <div class="col-md-7">
                        <a class="event_team_name" href="<?= $awayTeam->url ?>"><?= $awayTeam->name ?></a>
                    </div>
                    <div class="col-md-5">
                        <div class="entry-image">
                            <?php
                            $imgsrc = $awayTeamContentModel->getThumbPath(260, 150, 'auto');
                            echo Html::a(Html::img($imgsrc, ['alt' => '', 'class' => 'entry-featured-image-url']), $awayTeam->url);
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>


        <div class="row">
            <?php
            foreach ($eventTeams as $eventTeam) {
                if (count($eventTeams) > 0) {
                    echo $this->render('_team_participant_grid', [
                        'eventTeam' => $eventTeam
                    ]);
                }
            }
            ?>
        </div>
        <div class="row">
            <div class="col-md-12">
            </div>
        </div>


    </div>
<?php } ?>
