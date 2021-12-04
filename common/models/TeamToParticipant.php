<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_team_to_participant}}".
 *
 * @property int $id
 * @property int $team_id
 * @property int $participant_id
 * @property int $type
 * @property int $status
 * @property string $date_joined
 * @property string $date_leaved
 */
class TeamToParticipant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_team_to_participant}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['team_id', 'participant_id', 'type'], 'required'],
            [['team_id', 'participant_id', 'type', 'status'], 'integer'],
            [['date_joined', 'date_leaved'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'team_id' => Yii::t('app', 'Team ID'),
            'participant_id' => Yii::t('app', 'Participant ID'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'date_joined' => Yii::t('app', 'Date Joined'),
            'date_leaved' => Yii::t('app', 'Date Leaved'),
        ];
    }
}
