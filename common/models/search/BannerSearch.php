<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\wrappers\BannerWrapper;

/**
 * BannerWrapperSearch represents the model behind the search form about `common\models\wrappers\BannerWrapper`.
 */
class BannerSearch extends BannerWrapper
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'format_type', 'width', 'height', 'type'], 'integer'],
            [['description', 'url', 'edited_username', 'create_username', 'date_created', 'date_modified'], 'safe'],
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
        $query = BannerWrapper::find();

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
            'format_type' => $this->format_type,
            'width' => $this->width,
            'height' => $this->height,
            'type' => $this->type,
            'date_created' => $this->date_created,
            'date_modified' => $this->date_modified,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'edited_username', $this->edited_username])
            ->andFilterWhere(['like', 'create_username', $this->create_username]);


        if(isset($this->exceptions) && is_array($this->exceptions) && count($this->exceptions)>0){
            $query->andFilterWhere(['not in','id',$this->exceptions]);
        }

        return $dataProvider;
    }
}
