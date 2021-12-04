<?php

namespace common\models\search;

use common\models\wrappers\CompetitionPhaseWrapper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\wrappers\EventToTeamWrapper;

/**
 * EventToTeamSearch represents the model behind the search form of `common\models\wrappers\EventToTeamWrapper`.
 */
class EventToTeamSearch extends EventToTeamWrapper
{

    public $competition_group_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'event_id', 'competition_id', 'team_id', 'score_for', 'score_against', 'point', 'result_state', 'category_id'], 'integer'],
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
        $query = EventToTeamWrapper::find();

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
            'event_id' => $this->event_id,
            'competition_id' => $this->competition_id,
            'team_id' => $this->team_id,
            'score_for' => $this->score_for,
            'score_against' => $this->score_against,
            'point' => $this->point,
            'result_state' => $this->result_state,
            'category_id' => $this->category_id,
        ]);

        return $dataProvider;
    }


    public function searchForLeague($params)
    {
        $query = EventToTeamWrapper::find();

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
            self::tableName() . '.id' => $this->id,
            self::tableName() . '.event_id' => $this->event_id,
            self::tableName() . '.competition_id' => $this->competition_id,
            self::tableName() . '.team_id' => $this->team_id,
            self::tableName() . '.score_for' => $this->score_for,
            self::tableName() . '.score_against' => $this->score_against,
            self::tableName() . '.point' => $this->point,
            self::tableName() . '.result_state' => $this->result_state,
            self::tableName() . '.category_id' => $this->category_id,
        ]);

        $query->joinWith('event e');
        if (isset($this->competition_group_id)) {
            $query->andWhere(['e.competition_group_id' => $this->competition_group_id]);
        }

        $query->andWhere(['e.type' => CompetitionPhaseWrapper::TYPE_LEAGUE]);


        $query->groupBy(['team_id']);
        $query->select('
            team_id, 
            COUNT('.self::tableName().'.id) as event_count, 
            SUM(point) as sum_point,  
            SUM(score_for) as sum_score_for,  
            SUM(score_against) as sum_score_against,  
            SUM(CASE WHEN result_state = ' . self::RESULT_STATE_WIN . ' THEN 1 ELSE 0 END) total_win,
            SUM(CASE WHEN result_state = ' . self::RESULT_STATE_LOSS . ' THEN 1 ELSE 0 END) total_loss,
            SUM(CASE WHEN result_state = ' . self::RESULT_STATE_DRAW . ' THEN 1 ELSE 0 END) total_draw,
        ');

        $query->orderBy('sum_point desc');

        return $dataProvider;
    }
}
