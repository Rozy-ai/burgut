<?php
/**
 * Created by PhpStorm.
 * User: batyr
 * Date: 9/27/2019
 * Time: 6:02 PM
 */

namespace common\models\wrappers;


use common\components\DynamicFieldsBehavior;
use common\models\Season;
use yii\helpers\ArrayHelper;

class SeasonWrapper extends Season {
    public function getSportTypeList() {
        $list = CategoryWrapper::find()
            ->joinWith('parent p')
            ->where(['p.code' => 'sport-types'])
            ->all();

        return ArrayHelper::map($list, 'id', 'name');

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
        if (isset($this->competition) && isset($this->competition->category_id)) {
            $categoryFields = CategoryFieldWrapper::find()->where(['category_id' => $this->competition->category_id, 'target_model' => (new \ReflectionClass($this))->getShortName()])->all();
        } elseif (!$onlyRelated)
            $categoryFields = CategoryFieldWrapper::find()->where(['target_model' => (new \ReflectionClass($this))->getShortName()])->all();

        return $categoryFields;
    }


    public function getCompetition() {
        return $this->hasOne(CompetitionWrapper::className(), ['id' => 'competition_id']);
    }

}