<?php
namespace app\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use common\models\Vehicle;

class VehicleData extends Vehicle
{
	public $vehicle_global_search;
	public $request_dat;
	public $pickup_dates;
	public $title_recieved_dates;
	public $deliver_dates;
	public $towed;
	public $title_recieved;
	public $container_number;
	public $condition;

	public function rules()
	{
		return array(
	array(
		array('id', 'check_number', 'customer_user_id', 'towing_request_id', 'created_by', 'updated_by'),
		'integer'
		),
	array(
		array('hat_number', 'condition', 'keys', 'customer_user_id', 'status', 'towed', 'deliver_dates', 'title_recieved_dates', 'pickup_dates', 'status', 'year', 'color', 'request_dat', 'model', 'vehicle_global_search', 'towed', 'make', 'vin', 'weight', 'value', 'license_number', 'towed_from', 'lot_number', 'location', 'created_at', 'updated_at', 'title_recieved', 'container_number', 'notes_status'),
		'safe'
		),
	array(
		array('towed_amount', 'storage_amount', 'additional_charges'),
		'number'
		),
	array(
		array('vehicle_is_deleted'),
		'boolean'
		)
	);
	}

	public function scenarios()
	{
		return yii\base\Model::scenarios();
	}

	public function globalSearch($params)
	{
	}

