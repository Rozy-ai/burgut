<?php

namespace common\models\search;

use common\models\wrappers\ItemWrapper;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ItemSearch represents the model behind the search form about `common\models\wrappers\ItemWrapper`.
 */
class ItemSearch extends ItemWrapper
{
    public $pub_date;
    public $category_ids;
    public $tag_ids;
    public $query;
    public $isOnlyLanguageExist = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'parent_category_id', 'visited_count', 'sort_order', 'status', 'is_main'], 'integer'],
            [['title', 'description', 'alias', 'author', 'edited_username', 'create_username', 'date_created', 'date_modified'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = ItemWrapper::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 9,
            ],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'tbl_item.id' => $this->id,
            'category_id' => $this->category_id,
            'parent_category_id' => $this->parent_category_id,
            'visited_count' => $this->visited_count,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
            'is_main' => $this->is_main,
            'type' => $this->type,
            'date_created' => $this->date_created,
            'date_modified' => $this->date_modified,
        ]);


        if (!empty($this->pub_date)) {
            $query->andWhere(['and',
                "date_created  >= '$this->pub_date 00:00:00'", "date_created <= '$this->pub_date 23:59:59'"
            ]);
        }


        if (isset($this->category_ids) && is_array($this->category_ids) && count($this->category_ids) > 0) {
            $query->andFilterWhere(['in', 'category_id', $this->category_ids]);
        }

        if (isset($this->tag_ids) && is_array($this->tag_ids) && count($this->tag_ids) > 0) {
            $query->joinWith('tags tgs')->andFilterWhere(['in', 'tgs.id', $this->tag_ids]);
        }

        $query->joinWith('translations', false);
        $query->distinct();
        $query->andFilterWhere(['like', 'tbl_item_lang.title', $this->title]);
        $query->andFilterWhere(['like', 'tbl_item_lang.description', $this->description]);
        $query->andFilterWhere(['like', 'tbl_item_lang.content', $this->content]);

        if (isset($this->query) && strlen(trim($this->query))) {
            $query->orFilterWhere(['like', 'tbl_item_lang.title', $this->query])
                ->orFilterWhere(['like', 'tbl_item_lang.description', $this->query])
                ->orFilterWhere(['like', 'tbl_item_lang.content', $this->query]);
        }

        if (isset($this->isOnlyLanguageExist)) {
            $query->andWhere(['not', ['tbl_item_lang.title' => null]])
                ->andWhere(['tbl_item_lang.language' => \Yii::$app->language]);
        }


        $query->andFilterWhere(['like', 'edited_username', $this->edited_username])
//            ->andFilterWhere(['like', 'description', $this->description])
//            ->andFilterWhere(['like', 'content', $this->content])
//            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'create_username', $this->create_username]);

        return $dataProvider;
    }
}
