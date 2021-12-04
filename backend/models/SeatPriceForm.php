<?php
namespace backend\models;

use common\models\wrappers\EventWrapper;
use common\models\wrappers\SeatGroupWrapper;
use yii\base\Model;

/**
 * Login form
 */
class SeatPriceForm extends Model
{
    public $event_id;
    public $seat_group_id;
    public $price;
    public $discount;


    public function rules()
    {
        return [
            [['event_id', 'seat_group_id'], 'required'],
            [['event_id', 'seat_group_id', 'status'], 'integer'],
            [['price', 'discount'], 'number'],
            [['event_id', 'seat_group_id', 'price', 'discount'], 'safe'],
        ];
    }


    public function getEvent()
    {
        if (isset($this->event_id))
            return EventWrapper::find()->where(['id' => (int)$this->event_id])->one();
    }


    public function getSeatGroup()
    {
        if (isset($this->seat_group_id))
            return SeatGroupWrapper::find()->where(['id' => (int)$this->seat_group_id])->one();
    }
}
