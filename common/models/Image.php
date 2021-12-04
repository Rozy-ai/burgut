<?php
namespace common\models;
use Yii;

/**
 * This is the model class for table "{{%tbl_image}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $type
 * @property integer $size
 * @property string $date_created
 * @property string $date_modified
 */
class Image extends CommonActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_image}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'type'], 'required'],
            [['type', 'size'], 'integer'],
            [['date_created', 'date_modified'], 'safe'],
            [['title', 'description', 'btn_link','btn_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'type' => Yii::t('app', 'Type'),
            'size' => Yii::t('app', 'Size'),
            'btn_link' => Yii::t('app', 'Button Link'),
            'btn_title' => Yii::t('app', 'Button Title'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_modified' => Yii::t('app', 'Date Modified'),
        ];
    }
}
