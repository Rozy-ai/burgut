<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_category_field}}".
 *
 * @property int $id
 * @property int $category_id
 * @property string $target_model
 * @property string $field_name
 * @property string $field_description
 */
class CategoryField extends CommonActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_category_field}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'field_name'], 'required'],
            [['category_id', 'multilingual', 'html_type'], 'integer'],
            [['target_model', 'field_name'], 'string', 'max' => 255],
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
            'target_model' => Yii::t('app', 'Target Model'),
            'field_name' => Yii::t('app', 'Field Name'),
            'multilingual' => Yii::t('app', 'Multilingual'),
        ];
    }
}
