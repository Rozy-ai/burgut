<?php

namespace common\models\wrappers;

use common\models\ItemLang;
use common\models\wrappers\ItemWrapper;
use Yii;

class ItemLangWrapper extends ItemLang
{
    public function getItem()
    {
        return $this->hasOne(ItemWrapper::className(), ['id' => 'item_id']);
    }

    
}
