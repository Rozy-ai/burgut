<?php
/**
 * Created by PhpStorm.
 * User: batyr
 * Date: 9/27/2019
 * Time: 6:03 PM
 */

namespace common\models\wrappers;


use common\components\DynamicFieldsBehavior;
use common\models\TeamToParticipant;
use Yii;
use yii\helpers\ArrayHelper;

class TeamToParticipantWrapper extends TeamToParticipant {
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


    const STATUS_ARCHIVE = 0, STATUS_ACTIVE = 1;

    public function getStatusText() {
        $statusOptions = $this->getStatusOptions();
        return isset($statusOptions[$this->status]) ? $statusOptions[$this->status] : '';
    }

    public static function getStatusOptions() {
        return array (
            self::STATUS_ACTIVE => Yii::t('app', 'STATUS_ACTIVE'),
            self::STATUS_ARCHIVE => Yii::t('app', 'STATUS_ARCHIVE')
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


    public function getDynamicFieldNames($onlyRelated = false) {
        $categoryFields = $this->getDynamicFields($onlyRelated);
        return array_keys(ArrayHelper::map($categoryFields, 'field_name', 'field_name'));
    }

    public function getDynamicFields($onlyRelated = false) {
        $categoryFields = [];
        if (isset($this->team) && isset($this->team->category_id)) {
            $categoryFields = CategoryFieldWrapper::find()->where(['category_id' => $this->team->category_id, 'target_model' => (new \ReflectionClass($this))->getShortName()])->all();
        } elseif (!$onlyRelated)
            $categoryFields = CategoryFieldWrapper::find()->where(['target_model' => (new \ReflectionClass($this))->getShortName()])->all();

        return $categoryFields;
    }


    public function getTeam() {
        return $this->hasOne(TeamWrapper::className(), ['id' => 'team_id']);
    }

    public function getParticipant() {
        return $this->hasOne(ParticipantWrapper::className(), ['id' => 'participant_id']);
    }
}