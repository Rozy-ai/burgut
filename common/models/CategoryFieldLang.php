<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tbl_category_field_lang".
 *
 * @property int $id
 * @property int $category_field_id
 * @property string $language
 * @property int $field_description
 */
class CategoryFieldLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_category_field_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_field_id', 'language', 'field_description'], 'required'],
            [['category_field_id',], 'integer'],
            [['language'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_field_id' => 'Category Field ID',
            'language' => 'Language',
            'field_description' => 'Field Description',
        ];
    }
}
