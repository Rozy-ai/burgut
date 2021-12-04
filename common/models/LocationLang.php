<?php

namespace common\models;

use common\models\wrappers\LocationWrapper;
use Yii;

/**
 * This is the model class for table "{{%tbl_location_lang}}".
 *
 * @property integer $id
 * @property integer $location_id
 * @property string $language
 * @property string $title
 * @property string $description
 * @property string $content
 */
class LocationLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_location_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location_id', 'language', 'title'], 'required'],
            [['location_id'], 'integer'],
            [['content'], 'string'],
            [['language'], 'string', 'max' => 6],
            [['title'], 'string', 'max' => 255],
            [['location_id'], 'exist', 'skipOnError' => true, 'targetClass' => Location::className(), 'targetAttribute' => ['location_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'location_id' => Yii::t('backend', 'Location ID'),
            'language' => Yii::t('backend', 'Language'),
            'title' => Yii::t('backend', 'Title'),
            'description' => Yii::t('backend', 'Description'),
            'content' => Yii::t('backend', 'Content'),
        ];
    }
}
