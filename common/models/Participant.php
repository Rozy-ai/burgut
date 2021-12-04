<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_participant}}".
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $middlename
 * @property string $weight
 * @property string $height
 * @property int $gender
 * @property string $birthdate
 */
class Participant extends CommonActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_participant}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'gender'], 'required'],
            [['weight', 'height'], 'number'],
            [['gender'], 'integer'],
            [['birthdate'], 'safe'],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'middlename' => Yii::t('app', 'Middlename'),
            'weight' => Yii::t('app', 'Weight'),
            'height' => Yii::t('app', 'Height'),
            'gender' => Yii::t('app', 'Gender'),
            'birthdate' => Yii::t('app', 'Birthdate'),
        ];
    }
}
