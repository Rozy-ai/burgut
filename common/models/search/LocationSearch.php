<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\wrappers\LocationWrapper;

/**
 * LocationSearch represents the model behind the search form about `common\models\wrappers\LocationWrapper`.
 */
class LocationSearch extends LocationWrapper
{
    public $pub_date;
    public $query;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'parent_category_id', 'visited_count', 'sort_order', 'status'], 'integer'],
            [['title', 'description', 'alias', 'edited_username', 'create_username', 'date_created', 'date_modified'], 'safe'],
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
        $query = LocationWrapper::find();

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
            'category_id' => $this->category_id,
            'parent_category_id' => $this->parent_category_id,
            'visited_count' => $this->visited_count,
            'sort_order' => $this->sort_order,
            'status' => $this->status,
            'date_created' => $this->date_created,
            'date_modified' => $this->date_modified,
        ]);


        if (isset($this->query) && strlen(trim($this->query))) {
            $query->orFilterWhere(['like', 'title', $this->query])
                ->orFilterWhere(['like', 'description', $this->query])
                ->orFilterWhere(['like', 'content', $this->query]);
        }


        $query->andWhere(['or', 'parent_id is null', 'parent_id=0']);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'edited_username', $this->edited_username])
            ->andFilterWhere(['like', 'create_username', $this->create_username]);

        return $dataProvider;
    }
}
