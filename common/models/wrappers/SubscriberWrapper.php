<?php
/**
 * Created by PhpStorm.
 * User: batyr
 * Date: 9/28/2017
 * Time: 10:44 AM
 */

namespace common\models\wrappers;


use common\models\Subscriber;

class SubscriberWrapper extends Subscriber{

    const TYPE_NEWS= 1;
    const TYPE_ADVICE= 2;

    public static function getTypeOptions()
    {
        return array(
            self::TYPE_NEWS => Yii::t('app', 'TYPE_NEWS'),
            self::TYPE_ADVICE=> Yii::t('app', 'TYPE_ADVICE'),
        );
    }
}