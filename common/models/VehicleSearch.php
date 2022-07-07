<?php

namespace common\models;

use common\models\Vehicle;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VehicleSearch represents the model behind the search form of `common\models\Vehicle`.
 */
class VehicleSearch extends Vehicle
{
    public $vehicle_global_search;
    public $request_dat;
    public $pickup_dates;
    public $title_recieved_dates;
    public $deliver_date;
    public $towed;
    public $container_number;
    public $condition;
    public $export_date;
    public $booking_number;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'check_number', 'customer_user_id', 'towing_request_id', 'created_by', 'updated_by'], 'integer'],
            [['hat_number', 'condition', 'keys', 'customer_user_id', 'status', 'towed', 'deliver_date', 'title_recieved_dates', 'pickup_dates', 'status', 'year', 'color', 'request_dat', 'model', 'vehicle_global_search', 'vehicle_type', 'towed', 'make', 'vin', 'weight', 'value', 'license_number', 'towed_from', 'lot_number', 'location', 'created_at', 'updated_at', 'title_recieved', 'container_number', 'manifest_date', 'notes_status', 'title_type', 'export_date', 'booking_number'], 'safe'],
            [['towed_amount', 'storage_amount', 'additional_charges'], 'number'],
            [['vehicle_is_deleted'], 'boolean'],
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
    public function globalSearch($params)
    {

    }

    public function search($params, $limitPerPage = false)
    {
        $query = Vehicle::find()->alias('v');
        // $query->orderBy('v.id desc');
        $sort = Yii::$app->request->get('sort');
        if (empty($sort)) {
            $query->orderBy('v.id desc');
        }
        $query->joinWith(['towingRequest as tr', 'customerUser as cu']);
        $query->leftJoin('vehicle_export as ve', 've.vehicle_id = v.id');
        $query->leftJoin('export as ex', 'ex.id = ve.export_id');

       

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if ($limitPerPage) {
            $dataProvider->setPagination([
                'pageSize' => $limitPerPage,
            ]);
        }
        $dataProvider->setSort([
            'attributes' => [

                'title_recieved' => [
                    'asc' => ['towing_request.title_recieved' => SORT_ASC],
                    'desc' => ['towing_request.title_recieved' => SORT_DESC],

                    'default' => SORT_ASC
                ],

            ]
        ]);
        $dataProvider->sort->attributes['request_dat'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['tr.towing_request_date' => SORT_ASC],
            'desc' => ['tr.towing_request_date' => SORT_DESC],
        ];

        $this->load($params);
        if (isset($this->vin[0])) {
            if ($this->vin[0] === 'I') {
                $this->vin = substr($this->vin, 1);
            }
        }
        $removed_i_global_search = trim($this->vehicle_global_search);
        if (isset($this->vehicle_global_search[0])) {
            if ($this->vehicle_global_search[0] === 'I') {
                if (strlen($this->vehicle_global_search) > 17) {
                    $removed_i_global_search = substr($this->vehicle_global_search, 1);
                }
            }
        }
        //$this->vehicle_global_search = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $this->vehicle_global_search);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            // return $dataProvider;
        }
        //var_dump($this->status);
        //exit();
        $user_id = Yii::$app->user->getId();
        $Role = Yii::$app->authManager->getRolesByUser($user_id);

        if ($this->status == '6') {
            $query->andFilterWhere(['<=', 'ex.eta', date("Y-m-d")])
                ->andWhere(['=', 'v.status', 4])
                ->andWhere('ve.vehicle_export_is_deleted != 1');
        } else if ($this->status == '4') {
            $query->andFilterWhere(['>', 'ex.eta', date("Y-m-d")])
                ->andWhere(['=', 'v.status', 4])
                ->andWhere('ve.vehicle_export_is_deleted != 1');
        } else {
            $query->andFilterWhere(['=', 'v.status', $this->status]);
        }
        $query->andFilterWhere(['like', 'hat_number', $this->hat_number])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['=', 'v.id', $this->id])
            ->andFilterWhere(['=', 'v.notes_status', $this->notes_status])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'make', $this->make])
            ->andFilterWhere(['like', 'vin', $this->vin])
            //->andFilterWhere(['=', 'keys', $this->keys])
            ->andFilterWhere(['like', 'weight', $this->weight])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'ex.container_number', $this->container_number])
            ->andFilterWhere(['like', 'ex.created_at', $this->manifest_date])
            ->andFilterWhere(['like', 'v.created_at', $this->created_at])
            ->andFilterWhere(['like', 'license_number', $this->license_number])
            ->andFilterWhere(['like', 'towed_from', $this->towed_from])
            ->andFilterWhere(['like', 'lot_number', $this->lot_number])
            ->andFilterWhere(['=', 'tr.towing_request_date', $this->request_dat])
            ->andFilterWhere(['=', 'tr.deliver_date', $this->deliver_date])
            ->andFilterWhere(['=', 'tr.title_recieved_date', $this->title_recieved_dates])
            ->andFilterWhere(['=', 'tr.pickup_date', $this->pickup_dates])
            ->andFilterWhere(['=', 'tr.condition', $this->condition])
            ->andFilterWhere(['=', 'tr.title_type', $this->title_type])
            ->andFilterWhere(['=', 'v.customer_user_id', $this->customer_user_id])
            ->andFilterWhere(['=', 'v.location', $this->location])
            //->orFilterWhere(['like', 'cu.company_name', $this->vehicle_global_search])
            //->orFilterWhere(['like', 'color', $this->vehicle_global_search])
            ->orFilterWhere(['like', 'ex.container_number', $this->vehicle_global_search])
            ->orFilterWhere(['like', 'ex.export_date', $this->vehicle_global_search])
            ->orFilterWhere(['like', 'model', $this->vehicle_global_search])
            ->orFilterWhere(['like', 'make', $this->vehicle_global_search])
            ->orFilterWhere(['like', 'vin', $removed_i_global_search])
            ->orFilterWhere(['like', 'lot_number', $removed_i_global_search])
            //->orFilterWhere(['like', 'lot_number', $this->vehicle_global_search])
            ->orFilterWhere(['like', 'ex.booking_number', $this->vehicle_global_search])
            ->orFilterWhere(['like', 'ex.ar_number', $this->vehicle_global_search])
            ->orFilterWhere(['like', 'cu.legacy_customer_id', $this->vehicle_global_search]);

        if (isset($Role['customer'])) {
            $query->andFilterWhere(['=', 'v.customer_user_id', $user_id]);
        } else {
            $query->andFilterWhere(['=', 'v.customer_user_id', $this->customer_user_id]);
        }

        if ($this->towed == '0') {
            $this->towed = null;
            $query->andWhere('tr.towed is null or tr.towed=0');
        } else {
            $query->andFilterWhere(['=', 'tr.towed', $this->towed]);
        }
        if (!empty($this->keys)) {
            $query->andFilterWhere(['=', 'v.keys', $this->keys]);
        }
        if ($this->keys == '0') {
            $query->andWhere('v.keys is null or v.keys=0');
        }

        if (!empty($this->export_date)) {
            $query->andFilterWhere(['=', 'ex.export_date', $this->export_date]);
        }

        if ($this->title_recieved == '0') {
            $this->title_recieved = null;
            $query->andWhere("tr.title_recieved is null or tr.title_recieved=0");
        } else {
            $query->andFilterWhere(['=', 'tr.title_recieved', $this->title_recieved]);
        }
        if (isset($Role['admin_LA'])) {
            $query->andFilterWhere(['=', 'v.location', '1']);
        } elseif (isset($Role['admin_GA'])) {
            $query->andFilterWhere(['=', 'v.location', '2']);
        } elseif (isset($Role['admin_NY'])) {
            $query->andFilterWhere(['=', 'v.location', '3']);
        } elseif (isset($Role['admin_TX'])) {
            $query->andFilterWhere(['=', 'v.location', '4']);
        } elseif (isset($Role['admin_TX2'])) {
            $query->andFilterWhere(['=', 'v.location', '5']);
        } elseif (isset($Role['admin_NJ2'])) {
            $query->andFilterWhere(['=', 'v.location', '6']);
        } elseif (isset($Role['admin_CA'])) {
            $query->andFilterWhere(['=', 'v.location', '7']);
        } elseif (isset($Role['sub_admin'])) {
            $query->andFilterWhere(['in', 'v.location', ['1', '2', '3', '4']]);
        }
        $q2 = $query;

//        echo $query->createCommand()->getRawSql(); die;

        $dataProvider->setTotalCount($q2->groupBy('v.id')->count());
        return $dataProvider;
    }
}
