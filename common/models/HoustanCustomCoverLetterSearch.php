<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\HoustanCustomCoverLetter;

/**
 * HoustanCustomCoverLetterSearch represents the model behind the search form of `common\models\HoustanCustomCoverLetter`.
 */
class HoustanCustomCoverLetterSearch extends HoustanCustomCoverLetter
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['export_id'], 'integer'],
            [['vehicle_location', 'exporter_id', 'exporter_type_issuer', 'transportation_value', 'exporter_dob', 'ultimate_consignee_dob', 'consignee', 'notify_party', 'menifest_consignee'], 'safe'],
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
        $query = HoustanCustomCoverLetter::find();

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
        ]);

        $query->andFilterWhere(['like', 'vehicle_location', $this->vehicle_location])
            ->andFilterWhere(['like', 'exporter_id', $this->exporter_id])
            ->andFilterWhere(['like', 'exporter_type_issuer', $this->exporter_type_issuer])
            ->andFilterWhere(['like', 'transportation_value', $this->transportation_value])
            ->andFilterWhere(['like', 'exporter_dob', $this->exporter_dob])
            ->andFilterWhere(['like', 'ultimate_consignee_dob', $this->ultimate_consignee_dob])
            ->andFilterWhere(['like', 'consignee', $this->consignee])
            ->andFilterWhere(['like', 'notify_party', $this->notify_party])
            ->andFilterWhere(['like', 'menifest_consignee', $this->menifest_consignee]);

        return $dataProvider;
    }
}
