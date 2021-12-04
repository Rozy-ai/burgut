<?php
/**
 * Created by PhpStorm.
 * User: batyr
 * Date: 9/27/2019
 * Time: 6:00 PM
 */

namespace common\models\wrappers;


use common\models\CompetitionPhase;
use Yii;

class CompetitionPhaseWrapper extends CompetitionPhase {
    public function getCompetition() {
        return $this->hasOne(CompetitionWrapper::className(), ['id' => 'competition_id']);
    }


    const TYPE_LEAGUE = 1, TYPE_PLAYOFF = 2;
    public function getTypeText()
    {
        $typeOptions = $this->getTypeOptions();
        return isset($typeOptions[$this->type]) ? $typeOptions[$this->type] : '';
    }

    public static function getTypeOptions()
    {
        return array(
            self::TYPE_LEAGUE => Yii::t('backend', 'TYPE_LEAGUE'),
            self::TYPE_PLAYOFF => Yii::t('backend', 'TYPE_PLAYOFF'),
        );
    }

}