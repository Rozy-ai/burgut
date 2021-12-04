<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_season}}".
 *
 * @property int $id
 * @property string $name
 * @property int $competition_id sport_type
 * @property string $start_date
 * @property string $end_date
 */
class Season extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_season}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'competition_id'], 'required'],
            [['competition_id'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
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
            'name' => Yii::t('app', 'Name'),
            'competition_id' => Yii::t('app', 'Competition ID'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
        ];
    }
}
