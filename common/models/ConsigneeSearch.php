<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Consignee;

/**
 * ConsigneeSearch represents the model behind the search form of `common\models\Consignee`.
 */
class ConsigneeSearch extends Consignee
{
    public $consignee_global_search;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'customer_user_id', 'created_by', 'updated_by'], 'integer'],
            [['consignee_name', 'consignee_address_1', 'consignee_global_search','consignee_address_2', 'city', 'state', 'country', 'zip_code', 'phone', 'created_at', 'updated_at'], 'safe'],
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
        $query = Consignee::find()->alias('u');
                $query->joinWith(['customerUser as cu']);


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
              'sort'=> ['defaultOrder' => ['consignee_name' => SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'customer_user_id' => $this->customer_user_id,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//            'created_by' => $this->created_by,
//            'updated_by' => $this->updated_by,
//        ]);

        $query->andFilterWhere(['like', 'consignee_name', $this->consignee_name])
            ->orFilterWhere(['like', 'consignee_name', $this->consignee_global_search])
            ->andFilterWhere(['like', 'customer_user_id', $this->customer_user_id])
            ->andFilterWhere(['like', 'consignee_address_1', $this->consignee_address_1])
            ->andFilterWhere(['like', 'consignee_address_2', $this->consignee_address_2])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'zip_code', $this->zip_code])
            ->orFilterWhere(['like', 'u.city', $this->consignee_global_search])
            ->orFilterWhere(['like', 'cu.customer_name', $this->consignee_global_search])
            ->orFilterWhere(['like', 'u.state', $this->consignee_global_search])
            ->orFilterWhere(['like', 'u.country', $this->consignee_global_search])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
