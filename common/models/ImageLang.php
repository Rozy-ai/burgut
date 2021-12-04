<?php

namespace common\models;

use common\models\wrappers\ImageWrapper;
use Yii;

/**
 * This is the model class for table "{{%tbl_image_lang}}".
 *
 * @property integer $id
 * @property integer $image_id
 * @property string $language
 * @property string $title
 * @property string $description
 * @property string $content
 */
class ImageLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_image_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_id', 'language', 'title'], 'required'],
            [['image_id'], 'integer'],
            [['language'], 'string', 'max' => 6],
            [['title','btn_link', 'btn_title'], 'string', 'max' => 255],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'image_id' => Yii::t('backend', 'Image ID'),
            'language' => Yii::t('backend', 'Language'),
            'title' => Yii::t('backend', 'Title'),
            'description' => Yii::t('backend', 'Description'),
        ];
    }
}
