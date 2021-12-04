<?php
/**
 * Created by PhpStorm.
 * User: batyr
 * Date: 9/27/2019
 * Time: 6:01 PM
 */

namespace common\models\wrappers;


use common\components\DynamicFieldsBehavior;
use common\models\Competition;
use common\models\CompetitionToParticipant;
use common\models\CompetitionToTeam;
use yii\helpers\ArrayHelper;
use Yii;

class CompetitionToParticipantWrapper extends CompetitionToParticipant {

    public function behaviors() {
        return [
            'dynamicFields' => [
                'class' => DynamicFieldsBehavior::class,
                'fields' => $this->getDynamicFieldNames(),
            ],
        ];
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


    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if (!$this->category_id) {
                $this->category_id = $this->competition->category_id;
            }
            return true;
        } else {
            return false;
        }
    }


    public function getRelatedTeamList() {
        $competitionTeams = CompetitionToTeamWrapper::find()->distinct('team_id')->where(['competition_id' => $this->competition_id])->all();
        return ArrayHelper::map($competitionTeams, 'team_id', function ($competitionTeam) {
            return $competitionTeam->team->name;
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


    public function getCompetition() {
        return $this->hasOne(CompetitionWrapper::className(), ['id' => 'competition_id']);
    }

    public function getTeam() {
        return $this->hasOne(TeamWrapper::className(), ['id' => 'team_id']);
    }

    public function getGroup() {
        return $this->hasOne(CompetitionGroupWrapper::className(), ['id' => 'group_id']);
    }

    public function getParticipant() {
        return $this->hasOne(ParticipantWrapper::className(), ['id' => 'participant_id']);
    }

    public function getRelatedGroupList() {
        $competitionGroups = CompetitionGroupWrapper::find()->where(['competition_id' => $this->competition_id])->all();
        return ArrayHelper::map($competitionGroups, 'id', 'name');
    }
}