<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DockReceipt;

/**
 * DockReceiptSearch represents the model behind the search form of `common\models\DockReceipt`.
 */
class DockReceiptSearch extends DockReceipt
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['export_id'], 'integer'],
            [['awb_number', 'export_reference', 'forwarding_agent', 'domestic_routing_insctructions', 'pre_carriage_by', 'place_of_receipt_by_pre_carrier', 'exporting_carrier', 'final_destination', 'loading_terminal', 'container_type', 'number_of_packages', 'by', 'date', 'auto_recieving_date', 'auto_cut_off', 'vessel_cut_off', 'sale_date'], 'safe'],
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
        $query = DockReceipt::find();

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
            'export_id' => $this->export_id,
            'date' => $this->date,
            'auto_recieving_date' => $this->auto_recieving_date,
            'sale_date' => $this->sale_date,
        ]);

        $query->andFilterWhere(['like', 'awb_number', $this->awb_number])
            ->andFilterWhere(['like', 'export_reference', $this->export_reference])
            ->andFilterWhere(['like', 'forwarding_agent', $this->forwarding_agent])
            ->andFilterWhere(['like', 'domestic_routing_insctructions', $this->domestic_routing_insctructions])
            ->andFilterWhere(['like', 'pre_carriage_by', $this->pre_carriage_by])
            ->andFilterWhere(['like', 'place_of_receipt_by_pre_carrier', $this->place_of_receipt_by_pre_carrier])
            ->andFilterWhere(['like', 'exporting_carrier', $this->exporting_carrier])
            ->andFilterWhere(['like', 'final_destination', $this->final_destination])
            ->andFilterWhere(['like', 'loading_terminal', $this->loading_terminal])
            ->andFilterWhere(['like', 'container_type', $this->container_type])
            ->andFilterWhere(['like', 'number_of_packages', $this->number_of_packages])
            ->andFilterWhere(['like', 'by', $this->by])
            ->andFilterWhere(['like', 'auto_cut_off', $this->auto_cut_off])
            ->andFilterWhere(['like', 'vessel_cut_off', $this->vessel_cut_off]);

        return $dataProvider;
    }
}
