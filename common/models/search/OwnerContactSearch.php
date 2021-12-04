<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\wrappers\OwnerContactWrapper;

/**
 * OwnerContactSearch represents the model behind the search form about `common\models\wrappers\OwnerContactWrapper`.
 */
class OwnerContactSearch extends OwnerContactWrapper
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['my_title', 'my_description', 'my_email', 'my_phone', 'my_address', 'date_added', 'date_modified', 'edited_username', 'create_username'], 'safe'],
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
        $query = OwnerContactWrapper::find();

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
            'date_added' => $this->date_added,
            'date_modified' => $this->date_modified,
        ]);

        $query->andFilterWhere(['like', 'my_title', $this->my_title])
            ->andFilterWhere(['like', 'my_description', $this->my_description])
            ->andFilterWhere(['like', 'my_email', $this->my_email])
            ->andFilterWhere(['like', 'my_phone', $this->my_phone])
            ->andFilterWhere(['like', 'my_address', $this->my_address])
            ->andFilterWhere(['like', 'edited_username', $this->edited_username])
            ->andFilterWhere(['like', 'create_username', $this->create_username]);

        return $dataProvider;
    }
}
