<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\wrappers\CompetitionWrapper;

/**
 * CompetitionSearch represents the model behind the search form of `common\models\wrappers\CompetitionWrapper`.
 */
class CompetitionSearch extends CompetitionWrapper {
    public $is_active;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'category_id', 'season_id', 'is_team'], 'integer'],
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
        $query = CompetitionWrapper::find();

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
            'season_id' => $this->season_id,
            'is_team' => $this->is_team,
        ]);


        if (isset($this->is_active)) {
            $query->joinWith('season s');
            $query->andWhere(['and', "s.end_date>= '" . \Yii::$app->formatter->asDate(new \DateTime(), 'yyyy-MM-dd HH:mm:ss') . "'", "s.end_date is not null"]);
        }

        return $dataProvider;
    }
}
