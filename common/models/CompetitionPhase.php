<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_competition_phase}}".
 *
 * @property int $id
 * @property int $competition_id
 * @property int $season_id
 * @property int $sort_order
 * @property int $type event type example: playoff,league
 * @property string $name
 */
class CompetitionPhase extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_competition_phase}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['competition_id', 'season_id', 'name'], 'required'],
            [['competition_id', 'season_id', 'sort_order', 'type'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'season_id' => Yii::t('app', 'Season ID'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'type' => Yii::t('app', 'Type'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
