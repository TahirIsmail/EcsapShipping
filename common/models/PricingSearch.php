<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Pricing;

/**
 * PricingSearch represents the model behind the search form of `common\models\Pricing`.
 */
class PricingSearch extends Pricing
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pricing_type', 'status', 'created_by', 'updated_by'], 'integer'],
            [['upload_file', 'month', 'created_at', 'updated_at'], 'safe'],
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
        $query = Pricing::find();

        // add conditions that should always apply here
        $query->orderBy("status");
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
            'pricing_type' => $this->pricing_type,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'upload_file', $this->upload_file])
            ->andFilterWhere(['like', 'month', $this->month]);

        return $dataProvider;
    }
}
