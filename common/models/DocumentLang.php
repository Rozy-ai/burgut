<?php

namespace common\models;

use common\models\wrappers\DocumentWrapper;
use Yii;

/**
 * This is the model class for table "{{%tbl_document_lang}}".
 *
 * @property integer $id
 * @property integer $document_id
 * @property string $language
 * @property string $title
 * @property string $author
 */
class DocumentLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_document_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document_id', 'language', 'title'], 'required'],
            [['document_id'], 'integer'],
            [['language'], 'string', 'max' => 6],
            [['title','author'], 'string', 'max' => 255],
            [['document_id'], 'exist', 'skipOnError' => true, 'targetClass' => Document::className(), 'targetAttribute' => ['document_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'document_id' => Yii::t('backend', 'Document ID'),
            'language' => Yii::t('backend', 'Language'),
            'title' => Yii::t('backend', 'Title'),
            'author' => Yii::t('backend', 'Author'),
        ];
    }
}
