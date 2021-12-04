<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_event}}".
 *
 * @property int $id
 * @property string $location
 * @property int $competition_id
 * @property int $competition_group_id
 * @property int $competition_phase_id
 * @property int $season_id
 * @property int $category_id sport_type
 * @property string $start_time
 * @property int $parent_id for playoff type events
 * @property int $type
 * @property string $edited_username
 * @property string $create_username
 * @property string $date_created
 * @property string $date_modified
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_event}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['competition_id', 'season_id', 'start_time'], 'required'],
            [['competition_id', 'competition_group_id', 'competition_phase_id', 'season_id', 'category_id', 'parent_id', 'type'], 'integer'],
            [['start_time', 'date_created', 'date_modified'], 'safe'],
            [['location', 'edited_username', 'create_username'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'location' => Yii::t('app', 'Location'),
            'competition_id' => Yii::t('app', 'Competition ID'),
            'competition_group_id' => Yii::t('app', 'Competition Group ID'),
            'competition_phase_id' => Yii::t('app', 'Competition Phase ID'),
            'season_id' => Yii::t('app', 'Season ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'start_time' => Yii::t('app', 'Start Time'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'type' => Yii::t('app', 'Type'),
            'edited_username' => Yii::t('app', 'Edited Username'),
            'create_username' => Yii::t('app', 'Create Username'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_modified' => Yii::t('app', 'Date Modified'),
        ];
    }
}
