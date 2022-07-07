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


/**
 * Site controller
 */
class SearchController extends WebApiController
{
    public $modelClass = 'app\models\VehicleData';
    
    public function actionVehicle()
    {
        $location   = Yii::$app->request->get('location');
        $status     = Yii::$app->request->get('status');        
        $search_str = Yii::$app->request->get('search_str');
        
        $vehicleList = Vehicle::find()
        ->joinWith('towingRequest')
//        ->joinWith('state')
//        ->joinWith('city')
        ->joinWith('images')
        ->joinWith(['vehicleExport' => function(\yii\db\Query $q){$q->joinWith('export');}])
        ;

        if($location){
            $vehicleList->andWhere(['location' => $location]);
        }
        if($status){
            $vehicleList->andWhere(['status' => $status]);
        }
        if($search_str){
            $vehicleList->andFilterWhere(['OR', 
                ['like', Vehicle::tableName().'.make', $search_str],
                ['like', Vehicle::tableName().'.model', $search_str],
                ['like', Vehicle::tableName().'.lot_number', $search_str],
                ['like', Vehicle::tableName().'.vin', $search_str],
                ['like', Vehicle::tableName().'.container_number', $search_str],
            ]);
        }
        
        $vehicleList = $vehicleList->groupBy('vehicle.id')->orderBy(['vehicle.id' => SORT_DESC])->offset($this->offset)->limit($this->limit)->asArray()->all();
        
        $vehicleList = ['vehicleList' => $vehicleList];
        $vehicleList['other'] = ['vehicle_image' => str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['@web'],TRUE)).'uploads/'];
        $vehicleList['other']['page'] = $this->page;
        return $vehicleList;
        
    }
    
    public function actionVehicleView()
    {
        $id = Yii::$app->request->get('id');
        $vehicle = Vehicle::find()
//        ->joinWith('country')
//        ->joinWith('state')
//        ->joinWith('city')
//        ->joinWith('towingRequests')
        ->joinWith('customerUser')
        ->joinWith('images')        
        ->joinWith(['vehicleConditions' => function(\yii\db\Query $query){$query->joinWith('condition');}])
        ->joinWith(['vehicleExport' => function(\yii\db\Query $query){$query->joinWith(['export']);}])
        ->andWhere([Vehicle::tableName().'.id' => $id])
        ->groupBy(Vehicle::tableName().'.id')
        ->asArray()
        ->one();
        $vehicle = ['vehicle' => $vehicle];
        $vehicle['other'] = [
            'vehicle_image' => str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['@web'],TRUE)).'uploads/',
            'export_image' => str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['@web'],TRUE)).'uploads/'
            
        ];
        return $vehicle;        
    }
    
    public function actionGetVehicleByVin()
    {
        $vin = Yii::$app->request->get('vin');
        
        if(!$vin){
            return $this->missingParam();
        }
        $vehicle = Vehicle::find()
//        ->joinWith('country')
//        ->joinWith('state')
//        ->joinWith('city')
        ->joinWith('towingRequest')
        ->joinWith('customerUser')
        ->joinWith('images')
        ->joinWith(['vehicleConditions' => function(\yii\db\Query $query){$query->joinWith('condition');}])
        ->joinWith(['vehicleExport' => function(\yii\db\Query $query){$query->joinWith(['export' => function(\yii\db\Query $query){$query->joinWith('invoice');}]);}])
        ->where([Vehicle::tableName().'.vin' => $vin])
        ->asArray()
        ->one();
        $vehicle = ['vehicle' => $vehicle];
        $vehicle['other'] = [
            'vehicle_image' => str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['@web'],TRUE)).'uploads/',
            'export_image' => str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['@web'],TRUE)).'uploads/'
            
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
    
    /**
     * get vehicles list from customer id.
     *
     * @return string
     */
    public function actionExport()
    {
        $search_str = Yii::$app->request->get('search');
        $query = Export::find()
        ->joinWith('exportImages');
        
        if($search_str){
            $query->andFilterWhere(['OR',
                ['like', 'container_number', $search_str],
                ['like', 'booking_number', $search_str],
                ['like','ar_number',$search_str],
            ]);
        }
        $data = $query->asArray()->all();
        $export = ['export' => $data];
        $export['other'] = [
            'export_image' => str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['@web'],TRUE)).'uploads/'
        ];
        return ($export) ? $export: [];
    }
    public function actionExportView()
    {
        $export = [];
        $exportId= Yii::$app->request->get('id');
        if(!$exportId){
            $this->missingParam();
            return '';
        }
        $data = Export::find()
        ->joinWith('exportImages')
        ->joinWith(['vehicleExports' => function(\yii\db\Query $query){
            $query->joinWith(['vehicle'=> function(\yii\db\Query $query){
            }]);
        }])
        ->andWhere([Export::tableName().".id" => $exportId])
        ->asArray()
        ->one();
        
        /// if empty vehicl then
        if(!$data || empty($data))
        {
            $data = Export::find()
            ->joinWith('exportImages')
            ->where([Export::tableName().".customer_user_id" => $this->user['id']])
            ->andWhere([Export::tableName().".id" => $exportId])
            ->asArray()
            ->one();
            $data['vehicleExports'] = [];
        }
        
        $export = ['export' => $data];
        $export['other'] = [
            'export_image' => str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['@web'],TRUE)).'uploads/'
        ];
        
        return ($export) ? $export : [];            
    }
    
    public function actionLocation()
    {
        $datalist = [];
        $data = Location::find()
        ->where(['status' => 1])
        ->asArray()->all();
        $data = ArrayHelper::map($data, 'location_id', 'location_name');
        if($data){
            foreach ($data as $id => $name){
                $datalist[] = ['id' => $id,'name' => $name];
            }
        }
        return $datalist;
    }
    
    public function actionManifestDownload($id='')
    {
    	if(!$id){
    		$this->missingParam();
    		return '';
    	}
    
    	$exportDetail = \common\models\Export::findOne($id);
    	if($exportDetail)
    	{
    	$customerDetail = \common\models\Customer::findOne(array("user_id" => $exportDetail->customer_user_id));
    	$customerMail = \common\models\User::findOne(array("id" => $customerDetail->user_id));
    	$customerMail = $customerMail->email;
    	$f_name = "Manifest_" . $exportDetail->booking_number.".pdf";
    	$pdf = new \kartik\mpdf\Pdf(array("mode" => \kartik\mpdf\Pdf::MODE_UTF8, "filename" => $f_name, "content" => $this->renderPartial("@backend/views/export/manifest_pdf", array("model" => \common\models\Export::findOne($id))), "options" => array("title" => "Privacy Policy", "subject" => "Generating PDF via Galaxy WORLD WIDE SHIPPING"), "methods" => array("SetHeader" => array("Generated By: GALAXY WORLDWIDE||Generated On: " . date("r")), "SetFooter" => array("|Page {PAGENO}|"))));
    
    	$content = $pdf->content;
    	$filename = $customerDetail->user_id.$pdf->filename;
    	$path = $pdf->Output($content, \Yii::getAlias("@backend") . "/uploads/pdf/" . $filename, \Mpdf\Output\Destination::FILE);
    	//$filePath = \Yii::$app->mailer->compose()->attach(\Yii::getAlias("@backend") . "/uploads/pdf/" . $filename . ".pdf")->setFrom(array(\Yii::$app->params["supportEmail"] => "GALAXY WORLDWIDE Shipping"))->setTo($customerMail)->setSubject("MANIFEST")->setHtmlBody("Dear valued customer please see the attached Manifest.. <br<br<br>Thanks,<br> Galaxy Shipping</b>")->send();
    
    	$pdfPath  = str_replace(['backend/','backend','webapi/','webapi'], 'backend/', \yii\helpers\Url::to(['/'],TRUE)).'uploads/';
    	$pdfPath = $pdfPath.'pdf/'.$filename;
    	return $pdfPath;
    	}
    	$this->invalidParam();
    	return NULL;
    }
    
    public function actionBillofladngDownload($id, $mail = NULL)
    {
    	$exportDetail = \common\models\Export::findOne($id);
    	if($exportDetail)
    	{
        	$customerDetail = \common\models\Customer::findOne(array("user_id" => $exportDetail->customer_user_id));
        	$customerMail = \common\models\User::findOne(array("id" => $customerDetail->user_id));
        	$customerMail = $customerMail->email;
        	$customer_name = str_replace("/", "", $customerDetail->customer_name);
        	$f_name = $customerDetail->user_id."H_BL_" . $customer_name . "_" . $exportDetail->booking_number . ".pdf";
        	$f_name = str_replace(' ', '_', $f_name);
        	$pdf = new \kartik\mpdf\Pdf(array("mode" => \kartik\mpdf\Pdf::MODE_UTF8, "filename" => $f_name, "content" => $this->renderPartial("@backend/views/export/landing", array("model" => \common\models\Export::findOne($id))), "options" => array("title" => "Galaxy World Wide", "subject" => "Bill of Loading || Galaxy"), "methods" => array("SetHeader" => array("Generated By: GALAXY WORLDWIDE||Generated On: " . date("r")), "SetFooter" => array("|Page {PAGENO}|"))));
        	$filename = $pdf->filename;
        	$content = $pdf->content;
        	$path = $pdf->Output($content, \Yii::getAlias("@backend") . "/uploads/pdf/" . $filename, \Mpdf\Output\Destination::FILE);
        	//        $filePath = \Yii::$app->mailer->compose()->attach(\Yii::getAlias("@backend") . "/uploads/pdf/" . $filename . ".pdf")->setFrom(array(\Yii::$app->params["supportEmail"] => "GALAXY WORLDWIDE Shipping"))->setTo($customerMail)->setSubject("MANIFEST")->setHtmlBody("Dear valued customer please see the attached Manifest.. <br<br<br>Thanks,<br> Galaxy Shipping</b>")->send();
        
        	$pdfPath  = str_replace(['backend/','backend','webapi/','webapi'], 'backend/', \yii\helpers\Url::to(['/'],TRUE)).'uploads/';
        	$pdfPath = $pdfPath.'pdf/'.$filename;
    	   return $pdfPath;
    	}
    	else
    	{
    	    $this->invalidParam();
    	    return '';
    	}
    }
    
    public function actionError()
    {
        $this->notfound();
        return '';
    } 
    
    
    public function actionGetVehicleList()
    {
        $vin = Yii::$app->request->post('vin');
        
        if(!$vin){
            return $this->missingParam();
        }
        
        $vin = json_decode($vin,TRUE);
        
        $vehicle = Vehicle::find()
//        ->joinWith('country')
//        ->joinWith('state')
//        ->joinWith('city')
        ->joinWith('towingRequest')
        ->joinWith('customerUser')
        ->joinWith('images')
        ->joinWith(['vehicleConditions' => function(\yii\db\Query $query){$query->joinWith('condition');}])
        ->joinWith(['vehicleExport' => function(\yii\db\Query $query){$query->joinWith(['export' => function(\yii\db\Query $query){$query->joinWith('invoice');}]);}])
        ->where(['NOT IN',Vehicle::tableName().'.vin', $vin])
        ->asArray()
        ->limit($this->limit)
        ->offset($this->offset)
        ->groupBy(Vehicle::tableName().'.id')
        ->all();
        
        $vehicle = ['vehicle' => $vehicle];
        $vehicle['other'] = [
            'vehicle_image' => str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['@web'],TRUE)).'uploads/',
            'export_image' => str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['@web'],TRUE)).'uploads/'
            
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
    
    public function actionSetDevice()
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
                $device->user_id = (isset($this->user->user_id) && $this->user->user_id ) ? $this->user->user_id : '';
                $device->status = 1; 
                $device->created_at = time();
                $device->updated_at = time();
            }
            
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
}
