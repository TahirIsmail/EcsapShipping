<?php
namespace app\controllers;

use common\models\Customer;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\Response;
use app\models\VehicleData;
use app\components\WebApiController;
use common\models\Vehicle;
use yii\helpers\Url;
use common\models\Export;
use common\models\Location;
use yii\helpers\ArrayHelper;
use common\models\VehicleExport;


/**
 * Site controller
 */
class GalaxyCarController extends WebApiController
{
    public $modelClass = 'common\models\Vehicle';
    
    public function actionIndex()
    {
        $customer_user_id = \Yii::$app->request->get('user_id');
        $vehicle = Vehicle::find()
        ->joinWith('country')
        ->joinWith('state')
        ->joinWith('city')
        ->joinWith('towingRequest')
//         ->joinWith('customerUser')
        ->joinWith('images')
//         ->joinWith(['vehicleConditions' => function(\yii\db\Query $query){$query->joinWith('condition');}])
//         ->joinWith(['vehicleExports' => function(\yii\db\Query $query){$query->joinWith(['export' => function(\yii\db\Query $query){$query->joinWith('invoice');}]);}])
        ->where([Vehicle::tableName().'.is_export_galaxy' => '0']);

        if($customer_user_id){
            $vehicle->where([Vehicle::tableName().'.customer_user_id' => $customer_user_id]);
        }
        $vehicle->asArray()->limit($this->limit)->offset($this->offset)->groupBy(Vehicle::tableName().'.id');

        $vehicle = $vehicle->all();
        
        $vehicle = ['vehicle' => $vehicle];
        $vehicle['other'] = [
            'vehicle_image' => str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['@web'],TRUE)).'uploads/',
            'export_image' => str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['@web'],TRUE)).'uploads/',
            'page' => $this->page,
            'limit' => $this->limit,
        ];
        
        if(isset($vehicle['vehicle']) && $vehicle['vehicle']){
            return $vehicle;
        }
        else
        {
            $this->invalidParam();
            return '';
        }
        
    }
    
    public function actionUpdateStatus()
    {
        $vin = Yii::$app->request->post('vin');
        
        if(!$vin){
            return $this->missingParam();
        }
        
        $vin = json_decode($vin,TRUE);
        
        $vehicle = Vehicle::updateAll(['is_export_galaxy' => '1'],['vin' => $vin]);
       
        if($vin){
            return ['vin' => $vin];
        }
        else
        {
            $this->invalidParam();
            return "";
        }
    }

    public function actionGetCustomer()
    {
        $query = Customer::find();

        $customer = $query->all();

        return $customer;
    }
}
