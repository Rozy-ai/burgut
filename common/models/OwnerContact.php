<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_owner_contact}}".
 *
 * @property integer $id
 * @property string $my_title
 * @property string $my_description
 * @property string $my_email
 * @property string $my_phone
 * @property string $my_address
 * @property string $my_latitude
 * @property string $my_longitude
 * @property string $date_added
 * @property string $date_modified
 * @property string $edited_username
 * @property string $create_username
 */
class OwnerContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_owner_contact}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['my_description'], 'string'],
            [['my_latitude', 'my_longitude'], 'number'],
            [['date_added', 'date_modified'], 'safe'],
            [['my_title', 'my_email', 'my_phone', 'my_address', 'edited_username', 'create_username'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'my_title' => Yii::t('app', 'My Title'),
            'my_description' => Yii::t('app', 'My Description'),
            'my_email' => Yii::t('app', 'My Email'),
            'my_phone' => Yii::t('app', 'My Phone'),
            'my_address' => Yii::t('app', 'My Address'),
            'my_latitude' => Yii::t('app', 'My Latitude'),
            'my_longitude' => Yii::t('app', 'My Longitude'),
            'date_added' => Yii::t('app', 'Date Added'),
            'date_modified' => Yii::t('app', 'Date Modified'),
            'edited_username' => Yii::t('app', 'Edited Username'),
            'create_username' => Yii::t('app', 'Create Username'),
        ];
    }
}
