<?php
namespace app\controllers;

use Yii;
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
use common\models\UserDevice;
use common\models\FCM;


/**
 * Site controller
 */
class DeviceController extends WebApiController
{
    public $modelClass = 'app\models\UserDevice';
    
    public function actionSet()
    {
        $udid = Yii::$app->request->post('udid');
        $device_id = Yii::$app->request->post('devide_id');
        if($udid || $device_id)
        {
            $device = UserDevice::find()->where(['udid' => $udid])->one();
            if($device && !empty($device)){
                $device->updated_at = time();
            }        
            else{
                $device = new UserDevice();
                $device->status = 1; 
                $device->created_at = time();
            }
            
            $device->user_id = (isset($this->user['id']) && $this->user['id']) ? $this->user['id'] : '';
            $device->updated_at = time();            
            $device->device_id = $device_id;
            $device->udid = $udid;    
            $device->save();
            return "1";
            
        }else
        {
            $this->missingParam();
            return '';
        }
    }
    
    public function actionSend()
    {

        $customer   = Yii::$app->request->post('customer');
        $text       = Yii::$app->request->post('text') ? Yii::$app->request->post('text') : 'test text';
        $data       = ['test' => 'test'];


        return FCM::Send($customer,$text,$data);

        /*

        $fcm_url     = "https://fcm.googleapis.com/fcm/send";
        $server_key  = 'AIzaSyCfY9U7XIiiRkyyXu9noDMeP9cQ1fFoE74';
        $customer   = Yii::$app->request->post('customer');
        $text       = Yii::$app->request->post('text');
        $data       = ['test' => 'test'];
        
        //return FCM::Send($customer,$text,$data);
        
        $rtnVal = 1;
        if($customer && $text)
        {
            $headers = ['Content-Type:application/json', 'Authorization:key='.$server_key];
            $toList = UserDevice::find()->where(['user_id' => $customer])->all();
            $msgData = [];
            
            if($toList && !empty($toList))
            {
                echo "<pre>";print_r($toList);exit;
                foreach ($toList as $device)
                {
                    $msgData["to"] = $device['token'];
                    $msgData["notification"]["body"] = $text;
    //                 $msgData["notification"]["title"] = "TITLE";
    //                 $msgData["notification"]["icon"] = "ICON";
                    $msgData["data"] = $data;
                    
                    $data = json_encode($msgData);
                    
                    //CURL request to route notification to FCM connection server (provided by Google)
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $fcm_url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    $result = curl_exec($ch);
                    
                    if ($result === FALSE) { $rtnVal = 0; }
                    curl_close($ch);
                }
            }
        }
        else
        {
            $rtnVal = 0;
        }
        
        return $rtnVal;

        */
    }
}
