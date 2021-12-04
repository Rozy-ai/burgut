<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_banner}}".
 *
 * @property integer $id
 * @property integer $format_type
 * @property string $description
 * @property integer $width
 * @property integer $height
 * @property integer $type
 * @property string $url
 * @property string $edited_username
 * @property string $create_username
 * @property string $date_created
 * @property string $date_modified
 */
class Banner extends CommonActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_banner}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['format_type', 'type'], 'required'],
            [['format_type', 'width', 'height', 'type'], 'integer'],
            [['date_created', 'date_modified'], 'safe'],
            [['description', 'url', 'edited_username', 'create_username'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'format_type' => Yii::t('app', 'Format Type'),
            'description' => Yii::t('app', 'Description'),
            'width' => Yii::t('app', 'Width'),
            'height' => Yii::t('app', 'Height'),
            'type' => Yii::t('app', 'Type'),
            'url' => Yii::t('app', 'Url'),
            'edited_username' => Yii::t('app', 'Edited Username'),
            'create_username' => Yii::t('app', 'Create Username'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_modified' => Yii::t('app', 'Date Modified'),
        ];
    }
}
