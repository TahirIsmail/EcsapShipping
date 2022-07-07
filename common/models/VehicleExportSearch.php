<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\VehicleExport;

/**
 * VehicleExportSearch represents the model behind the search form of `common\models\VehicleExport`.
 */
class VehicleExportSearch extends VehicleExport
{
    public $export_vehicle_global_search;
    public $pod;
    public $loading_date;
    public $export_date;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vehicle_id', 'export_id'], 'integer'],
            [['export_vehicle_global_search','customer_user_id','notes_status','eta','pod','loading_date','export_date'], 'safe'],
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
        $query = VehicleExport::find()->alias('vx');
        $query->joinWith(['export as ex']);
        //$query->joinWith(['vehicle as v']);
        $query->leftJoin('vehicle as v','v.id = vx.vehicle_id');
            $sort = Yii::$app->request->get('sort');
            if(empty($sort)){
                $query->orderBy('ex.id desc');
            }
            $user_id = Yii::$app->user->getId();
            $Role =   Yii::$app->authManager->getRolesByUser($user_id);
            if(isset($Role['customer'])){
            $query->select('count(vehicle_id),export_id,vx.customer_user_id,max(vehicle_id) as vehicle_id');
            $query->groupBy(['export_id']);
            }else{
                $query->select('count(vehicle_id),export_id');
                $query->groupBy(['export_id']);
       // $query->distinct(['ar_number']);
            }
            //$query->andWhere("ex.id is not null");
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['eta']]
        ]);

        $this->load($params);
 
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            //return $dataProvider;
        }

        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'vehicle_id' => $this->vehicle_id,
//            'export_id' => $this->export_id,
//        ]);
        if($this->export_id){
            $query->andFilterWhere(['like', 'export_id', $this->export_id]);
        }
         
            //->andFilterWhere(['like', 'vx.id', $this->export_vehicle_global_search])
        if($this->notes_status){
            $query->andFilterWhere(['like', 'ex.notes_status', $this->notes_status]);
        }
        if($this->customer_user_id){
            $query->andFilterWhere(['=', 'vx.customer_user_id', $this->customer_user_id]);
        }
        
          //  ->andFilterWhere(['like', 'vx.customer_user_id', $this->customer_user_id])
          $query->orFilterWhere(['like', 'vx.id', $this->id])
            ->orFilterWhere(['like', 'ex.container_number', $this->export_vehicle_global_search])
            ->orFilterWhere(['like', 'ex.ar_number', $this->export_vehicle_global_search])
            ->orFilterWhere(['like', 'ex.booking_number', $this->export_vehicle_global_search])
            ->orFilterWhere(['like', 'ex.seal_number', $this->export_vehicle_global_search])
            ->orFilterWhere(['like', 'ex.broker_name', $this->export_vehicle_global_search])
            ->orFilterWhere(['like', 'ex.eta', $this->export_vehicle_global_search]);
        if($this->eta){
            $query->andFilterWhere(['like', 'ex.eta', $this->eta]); 
        }
        if($this->pod){
            $query->andFilterWhere(['like', 'v.location', $this->pod]); 
        }
        if($this->loading_date){
            $query->andFilterWhere(['like', 'ex.loading_date', $this->loading_date]); 
        }
        if($this->export_date){
            $query->andFilterWhere(['like', 'ex.export_date', $this->export_date]); 
        }
            // $user_id = Yii::$app->user->getId();
            // $Role =   Yii::$app->authManager->getRolesByUser($user_id);
             if(isset($Role['customer'])){
                $query->andFilterWhere(['=', 'v.customer_user_id', $user_id]);   
            }
            if(Yii::$app->user->can('super_admin')||Yii::$app->user->can('admin_view_only')){
                /*
                $query->orFilterWhere(['or',
                    ['like','v.location',1],
                    ['like','v.location',2],
                    ['like','v.location',3],
                    ['like','v.location',4]]);
                    */
                
            }

            if(Yii::$app->user->can('admin_LA') && !Yii::$app->user->can('super_admin') && !Yii::$app->user->can('admin_view_only')){$query->andFilterWhere(['like', 'v.location', 1]);}
            if(Yii::$app->user->can('admin_GA') && !Yii::$app->user->can('super_admin') && !Yii::$app->user->can('admin_view_only')){$query->andFilterWhere(['like', 'v.location', 2]);}
            if(Yii::$app->user->can('admin_NY') && !Yii::$app->user->can('super_admin') && !Yii::$app->user->can('admin_view_only')){$query->andFilterWhere(['like', 'v.location', 3]);}
            if(Yii::$app->user->can('admin_TX') && !Yii::$app->user->can('super_admin') && !Yii::$app->user->can('admin_view_only')){$query->andFilterWhere(['like', 'v.location', 4]);}
            if(Yii::$app->user->can('admin_TX2') && !Yii::$app->user->can('super_admin') && !Yii::$app->user->can('admin_view_only')){$query->andFilterWhere(['like', 'v.location', 5]);}
            if(Yii::$app->user->can('admin_NJ2') && !Yii::$app->user->can('super_admin') && !Yii::$app->user->can('admin_view_only')){$query->andFilterWhere(['like', 'v.location', 6]);}
            if(Yii::$app->user->can('admin_CA') && !Yii::$app->user->can('super_admin') && !Yii::$app->user->can('admin_view_only')){$query->andFilterWhere(['like', 'v.location', 7]);}

            if(Yii::$app->user->can('sub_admin')){
                $query->andFilterWhere(['in', 'v.location', ['1','2','3','4']]);
            }
         
//var_dump($dataProvider);
//exit();
        return $dataProvider;
    }
}
