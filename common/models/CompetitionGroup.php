<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_competition_group}}".
 *
 * @property int $id
 * @property int $competition_id
 * @property string $name
 */
class CompetitionGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_competition_group}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['competition_id', 'name'], 'required'],
            [['competition_id'], 'integer'],
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
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
