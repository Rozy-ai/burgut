<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\wrappers\FederationWrapper;

/**
 * FederationSearch represents the model behind the search form of `common\models\wrappers\FederationWrapper`.
 */
class FederationSearch extends FederationWrapper
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'visited_count', 'sort_order', 'status'], 'integer'],
            [['phone', 'fax', 'email', 'edited_username', 'create_username', 'date_created', 'date_modified'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = FederationWrapper::find();

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
            'visited_count' => $this->visited_count,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
            'date_created' => $this->date_created,
            'date_modified' => $this->date_modified,
        ]);

        $query->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'edited_username', $this->edited_username])
            ->andFilterWhere(['like', 'create_username', $this->create_username]);

        return $dataProvider;
    }
}
