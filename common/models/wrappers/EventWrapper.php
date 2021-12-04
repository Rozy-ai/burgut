<?php

namespace common\models\wrappers;

use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
use common\models\Event;
use common\models\EventToTeam;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;


class EventWrapper extends Event
{
    private $_url;
    private $_name;
    private $_teams;
    private $_eventTeams;
    private $_eventParticipants;
    private $_eventSides;
    public $sources;
    public $homeTeam;
    public $awayTeam;
    public $score;


    public function rules()
    {
        return \yii\helpers\ArrayHelper::merge(parent::rules(), [
            [['sources'], 'safe'],
        ]);
    }

    public function getUrl($absolute = false)
    {
        if ($this->_url === null)
            $this->_url = Url::to(['event/view', 'id' => $this->id]);

        if ($absolute == true)
            $this->_url = Url::toRoute($this->_url);
        return $this->_url;
    }

    public function getName()
    {
        if ($this->_name === null) {
            $group = $this->competitionGroup;
            if (isset($group))
                $this->_name = $group->name;

            $phase = $this->competitionPhase;
            if (isset($phase))
                $this->_name = $this->_name . ' - ' . $phase->name;

            $this->_name = trim(trim($this->_name), '-');

        }

        return $this->_name;
    }

    public function attributeLabels()
    {
        return \yii\helpers\ArrayHelper::merge(parent::attributeLabels(), [
            'title' => Yii::t('app', 'Event Title'),
            'event_start_day' => Yii::t('app', 'Event day'),
            'event_start_hour' => Yii::t('app', 'Event hour'),
            'homeTeam' => Yii::t('app', 'Home Team'),
            'awayTeam' => Yii::t('app', 'Away Team'),
            'score' => Yii::t('app', 'Score'),
        ]);
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $competition = $this->competition;
            if (isset($competition) && isset($competition->category_id)) {
                $this->category_id = $competition->category_id;
            }

            $this->season_id = $this->competition->season_id;
            $this->type = $this->competitionPhase->type;

            return true;
        } else {
            return false;
        }
    }


    public function getCompetition()
    {
        return $this->hasOne(CompetitionWrapper::className(), ['id' => 'competition_id']);
    }

    public function getCompetitionPhase()
    {
        return $this->hasOne(CompetitionPhaseWrapper::className(), ['id' => 'competition_phase_id']);
    }

    public function getCompetitionGroup()
    {
        return $this->hasOne(CompetitionGroupWrapper::className(), ['id' => 'competition_group_id']);
    }


    public function getSourceEvents()
    {
        return $this->hasMany(EventWrapper::className(), ['parent_id' => 'id']);
    }


    public function getEventTeams()
    {
        if ($this->_eventTeams === null) {
            $this->_eventTeams = EventToTeamWrapper::find()->where(['event_id' => $this->id])->all();
        }

        return $this->_eventTeams;
    }

    public function getEventParticipants()
    {
        if ($this->_eventParticipants === null) {
            $this->_eventParticipants = EventToParticipantWrapper::find()->where(['event_id' => $this->id])->all();
        }

        return $this->_eventParticipants;
    }


    public function getEventSides()
    {

        if ($this->competition->is_team) {
            if ($this->_eventSides == null)
                $this->_eventSides = $this->getEventTeams();
        } else {
            if ($this->_eventSides == null)
                $this->_eventSides = EventToParticipantWrapper::find()->where(['event_id' => $this->id])->all();
        }

        return $this->_eventSides;
    }


    public function getSideCanditate($side_index = 0)
    {
        $sides = $this->getEventSides();
        if (count($sides) > 1) {
            if ($this->competition->is_team) {
                $teamContent = $sides[$side_index]->team->loadContent();
                return isset($teamContent) ? $teamContent->title : "";
            } else {
                return $sides[$side_index]->participant->getFullName();
            }
        }
    }


    public function getTeams()
    {
        if ($this->_teams === null) {
            $this->_eventTeams = $this->getEventTeams();
            $this->_teams = [];
            foreach ($this->_eventTeams as $eventTeam) {
                $this->_teams[] = $eventTeam->team;
            }
        }

        return $this->_teams;
    }

    public function getSourceEventList()
    {
        $query = \common\models\wrappers\EventWrapper::find()
            ->where(['competition_id' => $this->competition_id])
            ->andWhere(['season_id' => $this->season_id])
            ->andWhere(['OR', 'competition_group_id is null', 'competition_group_id=0']);

        if (isset($this->id))
            $query->andWhere(['<>', 'id', $this->id]);
        $eventdata = $query->all();

        return \yii\helpers\ArrayHelper::map($eventdata, 'id', 'name');
    }

}
