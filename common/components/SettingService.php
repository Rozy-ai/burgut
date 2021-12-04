<?php
namespace common\components;

use common\models\wrappers\EventToSeatWrapper;
use common\models\wrappers\PaymentWrapper;
use common\models\wrappers\SettingWrapper;
use common\models\wrappers\TicketWrapper;
use kartik\mpdf\Pdf;
use Yii;
use yii\helpers\ArrayHelper;


class SettingService
{
    public function get($name, $category = null, $type = null)
    {
        $query = SettingWrapper::find();
        $query->andFilterCompare([
            'name' => $name,
            'category' => $category,
            'type' => $type,
        ]);

        $model = $query->one();
        return isset($model) ? $model->value : null;
    }


}
