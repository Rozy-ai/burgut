<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\wrappers\CategoryFieldWrapper;

/**
 * CategoryFieldSearch represents the model behind the search form of `common\models\wrappers\CategoryFieldWrapper`.
 */
class CategoryFieldSearch extends CategoryFieldWrapper {
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'category_id'], 'integer'],
            [['field_name', 'field_description'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params) {
        $query = CategoryFieldWrapper::find();

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
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'field_name', $this->field_name])
            ->andFilterWhere(['like', 'field_description', $this->field_description]);


        if (!isset($_GET['sort'])) {
            $query->orderBy('target_model');
        }

        return $dataProvider;
    }
}
