<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Export;

/**
 * ExportSearch represents the model behind the search form of `common\models\Export`.
 */
class ExportSearch extends Export
{
    public $export_global_search;
    public $customer_name;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [
                [
                    'export_date',
                    'customer_user_id',
                    'legacy_customer_id',
                    'customer_name',
                    'loading_date',
                    'export_global_search',
                    'broker_name',
                    'booking_number',
                    'eta',
                    'ar_number',
                    'xtn_number',
                    'seal_number',
                    'container_number',
                    'cutt_off',
                    'vessel',
                    'voyage',
                    'terminal',
                    'streamship_line',
                    'destination',
                    'itn',
                    'contact_details',
                    'special_instruction',
                    'container_type',
                    'port_of_loading',
                    'port_of_discharge',
                    'bol_note',
                    'created_at',
                    'updated_at',
                    'status'
                ],
                'safe'
            ],
            [['export_is_deleted'], 'boolean'],
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
     * @param bool $limitPerPage
     * @return ActiveDataProvider
     */
    public function search($params, $limitPerPage = 20)
    {
        $query = Export::find()->alias('ex');
        //$query->innerJoinWith(['vehicleExports.vehicle as v']);
        $query->leftJoin('vehicle_export as vx', 'vx.export_id = ex.id');
        $query->leftJoin('vehicle as v', 'v.id = vx.vehicle_id');
        $query->leftJoin('customer as c', 'c.user_id = ex.customer_user_id');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => ['pageSize' => $limitPerPage]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $user_id = Yii::$app->user->getId();
        $Role = Yii::$app->authManager->getRolesByUser($user_id);

        $query->andFilterWhere(['like', 'broker_name', $this->broker_name])
            ->andFilterWhere(['like', 'booking_number', $this->booking_number])
            ->andFilterWhere(['like', 'ex.created_at', $this->created_at])
            ->andFilterWhere(['like', 'c.legacy_customer_id', $this->legacy_customer_id])
            ->andFilterWhere(['like', 'c.company_name', $this->customer_name])
            ->andFilterWhere(['like', 'ex.eta', $this->eta])
            ->andFilterWhere(['like', 'ar_number', $this->ar_number])
            ->andFilterWhere(['like', 'xtn_number', $this->xtn_number])
            ->andFilterWhere(['like', 'seal_number', $this->seal_number])
            ->andFilterWhere(['like', 'ex.container_number', $this->container_number])
            ->andFilterWhere(['like', 'cutt_off', $this->cutt_off])
            ->andFilterWhere(['like', 'vessel', $this->vessel])
            ->andFilterWhere(['like', 'voyage', $this->voyage])
            ->andFilterWhere(['like', 'loading_date', $this->loading_date])
            ->andFilterWhere(['like', 'export_date', $this->export_date])
            ->andFilterWhere(['like', 'terminal', $this->terminal])
            ->andFilterWhere(['like', 'streamship_line', $this->streamship_line])
            ->andFilterWhere(['like', 'destination', $this->destination])
            ->andFilterWhere(['like', 'itn', $this->itn])
            ->andFilterWhere(['like', 'contact_details', $this->contact_details])
            ->andFilterWhere(['like', 'special_instruction', $this->special_instruction])
            ->andFilterWhere(['like', 'container_type', $this->container_type])
            ->andFilterWhere(['like', 'port_of_loading', $this->port_of_loading])
            ->andFilterWhere(['like', 'port_of_discharge', $this->port_of_discharge])
            ->orFilterWhere(['like', 'booking_number', $this->export_global_search])
            ->orFilterWhere(['like', 'ex.container_number', $this->export_global_search])
            ->orFilterWhere(['like', 'ex.eta', $this->export_global_search])
            ->orFilterWhere(['like', 'xtn_number', $this->export_global_search])
            ->orFilterWhere(['like', 'ar_number', $this->export_global_search])
            ->orFilterWhere(['like', 'broker_name', $this->export_global_search])
            ->orFilterWhere(['like', 'destination', $this->export_global_search])
            ->orFilterWhere(['like', 'c.company_name', $this->export_global_search])
            ->orFilterWhere(['like', 'c.customer_name', $this->export_global_search])
            ->orFilterWhere(['like', 'c.legacy_customer_id', $this->export_global_search])
            ->orFilterWhere(['like', 'v.status', $this->status])
            ->andFilterWhere(['like', 'bol_note', $this->bol_note]);
        if (isset($Role['admin_LA']) || isset($Role['admin_GA']) || isset($Role['admin_NY']) || isset($Role['admin_TX'])) {
            // $query->andFilterWhere(['=', 'created_by', $user_id]);

        }
        if (isset($Role['admin_LA'])) {
            $query->andFilterWhere(['=', 'v.location', '1']);
            $query->andWhere("v.location is null or v.location = 1");
            //  $query->andFilterWhere(['=', 'v.created_by', $user_id]);
        } elseif (isset($Role['admin_GA'])) {
            $query->andWhere("v.location is null or v.location = 2");
        } elseif (isset($Role['admin_NY'])) {
            $query->andWhere("v.location is null or v.location = 3");
        } elseif (isset($Role['admin_TX'])) {
            $query->andWhere("v.location is null or v.location = 4");
        } elseif (isset($Role['admin_TX2'])) {
            $query->andWhere("v.location is null or v.location = 5");
        } elseif (isset($Role['admin_NJ2'])) {
            $query->andWhere("v.location is null or v.location = 6");
        } elseif (isset($Role['admin_CA'])) {
            $query->andWhere("v.location is null or v.location = 7");
        }
        if (isset($_GET['ExportSearch']['customer_user_id'])) {
            $query->andFilterWhere(['=', 'v.customer_user_id', $_GET['ExportSearch']['customer_user_id']]);
        }
        $q2 = $query;
        $dataProvider->setTotalCount($q2->groupBy('ex.id')->count());

        return $dataProvider;
    }
}
