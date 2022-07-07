<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TowingRequest;

/**
 * TowingRequestSearch represents the model behind the search form of `common\models\TowingRequest`.
 */
class TowingRequestSearch extends TowingRequest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['condition', 'damaged', 'pictures', 'towed', 'title_recieved'], 'boolean'],
            [['title_recieved_date', 'title_number', 'title_state', 'towing_request_date', 'pickup_date', 'deliver_date', 'note'], 'safe'],
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
        $query = TowingRequest::find();

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
            'condition' => $this->condition,
            'damaged' => $this->damaged,
            'pictures' => $this->pictures,
            'towed' => $this->towed,
            'title_recieved' => $this->title_recieved,
            'title_recieved_date' => $this->title_recieved_date,
            'towing_request_date' => $this->towing_request_date,
            'pickup_date' => $this->pickup_date,
            'deliver_date' => $this->deliver_date,
        ]);

        $query->andFilterWhere(['like', 'title_number', $this->title_number])
            ->andFilterWhere(['like', 'title_state', $this->title_state])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
