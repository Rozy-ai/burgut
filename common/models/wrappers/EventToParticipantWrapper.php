<?php
/**
 * Created by PhpStorm.
 * User: batyr
 * Date: 9/27/2019
 * Time: 6:01 PM
 */

namespace common\models\wrappers;


use common\components\DynamicFieldsBehavior;
use common\models\EventToParticipant;
use common\models\EventToTeam;
use yii\helpers\ArrayHelper;
use Yii;

class EventToParticipantWrapper extends EventToParticipant {
    const RESULT_STATE_WIN = 1, RESULT_STATE_LOSS = 2, RESULT_STATE_DRAW = 3;
    public $event_count, $sum_point, $sum_score_for, $sum_score_against, $total_win, $total_loss, $total_draw;


    public function getResultStateText() {
        $options = $this->getResultStateOptions();
        return isset($options[$this->result_state]) ? $options[$this->result_state] : '';
    }

    public static function getResultStateOptions() {
        return array (
            self::RESULT_STATE_WIN => Yii::t('app', 'RESULT_STATE_WIN'),
            self::RESULT_STATE_LOSS => Yii::t('app', 'RESULT_STATE_LOSS'),
            self::RESULT_STATE_DRAW => Yii::t('app', 'RESULT_STATE_DRAW'),
        );
    }


    public function behaviors() {
        return [
            'dynamicFields' => [
                'class' => DynamicFieldsBehavior::class,
                'fields' => $this->getDynamicFieldNames(),
            ],
        ];
    }


    public function attributeLabels()
    {
        return \yii\helpers\ArrayHelper::merge(parent::attributeLabels(), [
            'participant_id' => Yii::t('app', 'Player'),
            'score_for' => Yii::t('app', 'Score'),
            'played_minute' => Yii::t('app', 'PM'),
            'participant' => Yii::t('app', 'Participant'),
            'event_count' => Yii::t('app', 'Event count'),
            'total_win' => Yii::t('app', 'Total win'),
            'total_draw' => Yii::t('app', 'Total draw'),
            'total_loss' => Yii::t('app', 'Total loss'),
            'sum_score_for' => Yii::t('app', 'Sum score for'),
            'sum_score_against' => Yii::t('app', 'Sum score against'),
            'sum_point' => Yii::t('app', 'Sum point'),
        ]);
    }


    public function getDynamicFieldNames($onlyRelated = false) {
        $categoryFields = $this->getDynamicFields($onlyRelated);
        return array_keys(ArrayHelper::map($categoryFields, 'field_name', 'field_name'));
    }

    public function getDynamicFields($onlyRelated = false) {
        $categoryFields = [];
        if (isset($this->category_id)) {
            $categoryFields = CategoryFieldWrapper::find()->where(['category_id' => $this->category_id, 'target_model' => (new \ReflectionClass($this))->getShortName()])->all();
        } elseif (!$onlyRelated)
            $categoryFields = CategoryFieldWrapper::find()->where(['target_model' => (new \ReflectionClass($this))->getShortName()])->all();

        return $categoryFields;
    }

    public function beforeValidate() {
        if (!$this->competition_id) {
            $this->competition_id = $this->event->competition_id;
        }

        return parent::beforeValidate();
    }


    public function getRelatedTeamList() {
        $eventTeams = EventToTeamWrapper::find()->distinct('team_id')->where(['event_id' => $this->event_id])->all();
        return ArrayHelper::map($eventTeams, 'team_id', function ($eventTeam) {
            return $eventTeam->team->name;
        });
    }


    const PARTICIPANT_TYPE_ATHLETE = 1, PARTICIPANT_TYPE_COACH = 2, PARTICIPANT_TYPE_JUDGE = 3;

    public function getTypeText() {
        $typeOptions = $this->getTypeOptions();
        return isset($typeOptions[$this->type]) ? $typeOptions[$this->type] : '';
    }

    public static function getTypeOptions() {
        return array (
            self::PARTICIPANT_TYPE_ATHLETE => Yii::t('app', 'PARTICIPANT_TYPE_ATHLETE'),
            self::PARTICIPANT_TYPE_COACH => Yii::t('app', 'PARTICIPANT_TYPE_COACH'),
            self::PARTICIPANT_TYPE_JUDGE => Yii::t('app', 'PARTICIPANT_TYPE_JUDGE'),
        );
    }


    public function getEvent() {
        return $this->hasOne(EventWrapper::className(), ['id' => 'event_id']);
    }

    public function getCompetition() {
        return $this->hasOne(CompetitionWrapper::className(), ['id' => 'competition_id']);
    }

    public function getTeam() {
        return $this->hasOne(TeamWrapper::className(), ['id' => 'team_id']);
    }

    public function getParticipant() {
        return $this->hasOne(ParticipantWrapper::className(), ['id' => 'participant_id']);
    }


    public function getCandidateName() {
        $participant = $this->participant;
        if (isset($participant))
            return $participant->getFullName();
    }
}