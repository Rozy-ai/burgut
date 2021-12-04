<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_setting}}".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $category
 * @property int $is_serialized
 * @property int $type
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_setting}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'value', 'category', 'type'], 'required'],
            [['value'], 'string'],
            [['is_serialized', 'type'], 'integer'],
            [['name', 'category'], 'string', 'max' => 255],
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
            'value' => Yii::t('app', 'Value'),
            'category' => Yii::t('app', 'Category'),
            'is_serialized' => Yii::t('app', 'Is Serialized'),
            'type' => Yii::t('app', 'Type'),
        ];
    }
}
