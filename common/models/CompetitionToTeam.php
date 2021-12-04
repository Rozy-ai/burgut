<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_competition_to_team}}".
 *
 * @property int $id
 * @property int $competition_id
 * @property int $team_id
 * @property int $group_id
 * @property int $category_id sport_type
 */
class CompetitionToTeam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_competition_to_team}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['competition_id', 'category_id'], 'required'],
            [['competition_id', 'team_id', 'group_id', 'category_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'competition_id' => Yii::t('app', 'Competition ID'),
            'team_id' => Yii::t('app', 'Team ID'),
            'group_id' => Yii::t('app', 'Group ID'),
            'category_id' => Yii::t('app', 'Category ID'),
        ];
    }
}
