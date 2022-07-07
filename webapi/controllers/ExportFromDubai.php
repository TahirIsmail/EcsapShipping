<?php
namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use app\models\ExportData;
use app\components\WebApiController;
use common\models\Export;


/**
 * Site controller
 */
class ExportFromDubaiController extends WebApiController
{
    public $modelClass = 'app\models\VehicleData';
    
    public function actionIndex()
    {
        if(!$this->user['id']){
            return $this->missingParam();
        }
        $location = Yii::$app->request->get('location');
        $status = Yii::$app->request->get('status');
        
        $search_str = Yii::$app->request->get('search_str');
        
        $vehicleList = Vehicle::find()
            ->joinWith('country')
            ->joinWith('state')
            ->joinWith('city')
            ->joinWith('images')
            ->where(['status' => 10])
            ;

        $vehicleList = $vehicleList->groupBy('vehicle.id')->offset($this->offset)->limit($this->limit)->asArray()->all();
        
        $vehicleList = ['vehicleList' => $vehicleList];
        $vehicleList['other'] = ['vehicle_image' => str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['@web'],TRUE)).'uploads/'];
        $vehicleList['other']['page'] = $this->page;
        return $vehicleList;
        
    }
}
