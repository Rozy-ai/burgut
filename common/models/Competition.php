<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_competition}}".
 *
 * @property int $id
 * @property int $category_id
 * @property int $content_item_id
 * @property int $season_id
 * @property int $is_team
 * @property int $gender
 * @property int $is_international
 */
class Competition extends CommonActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_competition}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'is_team'], 'required'],
            [['category_id', 'content_item_id', 'season_id', 'is_team', 'gender', 'is_international'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'content_item_id' => Yii::t('app', 'Content Item ID'),
            'season_id' => Yii::t('app', 'Season ID'),
            'is_team' => Yii::t('app', 'Is Team'),
            'gender' => Yii::t('app', 'Gender'),
            'is_international' => Yii::t('app', 'Is International'),
        ];
    }
}
