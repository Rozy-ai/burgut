<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\wrappers\EventWrapper;

/**
 * EventSearch represents the model behind the search form of `common\models\wrappers\EventWrapper`.
 */
class EventSearch extends EventWrapper {
    public $from_start_time;
    public $to_start_time;
    public $from_end_time;
    public $to_end_time;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'competition_id', 'season_id'], 'integer'],
            [['location', 'start_time', 'edited_username', 'create_username', 'date_created', 'date_modified'], 'safe'],
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
    public function search($params, $formName = null) {
        $query = EventWrapper::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
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
            'id' => $this->id,
            'competition_id' => $this->competition_id,
//            'location' => $this->location,
            'season_id' => $this->season_id,
//            'start_time' => $this->start_time,
            'date_created' => $this->date_created,
            'date_modified' => $this->date_modified,
        ]);


//        $query->andFilterWhere(['like', 'location', $this->location]);

        if (isset($this->afterStartDatetime)) {
            $query->andWhere(['and', "start_time  >= '" . \Yii::$app->formatter->asDate($this->afterStartDatetime, 'yyyy-MM-dd HH:mm:ss') . "'", "start_time is not null"]);
        }

        if (isset($this->from_start_time))
            $query->andFilterWhere(['>=', 'start_time', $this->from_start_time]);
        if (isset($this->to_start_time))
            $query->andFilterWhere(['<=', 'start_time', $this->to_start_time]);

        if (isset($this->from_end_time))
            $query->andFilterWhere(['<=', 'end_time', $this->to_end_time]);
        if (isset($this->to_end_time))
            $query->andFilterWhere(['>=', 'end_time', $this->from_end_time]);


        $query->andFilterWhere(['like', 'edited_username', $this->edited_username])
            ->andFilterWhere(['like', 'create_username', $this->create_username]);

        return $dataProvider;
    }
}
