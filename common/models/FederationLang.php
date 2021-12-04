<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_federation_lang}}".
 *
 * @property int $id
 * @property int $federation_id
 * @property string $language
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $address
 */
class FederationLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_federation_lang}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['federation_id', 'language', 'title'], 'required'],
            [['federation_id'], 'integer'],
            [['description', 'content'], 'string'],
            [['language'], 'string', 'max' => 6],
            [['title', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'federation_id' => Yii::t('app', 'Federation ID'),
            'language' => Yii::t('app', 'Language'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'content' => Yii::t('app', 'Content'),
            'address' => Yii::t('app', 'Address'),
        ];
    }
}
