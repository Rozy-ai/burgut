<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_category_lang}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $language
 * @property string $name
 * @property string $description
 * @property string $alias
 * @property string $meta_description
 * @property string $meta_keyword
 */
class CategoryLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_category_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'language', 'name'], 'required'],
            [['category_id'], 'integer'],
            [['language'], 'string', 'max' => 6],
            [['name', 'description', 'alias', 'meta_description', 'meta_keyword'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'category_id' => Yii::t('backend', 'Category ID'),
            'language' => Yii::t('backend', 'Language'),
            'name' => Yii::t('backend', 'Name'),
            'description' => Yii::t('backend', 'Description'),
            'alias' => Yii::t('backend', 'Alias'),
            'meta_description' => Yii::t('backend', 'Meta Description'),
            'meta_keyword' => Yii::t('backend', 'Meta Keyword'),
        ];
    }
}
