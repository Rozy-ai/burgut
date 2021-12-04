<?php
/**
 * Created by PhpStorm.
 * User: batyr
 * Date: 9/27/2019
 * Time: 6:03 PM
 */

namespace common\models\wrappers;


use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
use common\models\Participant;
use common\models\Team;
use yii\helpers\ArrayHelper;

class ParticipantWrapper extends Participant {
    public $docs = [];

    public function getFullName() {
        return trim($this->firstname . ' ' . $this->lastname . ' ' . $this->middlename);
    }


    public function getCompetitionToParticiapants() {
        return $this->hasMany(CompetitionToParticipantWrapper::className(), ['participant_id' => 'id']);
    }


    public function behaviors() {
        return [
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    [
                        'editableAttribute' => 'docs', // Editable attribute name
                        'name' => 'documents',
                    ],
                ],
            ]
        ];
    }


    public function getDocuments() {
        return $this->hasMany(DocumentWrapper::className(), ['id' => 'document_id'])
            ->viaTable('tbl_participant_to_document', ['participant_id' => 'id'])
            ->orderBy('type');
    }

}