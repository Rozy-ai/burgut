<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_federation}}".
 *
 * @property int $id
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property int $visited_count
 * @property int $sort_order
 * @property int $status
 * @property string $edited_username
 * @property string $create_username
 * @property string $date_created
 * @property string $date_modified
 */
class Federation extends CommonActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_federation}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['visited_count', 'sort_order', 'status'], 'integer'],
            [['status'], 'required'],
            [['date_created', 'date_modified'], 'safe'],
            [['phone', 'fax', 'email', 'edited_username', 'create_username'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'phone' => Yii::t('app', 'Phone'),
            'fax' => Yii::t('app', 'Fax'),
            'email' => Yii::t('app', 'Email'),
            'visited_count' => Yii::t('app', 'Visited Count'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'status' => Yii::t('app', 'Status'),
            'edited_username' => Yii::t('app', 'Edited Username'),
            'create_username' => Yii::t('app', 'Create Username'),
            'date_created' => Yii::t('app', 'Date Created'),
            'date_modified' => Yii::t('app', 'Date Modified'),
        ];
    }
}
