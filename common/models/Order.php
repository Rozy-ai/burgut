<?php

namespace common\models;

use Yii;
use common\models\OrderItems;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;


/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property int $qty
 * @property float $sum
 * @property string $status
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    public function behaviors()
{
return [
    [
   'class' => TimestampBehavior::className(),
   'attributes' => [
        ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
        ],
        // если вместо метки времени UNIX используется datetime:
        'value' => new Expression('NOW()'),
        ],
        ];
}

    public function getOrderItems(){
        return $this->hasMany(OrderItems::className(), ['order_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'address'], 'required',
            'message' => '{attribute} '.yii::t('app', 'is required')
        ],
            [['created_at', 'updated_at'], 'safe'],
            [['qty'], 'integer'],
            [['sum'], 'number'],
            [['status'], 'boolean'],
            [['name', 'email', 'phone', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => yii::t('app','Your name'),
            'email' => yii::t('app','Email'),
            'phone' => yii::t('app','Your phone'),
            'address' => yii::t('app','Address'),
        ];
    }
}
