<?php

namespace app\controllers;
use common\models\InvoiceSearch;
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
        $user_id = $this->user['id'];
        if (!$user_id) {
            return $this->missingParam();
        }

        $Role = Yii::$app->authManager->getRolesByUser($user_id);
        $query = \common\models\Invoice::find()->joinWith('export');
        if (isset($Role['customer'])) {
            $query->andFilterWhere(['=', 'invoice.customer_user_id', $user_id]);
        }

        $data = $query->asArray()->all();
        foreach ($data as $key => $row) {
            $data[$key]['container_number'] = !empty($row['export']['container_number']) ? $row['export']['container_number'] : '';
            $data[$key]['eta'] = !empty($row['export']['eta']) ? $row['export']['eta'] : '';
            $data[$key]['dxb_inv'] = !empty($row['upload_invoice']) ? 'https://customer.afgglobalshipping.com/uploads/' . $row['upload_invoice'] : '';
            $data[$key]['usa_inv'] = !empty($row['export']['export_invoice']) ? 'https://customer.afgglobalshipping.com/uploads/' . $row['export']['export_invoice'] : '';

            unset($data[$key]['export']);
        }


        return $data;
    }
    
    public function actionView()
    {
        $invoice_id = \Yii::$app->request->post('invoice_id');
        $data = [];
        
        $data = \common\models\Invoice::find()->joinWith('export')
        ->andWhere(array("=", "invoice.customer_user_id", $this->user['id']));
        if($invoice_id){
            $data->andWhere(array("=", "invoice.id", $invoice_id));
        }
        
        $data = $data->asArray()->one();
        if (!$data || empty($data)){
            $this->noResults();
        }
        else{
            $data['dxb_inv'] = !empty($row['upload_invoice']) ? 'https://customer.afgglobalshipping.com/uploads/' . $data['upload_invoice'] : '';
            $data['usa_inv'] = !empty($row['export']['export_invoice']) ? 'https://customer.afgglobalshipping.com/uploads/' . $data['export']['export_invoice'] : '';
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