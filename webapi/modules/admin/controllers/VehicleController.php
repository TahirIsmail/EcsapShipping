<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use app\models\VehicleData;
use app\components\WebApiController;
use common\models\Vehicle;
use yii\helpers\Url;


/**
 * Site controller
 */
class VehicleController extends WebApiController
{
    public $modelClass = 'app\models\VehicleData';
    
    public function actionIndex()
    {
        $location   = Yii::$app->request->get('location');
        $status     = Yii::$app->request->get('status');        
        $search_str = Yii::$app->request->get('search_str');
        
        $vehicleList = Vehicle::find()
        ->joinWith('country')
        ->joinWith('state')
        ->joinWith('city')
        ->joinWith('images');

        if($location){
            $vehicleList->andWhere(['location' => $location]);
        }
        if($status){
            $vehicleList->andWhere(['status' => $status]);
        }

        if($search_str){
            $vehicleList->andFilterWhere(['OR', 
                ['like', 'make', $search_str],
                ['like', 'model', $search_str],
                ['like', 'lot_number', $search_str],
                ['like', 'vin', $search_str],
                ['like', 'container_number', $search_str],                
            ]);
        }
        
        $vehicleList = $vehicleList->groupBy('vehicle.id')->orderBy(['vehicle.id' => SORT_DESC])->offset($this->offset)->limit($this->limit)->asArray()->all();
        $vehicleList = ['vehicleList' => $vehicleList];
        $vehicleList['other'] = ['vehicle_image' => str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['@web'],TRUE)).'uploads/'];
        $vehicleList['other']['page'] = $this->page;
        return $vehicleList;
        
    }
    
    public function actionView()
    {
        $id = Yii::$app->request->get('id');

        $vehicle = Vehicle::find()
        ->joinWith('country')
        ->joinWith('state')
        ->joinWith('city')
        ->joinWith('towingRequest')
        ->joinWith('customerUser')
        ->joinWith('images')        
        ->joinWith(['vehicleConditions' => function(\yii\db\Query $query){$query->joinWith('condition');}])
        ->joinWith(['vehicleExports' => function(\yii\db\Query $query){$query->joinWith(['export' => function(\yii\db\Query $query){$query->joinWith('invoice');}]);}])
        ->joinWith('invoice')
        ->asArray()
        ->one();
        $vehicle = ['vehicle' => $vehicle];
        $vehicle['other'] = [
            'vehicle_image' => str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['@web'],TRUE)).'uploads/',
            'export_image' => str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['@web'],TRUE)).'uploads/'
            
        ];
        return $vehicle;
        
    }
    
    /**
     * get vehicles list from customer id.
     *
     * @return string
     */
    public function actionVehiclelist()
    {
        $searchModel =  new VehicleData();
        $customerId= Yii::$app->request->get('customerId');
        $location_id = Yii::$app->request->get('location');
        
        if(trim($customerId) == ''){
            return ['name' => 'Params Required Error',
                    'message' => "Customer Id is required",
                    'code' => '0',
                    'status' => '404',
                    'data' => []];
         }
         $data = $searchModel->vehicleList($customerId,$location_id);
        if($data){
            return ['name' => 'Vehicle List Details',
                    'message' => 'Success',
                    'code' => '1',
                    'status' => '200',
                    'data' => ['vehicle_details' => $data]];
        }else{
            return ['name' => 'Details Not Found',
                    'message' => "Vehicle Details Not Found'",
                    'code' => '0',
                    'status' => '404',
                    'data' => []];
        }    
    } 


     /**
     * get vehicles details form vehicle id
     *
     * @return string
     */
    public function actionVehicleDetails()
    {
        $searchModel =  new VehicleData();
        $vehicleId= Yii::$app->request->get('vehicleId');
        if(trim($vehicleId) == ''){
            return ['name' => 'Params Required Error',
                    'message' => "Vehicle Id is required",
                    'code' => '0',
                    'status' => '404',
                    'data' => []];
         }
        $data = $searchModel->vehicleDetails($vehicleId);
        if($data){
            return ['name' => 'Vehicle List Details',
                    'message' => 'Success',
                    'code' => '1',
                    'status' => '200',
                    'data' => ['vehicle_details' => $data]];
        }else{
            return ['name' => 'Details Not Found',
                    'message' => "Vehicle Details Not Found'",
                    'code' => '0',
                    'status' => '404',
                    'data' => []];
        }    
    } 
        

     /**
     * get vehicles shipping  details form lot number or vin number
     *
     * @return string
     */
    public function actionVehicleShippingDetails()
    {
        $searchModel =  new VehicleData();
        $vin= Yii::$app->request->post('vin');
        $lot= Yii::$app->request->post('lot');
        if(trim($vin) == '' && trim($lot) == ''){
            return ['name' => 'Params Required Error',
                'message' => "VIN or LOT number is required",
                'code' => '0',
                'status' => '404',
                'data' => []];
        }
        
        $data = $searchModel->vehicleShippingDetails($vin,$lot);
        if($data){
            return ['name' => 'Vehicle Shipping Details',
                    'message' => 'Success',
                    'code' => '1',
                    'status' => '200',
                    'data' => ['vehicle_details' => $data]];
        }else{
            return ['name' => 'Details Not Found',
                    'message' => "Vehicle Shipping Details Not Found'",
                    'code' => '0',
                    'status' => '404',
                    'data' => []];
        }        
    }
    
    public function actionGetVehicleCounter()
    {
    	$all_vehicle = "";
    	$all_vehicle = \common\models\Vehicle::get_vehicle_report(null);

    	return $all_vehicle;
    }

    public function actionAddVehicleImage()
    {
        $images = new \common\models\Images();
        $vehicle_id = Yii::$app->request->post('vehicle_id');

        if($vehicle_id)
        {
            $model = Vehicle::findOne($vehicle_id);

            if($_FILES['img']['name'] &&  is_array($_FILES['img']['name']))
            {
                $_FILES['Images']['name']['name'] = $_FILES['img']['name'];
                $_FILES['Images']['type']['name'] = $_FILES['img']['type'];
                $_FILES['Images']['tmp_name']['name'] = $_FILES['img']['tmp_name'];
                $_FILES['Images']['error']['name'] = $_FILES['img']['error'];
                $_FILES['Images']['size']['name'] = $_FILES['img']['size'];

            }
            else
            {
                $_FILES['Images']['name']['name']['0'] = $_FILES['img']['name'];
                $_FILES['Images']['type']['name']['0'] = $_FILES['img']['type'];
                $_FILES['Images']['tmp_name']['name']['0'] = $_FILES['img']['tmp_name'];
                $_FILES['Images']['error']['name']['0'] = $_FILES['img']['error'];
                $_FILES['Images']['size']['name']['0'] = $_FILES['img']['size'];
            }


            if($model){
                $photos = \yii\web\UploadedFile::getInstances($images, "name");
                if ($photos !== null) {
                    $save_images = \common\models\Images::save_container_images_with_watermark($model->id, $photos);
                    return 1;
                }
            }
            else{
                $this->invalidParam();
            }
        }
        else{
            $this->missingParam();
        }
        return  false;
    }

}
