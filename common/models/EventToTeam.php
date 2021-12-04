<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_event_to_team}}".
 *
 * @property int $id
 * @property int $event_id
 * @property int $competition_id
 * @property int $team_id
 * @property int $score_for
 * @property int $score_against
 * @property int $point
 * @property int $result_state
 * @property int $category_id sport_type
 */
class EventToTeam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_event_to_team}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'competition_id', 'category_id'], 'required'],
            [['event_id', 'competition_id', 'team_id', 'score_for', 'score_against', 'point', 'result_state', 'category_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'event_id' => Yii::t('app', 'Event ID'),
            'competition_id' => Yii::t('app', 'Competition ID'),
            'team_id' => Yii::t('app', 'Team ID'),
            'score_for' => Yii::t('app', 'Score For'),
            'score_against' => Yii::t('app', 'Score Against'),
            'point' => Yii::t('app', 'Point'),
            'result_state' => Yii::t('app', 'Result State'),
            'category_id' => Yii::t('app', 'Category ID'),
        ];
    }
}
