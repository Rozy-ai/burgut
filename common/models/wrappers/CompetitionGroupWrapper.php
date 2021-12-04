<?php
/**
 * Created by PhpStorm.
 * User: batyr
 * Date: 9/27/2019
 * Time: 6:00 PM
 */

namespace common\models\wrappers;



use common\models\CompetitionGroup;

class CompetitionGroupWrapper extends CompetitionGroup {


    public function getCompetition() {
        return $this->hasOne(CompetitionWrapper::className(), ['id' => 'competition_id']);
    }
}