	public function vehicleList($customerId,$location_id=FALSE)
	{
		$query = Vehicle::find()->alias('v');
		$sort = Yii::$app->request->get('sort');

		if (empty($sort)) {
			$query->orderBy('v.id desc');
		}
		if($location_id)
		{
		    $this->location  = $location_id;
		}

		$query->joinWith(array('towingRequest as tr', 'customerUser as cu'));
		$query->leftJoin('vehicle_export as ve', 've.vehicle_id = v.id');
		$query->leftJoin('export as ex', 'ex.id = ve.export_id');
		$dataProvider->sort->attributes['request_dat'] = array(
    	'asc'  => array('tr.towing_request_date' => SORT_ASC),
    	'desc' => array('tr.towing_request_date' => SORT_DESC)
    	);
		$dataProvider = new ActiveDataProvider(array('query' => $query));
		$dataProvider->setSort(array(
    	'attributes' => array(
    		'title_recieved' => array(
    			'asc'     => array('towing_request.title_recieved' => SORT_ASC),
    			'desc'    => array('towing_request.title_recieved' => SORT_DESC),
    			'default' => SORT_ASC
    			)
    		)
    	));
	

		$removed_i_global_search = $this->vehicle_global_search;

		if (isset($this->vehicle_global_search[0])) {
			if ($this->vehicle_global_search[0] === 'I') {
				if (17 < strlen($this->vehicle_global_search)) {
					$removed_i_global_search = substr($this->vehicle_global_search, 1);
				}
			}
		}

	

		$user_id = $customerId;
		$Role = Yii::$app->authManager->getRolesByUser($user_id);
		
		$query->andFilterWhere(array('=', 'v.status', $this->status));
		$query->andFilterWhere(array('like', 'hat_number', $this->hat_number))
		->andFilterWhere(array('like', 'year', $this->year))
		->andFilterWhere(array('=', 'v.id', $this->id))
		->andFilterWhere(array('=', 'v.notes_status', $this->notes_status))
		->andFilterWhere(array('like', 'color', $this->color))
		->andFilterWhere(array('like', 'model', $this->model))
		->andFilterWhere(array('like', 'make', $this->make))
		->andFilterWhere(array('like', 'vin', $this->vin))
		->andFilterWhere(array('like', 'weight', $this->weight))
		->andFilterWhere(array('like', 'value', $this->value))
		->andFilterWhere(array('like', 'ex.container_number', $this->container_number))
		->andFilterWhere(array('like', 'license_number', $this->license_number))
		->andFilterWhere(array('like', 'towed_from', $this->towed_from))
		->andFilterWhere(array('like', 'lot_number', $this->lot_number))
		->andFilterWhere(array('=', 'tr.towing_request_date', $this->request_dat))
		->andFilterWhere(array('=', 'tr.deliver_date', $this->deliver_dates))
		->andFilterWhere(array('=', 'tr.title_recieved_date', $this->title_recieved_dates))
		->andFilterWhere(array('=', 'tr.pickup_date', $this->pickup_dates))
		->andFilterWhere(array('=', 'tr.condition', $this->condition))
		->andFilterWhere(array('=', 'v.customer_user_id', $this->customer_user_id))
		->andFilterWhere(array('=', 'v.location', $this->location))
		->orFilterWhere(array('like', 'ex.container_number', $this->vehicle_global_search))
		->orFilterWhere(array('like', 'model', $this->vehicle_global_search))
		->orFilterWhere(array('like', 'make', $this->vehicle_global_search))
		->orFilterWhere(array('like', 'vin', $removed_i_global_search))
		->orFilterWhere(array('like', 'lot_number', $this->vehicle_global_search))
		->orFilterWhere(array('like', 'ex.booking_number', $this->vehicle_global_search))
		->orFilterWhere(array('like', 'ex.ar_number', $this->vehicle_global_search))
		->orFilterWhere(array('like', 'cu.legacy_customer_id', $this->vehicle_global_search));
		
		
		/*************** dash board search start ********************/
		
		if(Yii::$app->request->get('customer-name'))
		{
			$query->orFilterWhere(array('like', 'cu.customer_name', Yii::$app->request->get('customer-name')));
			$query->orFilterWhere(array('like', 'cu.user_id', Yii::$app->request->get('customer-name')));
		}
		
		
		if(Yii::$app->request->get('vin'))
		{
		    $query->orFilterWhere(array('like', 'vin', Yii::$app->request->get('vin')));
		    $query->orFilterWhere(array('like', 'lot_number', Yii::$app->request->get('vin')));
		}
		
		if(Yii::$app->request->get('container'))
		{
		    $query->orFilterWhere(array('like', 'ex.container_number', Yii::$app->request->get('container')));
		}
		
		if(Yii::$app->request->get('buyer'))
		{
		    $query->orFilterWhere(array('like', 'cu.buyer_id', Yii::$app->request->get('buyer')));
		}
		
		/*************** dash board search End ********************/
		

	
		$query->andFilterWhere(array('=', 'v.customer_user_id',$customerId));
	
		
		if ($this->towed == '0') {
			$this->towed = null;
			$query->andWhere('tr.towed is null or tr.towed=0');
		}
		else {
			$query->andFilterWhere(array('=', 'tr.towed', $this->towed));
		}

		if ($this->title_recieved == '0') {
			$this->title_recieved = null;
			$query->andWhere('tr.title_recieved is null or tr.title_recieved=0');
		}
		else {
			$query->andFilterWhere(array('=', 'tr.title_recieved', $this->title_recieved));
		}

		if (isset($Role['admin_LA'])) {
			$query->andFilterWhere(array('=', 'v.location', '1'));
		}
		else if (isset($Role['admin_GA'])) {
			$query->andFilterWhere(array('=', 'v.location', '2'));
		}
		else if (isset($Role['admin_NY'])) {
			$query->andFilterWhere(array('=', 'v.location', '3'));
		}
		else if (isset($Role['admin_TX'])) {
			$query->andFilterWhere(array('=', 'v.location', '4'));
		}
		else if (isset($Role['admin_TX2'])) {
			$query->andFilterWhere(array('=', 'v.location', '5'));
		}
		else if (isset($Role['admin_NJ2'])) {
			$query->andFilterWhere(array('=', 'v.location', '6'));
		}

		$q2 = $query;
		$dataProvider->setTotalCount($q2->groupBy('v.id')->count());
	
		
		$provider = new ArrayDataProvider([
			'allModels' => $query->all(),
			
			'pagination' => [
				'pageSize' => 10,
			],
		]);
		// get the posts in the current page
		$result = $provider->getModels();
		
		return $result;
	}

	//get vehicle details
	public function vehicleDetails($id){
		if (($model = \common\models\Vehicle::findOne($id)) !== null) {
            return $model;
        }
        
	}

	//get vehicle shipping details
	public function vehicleShippingDetails($vin,$lot){
		$query = Vehicle::find()
		->joinWith('images');
		if($vin !='')
		{
			$query->orFilterWhere(array('=', 'vin', $vin));
		}
		if($lot !=''){
			$query->orFilterWhere(array('=', 'lot_number', $lot));
		}

		
		$provider = new ArrayDataProvider([
			'allModels' => $query->all(),
			
			'pagination' => [
				'pageSize' => 10,
			],
		]);

		return $provider->getModels();
		
	}
}


?>
