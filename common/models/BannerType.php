<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_banner_type}}".
 *
 * @property integer $id
 * @property string $type_name
 * @property integer $width
 * @property integer $height
 * @property integer $type
 * @property integer $status
 * @property string $description
 */
class BannerType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_banner_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_name'], 'required'],
            [['width', 'height', 'type', 'status'], 'integer'],
            [['type_name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type_name' => Yii::t('app', 'Type Name'),
            'width' => Yii::t('app', 'Width'),
            'height' => Yii::t('app', 'Height'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
}
