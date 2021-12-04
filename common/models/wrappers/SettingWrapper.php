<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 6/18/2019
 * Time: 4:48 PM
 */

namespace common\models\wrappers;


use common\models\Setting;
use Yii;

class SettingWrapper extends Setting
{
    public function attributeLabels()
    {
        return \yii\helpers\ArrayHelper::merge(parent::attributeLabels(), [
            'name' => Yii::t('app', 'Key'),
        ]);
    }


    const TYPE_BACKEND = 1, TYPE_FRONTEND = 2, TYPE_MOBILE = 3;

    public static function getTypeOptions()
    {
        return array(
            self::TYPE_BACKEND => Yii::t('app', 'TYPE_BACKEND'),
            self::TYPE_FRONTEND => Yii::t('app', 'TYPE_FRONTEND'),
            self::TYPE_MOBILE => Yii::t('app', 'TYPE_MOBILE'),
        );
    }

    public function getTypeText()
    {
        $typeOptions = $this->getTypeOptions();
        return isset($typeOptions[$this->type]) ? $typeOptions[$this->type] : '';
    }


    public function fields()
    {
        $fields = parent::fields();
//        $fields['key'] = function () {
//            return $this->name;
//        };

        unset($fields['type']);
        return $fields;
    }

}