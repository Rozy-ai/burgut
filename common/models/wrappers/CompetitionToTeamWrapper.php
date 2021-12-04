<?php
/**
 * Created by PhpStorm.
 * User: batyr
 * Date: 9/27/2019
 * Time: 6:01 PM
 */

namespace common\models\wrappers;


use common\components\DynamicFieldsBehavior;
use common\models\CompetitionToTeam;
use common\models\EventToTeam;
use yii\helpers\ArrayHelper;
use Yii;

class CompetitionToTeamWrapper extends CompetitionToTeam {
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


    public function getCompetition() {
        return $this->hasOne(CompetitionWrapper::className(), ['id' => 'competition_id']);
    }

    public function getTeam() {
        return $this->hasOne(TeamWrapper::className(), ['id' => 'team_id']);
    }

    public function getGroup() {
        return $this->hasOne(CompetitionGroupWrapper::className(), ['id' => 'group_id']);
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


    public function getRelatedGroupList() {
        $competitionGroups = CompetitionGroupWrapper::find()->where(['competition_id' => $this->competition_id])->all();
        return ArrayHelper::map($competitionGroups, 'id', 'name');
    }
}