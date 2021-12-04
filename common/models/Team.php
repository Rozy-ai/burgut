<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_team}}".
 *
 * @property int $id
 * @property int $category_id sport_type
 * @property int $content_item_id
 * @property int $gender
 */
class Team extends CommonActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_team}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['category_id', 'content_item_id', 'gender'], 'integer'],
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
            'gender' => Yii::t('app', 'Gender'),
        ];
    }
}
