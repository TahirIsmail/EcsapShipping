<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use app\models\ExportData;
use app\components\WebApiController;
use common\models\Export;
use common\models\VehicleExport;
use common\models\Vehicle;


/**
 * Site controller
 */
class ExportController extends WebApiController
{
    public $modelClass = 'app\models\ExportData';
    
    /**
     * get vehicles list from customer id.
     *
     * @return string
     */
    public function actionIndex()
    {
        $search_str = Yii::$app->request->get('search');
        
        $query = Export::find()
        ->joinWith('exportImages')
        ->joinWith('port')
        ->joinWith('portOfDischarge discharge')
        ->joinWith(["vehicleExports as vx" => function(\yii\db\Query $query){$query->joinWith('vehicle');}]);

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
    
    
    /**
     * get export details form vehicle id
     *
     * @return string
     */
    public function actionView()
    {
        $exportId= Yii::$app->request->get('exportId');
        if(!$exportId){
            $this->missingParam();
            return '';
        }
        
        $data = Export::find()
        ->joinWith('exportImages')
        ->joinWith('port')
        ->joinWith('portOfDischarge discharge')
        ->andWhere([Export::tableName().".id" => $exportId])
        ->asArray()
        ->one();
        
        $data['vehicle'] = Vehicle::find()
        ->joinWith("vehicleExports as vx")
        ->andWhere(['vx.export_id' => $exportId])->asArray()->all();
        
        /// if empty vehicl then 
        if(!$data || empty($data))
        {
            $data = Export::find()
            ->joinWith('exportImages')
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
    
    /**
     * get vehicles list from customer id.
     *
     * @return string
     */
    public function actionTracking($search='')
    {
        $query = Export::find();
        $query->andWhere(['OR',
            ['like','booking_number',$search],
            ['like','container_number',$search],
            ['like','ar_number',$search],
        ]);
        $data = $query->asArray()->all();
        $export = ['export' => $data];
        $export['other'] = [
            'export_image' => str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['@web'],TRUE)).'uploads/'
        ];
        return ($export) ? $export: [];
    } 
    
    
    public function actionManifestDownload($id='')
    {
        if(!$id){
            $this->missingParam();
            return '';
        }
        
        $exportDetail = \common\models\Export::findOne($id);
        $customerDetail = \common\models\Customer::findOne(array("user_id" => $exportDetail->customer_user_id));
        $customerMail = \common\models\User::findOne(array("id" => $customerDetail->user_id));
        $customerMail = $customerMail->email;
        
        $f_name = "Manifest_" . $exportDetail->booking_number.".pdf";
        $f_name = str_replace(' ', '', $f_name);
        $content = $this->renderPartial("@backend/views/export/manifest_pdf", array("model" => \common\models\Export::findOne($id)));
        $pdf = new \kartik\mpdf\Pdf(array("mode" => \kartik\mpdf\Pdf::MODE_UTF8, "filename" => $f_name, "content" => $content, "options" => array("title" => "Privacy Policy", "subject" => "Generating PDF via Galaxy WORLD WIDE SHIPPING"), "methods" => array("SetHeader" => array("Generated By: GALAXY WORLDWIDE||Generated On: " . date("r")), "SetFooter" => array("|Page {PAGENO}|"))));
        
        $content = $pdf->content;
        
        $filename = $customerDetail->user_id.$pdf->filename;
        $path = $pdf->Output($content, \Yii::getAlias("@backend") . "/uploads/pdf/" . $filename, \Mpdf\Output\Destination::FILE);
        $filePath = \Yii::$app->mailer->compose()->attach(\Yii::getAlias("@backend") . "/uploads/pdf/" . $filename)->setFrom(array(\Yii::$app->params["supportEmail"] => "GALAXY WORLDWIDE Shipping"))->setTo($customerMail)->setSubject("MANIFEST")->setHtmlBody("Dear valued customer please see the attached Manifest.. <br<br<br>Thanks,<br> Galaxy Shipping</b>")->send();
        
        $pdfPath  = str_replace(['backend/','backend','webapi/','webapi'], 'backend/', \yii\helpers\Url::to(['/'],TRUE)).'uploads/';
        $pdfPath = $pdfPath.'pdf/'.$filename;
        return $pdfPath;
    }
    
    public function actionBillofladngDownload($id, $mail = NULL)
    {
        $exportDetail = \common\models\Export::findOne($id);
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
    
    /**
     * get vehicles list from customer id.
     *
     * @return string
     */
    public function actionExportlist()
    {
        $searchModel =  new ExportData();
        $customerId= Yii::$app->request->get('customerId');
        if(trim($customerId) == ''){
            return ['name' => 'Params Required Error',
                    'message' => "Customer Id is required",
                    'code' => '0',
                    'status' => '404',
                    'data' => []];
         }
        $data = $searchModel->exportList($customerId);
        if($data){
            return ['name' => 'Customer Export Details',
                    'message' => 'Success',
                    'code' => '1',
                    'status' => '200',
                    'data' => ['export_details' => $data]];
        }else{
            return ['name' => 'Details Not Found',
                    'message' => "Customer Export Details Not Found'",
                    'code' => '0',
                    'status' => '404',
                    'data' => []];
        }    
    } 


     /**
     * get export details form vehicle id
     *
     * @return string
     */
    public function actionExportDetails()
    {
        $searchModel =  new ExportData();
        $exportId= Yii::$app->request->get('exportId');
        if(trim($exportId) == ''){
            return ['name' => 'Params Required Error',
                    'message' => "Export Id is required",
                    'code' => '0',
                    'status' => '404',
                    'data' => []];
         }
        $data = $searchModel->exportDetails($exportId);
        if($data){
            return ['name' => 'Customer Export Details',
                    'message' => 'Success',
                    'code' => '1',
                    'status' => '200',
                    'data' => ['export_details' => $data]];
        }else{
            return ['name' => 'Details Not Found',
                    'message' => "Customer Export Details Not Found'",
                    'code' => '0',
                    'status' => '404',
                    'data' => []];
        }    
    }


    public function actionAddExportImage()
    {
        $images = new \common\models\ExportImages();
        $export_id = Yii::$app->request->post('export_id');

        if($export_id)
        {
            $model = Export::findOne($export_id);

            if($_FILES['img']['name'] &&  is_array($_FILES['img']['name']))
            {
                $_FILES['ExportImages']['name']['name'] = $_FILES['img']['name'];
                $_FILES['ExportImages']['type']['name'] = $_FILES['img']['type'];
                $_FILES['ExportImages']['tmp_name']['name'] = $_FILES['img']['tmp_name'];
                $_FILES['ExportImages']['error']['name'] = $_FILES['img']['error'];
                $_FILES['ExportImages']['size']['name'] = $_FILES['img']['size'];

            }
            else
            {
                $_FILES['ExportImages']['name']['name']['0'] = $_FILES['img']['name'];
                $_FILES['ExportImages']['type']['name']['0'] = $_FILES['img']['type'];
                $_FILES['ExportImages']['tmp_name']['name']['0'] = $_FILES['img']['tmp_name'];
                $_FILES['ExportImages']['error']['name']['0'] = $_FILES['img']['error'];
                $_FILES['ExportImages']['size']['name']['0'] = $_FILES['img']['size'];
            }


            if($model){
                $photos = \yii\web\UploadedFile::getInstances($images, "name");
                if ($photos !== null) {
                    $save_images = \common\models\ExportImages::save_container_images($model->id, $photos);
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
