<?php
/**
 * Created by PhpStorm.
 * User: Fujitsu
 * Date: 1.4.2017
 * Time: 9:00 AM
 */

namespace common\widgets\bracketjs;

use common\models\wrappers\CompetitionPhaseWrapper;
use common\models\wrappers\EventToParticipantWrapper;
use common\models\wrappers\EventToTeamWrapper;
use common\models\wrappers\EventWrapper;
use common\models\wrappers\ItemWrapper;
use common\widgets\items\listview\ListWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class Bracket extends \yii\base\Widget {
    public $competition;
    public $type;
    public $teams = [];
    public $results = [];

    public function init() {
        $view = $this->getView();
        BracketAsset::register($view);
        parent::init();
    }


    public function run() {
        if (isset($this->competition) && $this->type) {
            $events = EventWrapper::find()
                ->joinWith('competitionPhase cp')
                ->where([
                    EventWrapper::tableName() . '.competition_id' => $this->competition->id,
//                    EventWrapper::tableName() . '.season_id' => $this->competition->season_id
                ])
                ->andWhere(['cp.type' => CompetitionPhaseWrapper::TYPE_PLAYOFF])
//                ->andWhere(['not', ['parent_id' => null]])
                ->orderBy('cp.sort_order desc')
                ->all();

            if (isset($events[0])) {
                $this->generateTree($events[0]);
            }

            return $this->render($this->type);
        }
    }


    public function generateTree($event, $level = 1) {
        if (isset($event)) {
            $event_stats = [];
            if ($this->competition->is_team) {
                $eventToTeams = EventToTeamWrapper::find()->where(['event_id' => $event->id])->all();
                foreach ($eventToTeams as $eventToTeam) {
                    $event_stats[$eventToTeam->team->name] = $eventToTeam->score_for;
                }
            } else {
                $eventToParticipants = EventToParticipantWrapper::find()
                    ->where([
                        'event_id' => $event->id,
                        'type' => EventToParticipantWrapper::PARTICIPANT_TYPE_ATHLETE
                    ])
                    ->all();

                foreach ($eventToParticipants as $eventToParticipant) {
                    $event_stats[$eventToParticipant->participant->getFullName()] = $eventToParticipant->score_for;
                }
            }


            $sourceEvents = EventWrapper::find()->where(['parent_id' => $event->id])->all();
//            $sourceEvents = $event->sourceEvents;
            $winner_teams = [];
            foreach ($sourceEvents as $sourceEvent) {
                $winner_teams[] = $this->generateTree($sourceEvent, $level + 1);
            }

//            echo "<pre>";
//            print_r($winner_teams);
//            echo "</pre>";

            if (isset($event_stats)) {
                if (count($sourceEvents) == 0) {
                    $this->teams[] = array_keys($event_stats);
                }

                if (isset($winner_teams) && count($winner_teams) > 1) {
                    if ($winner_teams[0] != array_keys($event_stats)[0])
                        $event_stats = array_reverse($event_stats);
                }
                $this->results[$level][] = array_values($event_stats);
            }


//            echo "<pre>";
//            print_r($event->attributes);
//            print_r($event_stats);
//            print_r(Json::encode($this->teams));
//            print_r(Json::encode(array_values($this->results)));
//            echo "</pre>";

            $team_index = array_keys($event_stats);
            return $event_stats[$team_index[0]] > $event_stats[$team_index[1]] ? $team_index[0] : $team_index[1];
        }

    }
}