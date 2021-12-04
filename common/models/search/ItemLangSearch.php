<?php

namespace common\models\search;

use common\models\ItemLang;
use common\models\wrappers\ItemLangWrapper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\wrappers\ItemWrapper;
use yii\data\Pagination;

/**
 * ItemSearch represents the model behind the search form about `common\models\wrappers\ItemWrapper`.
 */
class ItemLangSearch extends ItemLangWrapper
{
    public $query;
    public $status;
    public $category = null;
    public $pages = null;

    public function search($params)
    {
        $query = ItemLangWrapper::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->andWhere([
            'language' => Yii::$app->language,
        ]);

        $query->joinWith('item it')->andWhere(['it.status' => $this->status]);

        if (isset($this->query) && strlen(trim($this->query))) {
            $query->andWhere(['or',
                ['like', 'title', $this->query],
                ['like', 'description', $this->query],
                ['like', 'content', $this->query]
            ]);
        }

        return $dataProvider;
    }

    public function searchByCategory($params)
    {


        $query = ItemWrapper::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query = ItemWrapper::find()
            ->joinWith('category cat')
            ->joinWith('category.parent parent')
            ->joinWith('translations tr')
            ->distinct()
            ->where(['tbl_item.status' => 1])
            ->andWhere(['tr.language'=>\Yii::$app->language])
            ->andWhere(['or', 'cat.code="' . $this->category . '"', 'parent.code="' . $this->category . '"']);



        if (isset($this->query) && strlen(trim($this->query))) {
            $query->andWhere(['or',
                ['like', 'tr.title', $this->query],
                ['like', 'tr.description', $this->query],
                ['like', 'tr.content', $this->query]
            ]);
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 6]);
            $query = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        }

        $this->pages = $pages;
        return $query;
    }
}
