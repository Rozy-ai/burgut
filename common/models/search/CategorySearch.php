<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\wrappers\CategoryWrapper;

/**
 * CategorySearch represents the model behind the search form about `common\models\wrappers\CategoryWrapper`.
 */
class CategorySearch extends CategoryWrapper
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'related_category_id', 'parent_id', 'top', 'sort_order', 'status'], 'integer'],
            [['alias', 'meta_description', 'meta_keyword', 'description', 'name', 'url_prefix', 'code', 'date_created', 'date_modified', 'edited_username', 'create_username'], 'safe'],
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
    public function search($params)
    {
        $query = CategoryWrapper::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'related_category_id' => $this->related_category_id,
            'parent_id' => $this->parent_id,
            'top' => $this->top,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
            'date_created' => $this->date_created,
            'date_modified' => $this->date_modified,
        ]);


        $query->joinWith('translations', false);
        $query->distinct();
        $query->andFilterWhere(['like', 'tbl_category_lang.name', $this->name]);
        $query->andFilterWhere(['like', 'tbl_category_lang.description', $this->description]);
        $query->andFilterWhere(['like', 'tbl_category_lang.meta_keyword', $this->meta_keyword]);
        $query->andFilterWhere(['like', 'tbl_category_lang.meta_description', $this->meta_description]);


        $query->andFilterWhere(['like', 'alias', $this->alias])
//            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
//            ->andFilterWhere(['like', 'meta_keyword', $this->meta_keyword])
//            ->andFilterWhere(['like', 'description', $this->description])
//            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'url_prefix', $this->url_prefix])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'edited_username', $this->edited_username])
            ->andFilterWhere(['like', 'create_username', $this->create_username]);

        return $dataProvider;
    }
}
