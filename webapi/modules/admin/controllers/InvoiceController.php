<?php

namespace app\modules\admin\controllers;
use Yii;
use app\components\WebApiController;
use common\models\InvoiceMaster;
use common\models\Images;
use common\models\Customer;
use common\models\JournalEntriesSearch;
use common\models\Invoice;
use common\models\JournalEntries;


class InvoiceController extends WebApiController
{
    public $modelClass = 'common\models\InvoiceMaster';
    
    public function actionIndex()
    {
        $status = \Yii::$app->request->get('status');
        $invoice_no = \Yii::$app->request->get('invoice_no');
        
        $data = InvoiceMaster::find()
        ->joinWith(['vehicle' => function(\yii\db\Query $query){$query->joinWith('towingRequest');}])
        ->joinWith(['customer' => function(\yii\db\Query $query){$query->joinWith('consignees');}])
        ->andWhere(array("=", "invoice_master.customer_id", $this->user['id']));
        if($status){
            $data->andWhere(array("=", "invoice_master.status", $status));
        }      
        if($invoice_no){
            $data->andWhere(array("like", "invoice_master.invoice_number", $invoice_no));
        }
        $data = $data->offset($this->offset)->limit($this->limit)->asArray()->all();
        if (!$data || empty($data)){
            $this->noResults();
        }
        else
        {
            $imgpath =  str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['/'],TRUE)).'uploads/';
            foreach ($data as $dataKey => $datainfo){
            	$data[$dataKey]['invoice_date'] = date('Y-m-d',$datainfo['invoice_date']);
            	$data[$dataKey]['due_date'] = date('Y-m-d',$datainfo['due_date']);
            	$data[$dataKey]['created_at'] = date('Y-m-d',$datainfo['created_at']);
            	$data[$dataKey]['updated_at'] = date('Y-m-d',$datainfo['updated_at']);
                $data[$dataKey]['vehicle']['image'] = Images::find()->select(["CONCAT('".$imgpath."' , images.name) as image"])->where(['vehicle_id' => $datainfo['vehicle']['id']])->asArray()->all();
            }
        }
        return $data;
    }
    
    public function actionView()
    {
        $invoice_id = \Yii::$app->request->post('invoice_id');
        $data = [];
        
        $data = InvoiceMaster::find()
        ->joinWith(['vehicle' => function(\yii\db\Query $query){$query->joinWith('towingRequest');}])
        ->joinWith(['customer' => function(\yii\db\Query $query){$query->joinWith('consignees');}])
        ->andWhere(array("=", "invoice_master.customer_id", $this->user['id']));
        if($invoice_id){
            $data->andWhere(array("=", "invoice_master.id", $invoice_id));
        }
        
        $data = $data->asArray()->one();
        if (!$data || empty($data)){
            $this->noResults();
        }
        else{
            $imgpath =  str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['/'],TRUE)).'uploads/';
            foreach ($data as $dataKey => $datainfo){
                $data['vehicle']['image'] = Images::find()->select(["CONCAT('".$imgpath."' , images.name) as image"])->where(['vehicle_id' => $data['vehicle']['id']])->asArray()->all();
            }
        }
        return $data;
    }

    public function actionPaymentHistory(){
        if(!$this->user['id']){
            return $this->missingParam();
        }
        $user_id = $this->user['id'];
        $customer = Customer::findOne(array("user_id" => $user_id));
        if($customer){
            $ledger_id = $customer['ledger_id'];
            
            $dataProviderObj = new JournalEntries();
            $dataProvider = $dataProviderObj->getPaymentHistoryByCus($customer['ledger_id'],$this->limit,$this->offset);
            
            $paymentHistoryList = [];
            foreach ($dataProvider as $paymentHistory)
            {
            	$paymentHistory['created_at'] = ($paymentHistory['created_at']) ? date('Y-m-d',$paymentHistory['created_at']) : '';
            	$paymentHistory['updated_at'] = ($paymentHistory['updated_at']) ? date('Y-m-d',$paymentHistory['updated_at']) : '';
            	$paymentHistory['voucher_no'] = 'GWSV_'.$paymentHistory['id'];
            	
            	$payment_method = (isset($paymentHistory['payment_method']) && $paymentHistory['payment_method']) ? $paymentHistory['payment_method'] : '';
            	$payment_method = ($payment_method == '1') ? 'Bank' : $payment_method;
            	$payment_method = ($payment_method == '2') ? 'Cash' : $payment_method;
            	$paymentHistory['payment_method'] = $payment_method;

            	$paymentHistoryList[] = $paymentHistory;
            }
            
//             $searchModel = new JournalEntriesSearch();
//             $params = Yii::$app->request->queryParams;
//             if(!isset(Yii::$app->request->queryParams['JournalEntriesSearch'])){
//                 $params['JournalEntriesSearch'] = array(
//                         'debit_account' => $ledger_id,
//                         'credit_account' => $ledger_id
//                 );
//             }
//             $dataProvider = $searchModel->searchAPI($params);
//             $paymentHistoryList = [];
//             foreach ($dataProvider as $paymentHistory){
//             	$paymentHistory['created_at'] = ($paymentHistory['created_at']) ? date('Y-m-d',$paymentHistory['created_at']) : '';
//             	$paymentHistory['updated_at'] = ($paymentHistory['updated_at']) ? date('Y-m-d',$paymentHistory['updated_at']) : '';
            	
//             	$paymentHistory['voucher_no'] = 'GWSV_'.$paymentHistory['id'];
            	
            	
//             	$paymentHistoryList[] = $paymentHistory;
//             }

            $responce = [];
            $responce['balance'] = $dataProviderObj->getLedgerBalance($ledger_id);
            $responce['history'] = $paymentHistoryList;
            return $responce;
        }
    }
    
    
    public function actionDownload($id)
    {
        
        if(!$id){
            return $this->missingParam();
        }
        
        $model = InvoiceMaster::findOne($id);
        if($model)
        {
            
            $f_name = $model->customer_id.$model->invoice_number.".pdf";
            $f_name = str_replace(' ', '_', $f_name);
            
            $pdf = new \kartik\mpdf\Pdf(array("mode" => \kartik\mpdf\Pdf::MODE_UTF8, "filename" => $f_name, "content" => $this->renderPartial("@backend/views/invoice-master/invoice_pdf", array("model" => $model)), "options" => array("title" => "Privacy Policy", "subject" => "Generating PDF via Galaxy WORLD WIDE SHIPPING"), "methods" => array("SetHeader" => array("Generated By: GALAXY WORLDWIDE||Generated On: " . date("r")), "SetFooter" => array("|Page {PAGENO}|"))));
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
}

?>