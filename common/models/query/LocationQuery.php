<?php

namespace common\models\query;
use omgdef\multilingual\MultilingualTrait;

/**
 * This is the ActiveQuery class for [[\common\models\Location]].
 *
 * @see \common\models\Location
 */
class LocationQuery extends \yii\db\ActiveQuery {
    use MultilingualTrait;


    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Location[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Location|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }


    public function hasNoParent() {
        return $this->andWhere(['OR', 'parent_id is null', 'parent_id=0']);
    }

    public function hasParent() {
        return $this->andWhere(['AND', 'parent_id is not null', 'parent_id<>0']);
    }


    public function categoryCode($code = 'location') {
        return $this->joinWith('category cat')
            ->andWhere([['cat.code' => $code]]);
    }


}
