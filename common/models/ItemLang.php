<?php

namespace common\models;

use common\models\wrappers\ItemWrapper;
use Yii;

/**
 * This is the model class for table "{{%tbl_item_lang}}".
 *
 * @property integer $id
 * @property integer $item_id
 * @property string $language
 * @property string $title
 * @property string $description
 * @property string $content
 */
class ItemLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_item_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'language', 'title'], 'required'],
            [['item_id'], 'integer'],
            [['content'], 'string'],
            [['language'], 'string', 'max' => 6],
            [['title'], 'string', 'max' => 255],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'item_id' => Yii::t('backend', 'Item ID'),
            'language' => Yii::t('backend', 'Language'),
            'title' => Yii::t('backend', 'Title'),
            'description' => Yii::t('backend', 'Description'),
            'content' => Yii::t('backend', 'Content'),
        ];
    }
}
