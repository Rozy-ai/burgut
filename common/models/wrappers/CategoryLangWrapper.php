<?php

namespace common\models\wrappers;

use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
use common\models\Album;
use common\models\CategoryLang;
use common\models\Item;
use common\models\Category;
use common\models\Music;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;
use yii\helpers\Url;

class CategoryLangWrapper extends CategoryLang
{

    public function getCategory()
    {
        return $this->hasOne(CategoryWrapper::className(), ['id' => 'category_id']);
    }
}
