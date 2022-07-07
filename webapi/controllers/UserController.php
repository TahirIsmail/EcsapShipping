<?php
namespace app\controllers;

use common\models\InvoiceSearch;
use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use common\models\LoginForm;
use common\models\User;
use common\models\Customer;
use common\models\UserDevice;
use app\components\WebApiController;

/**
 * Site controller
 */
class UserController extends WebApiController
{
    public $modelClass = 'common\models\User';
    
    /**
     * Common actions accross across webapi
     */
    public function actions()
    {
        return [];
    }
    /**
     * @return string
     */
    public function actionIndex()
    {
        if(!empty($this->user)) {
            $searchModel = new InvoiceSearch();
            $user_id = $this->user['id'];
            $customer = Customer::findOne(array("user_id" => $user_id));
            $this->user['customer_name'] = isset($customer['customer_name']) ? $customer['customer_name'] : '';
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andFilterWhere(['=', 'invoice.customer_user_id', $user_id]);
            $this->user['invoice'] = [
                'total_amount' => number_format(\common\models\Invoice::getTotal($dataProvider->models, 'total_amount'), 2, '.', ','),
                'adjustment_damaged' => number_format(\common\models\Invoice::getTotal($dataProvider->models, 'adjustment_damaged'), 2, '.', ','),
                'adjustment_storage' => number_format(\common\models\Invoice::getTotal($dataProvider->models, 'adjustment_storage'), 2, '.', ','),
                'adjustment_discount' => number_format(\common\models\Invoice::getTotal($dataProvider->models, 'adjustment_discount'), 2, '.', ','),
                'adjustment_other' => number_format(\common\models\Invoice::getTotal($dataProvider->models, 'adjustment_other'), 2, '.', ','),
                'paid_amount' => number_format(\common\models\Invoice::getTotal($dataProvider->models, 'paid_amount'), 2, '.', ','),
                'balance' => number_format(\common\models\Invoice::getTotalremaning($dataProvider->models), 2, '.', ','),
            ];

            return $this->user;
        }

        $this->notfound();
        $this->message= 'user not found , please enter valid email id';

        return  '';
    }
    
    public function actionForgotPassword()
    {
        /// send email
        
        $email = \Yii::$app->request->post('email');
        $user = User::find()->where(['email' => $email])->asArray()->one();
        
        if ($user && !empty($user))
        {
            $token = rand(11111,99999);
            User::updateAll(['password_reset_token' => $token],['id' => $user['id'],'email' => $user['email']]);
            
            try{
                Yii::$app->mailer->compose(['html' => 'forgot_pass', 'text' => 'forgot_pass-text'], ['user' => $user, 'token' => $token])
                ->setReplyTo('digi9780@gmail.com')
                ->setFrom('digi9780@gmail.com')
                ->setTo($user['email'])
                ->setSubject('Password Reset Token ')
                ->send();
            }
            catch (\ErrorException $exception){
                echo $exception->getMessage();
            }
            
            return $token;            
        }
        
        $this->notfound();
        $this->message= 'user not found , please enter valid email id';
        return '';
        
    }
    
    public function actionUpdatePassword()
    {
        $token      = Yii::$app->request->post('token');
        $password   = Yii::$app->request->post('password');
        $email      = Yii::$app->request->post('email');
        
        $user = User::find()->where(['email' => $email,'password_reset_token' => $token])->asArray()->one();

        if($token && $password)
        {
            if($token == $user['password_reset_token'])
            {
                $password   = \Yii::$app->security->generatePasswordHash($password);
                User::updateAll(['password_hash' => $password,'password_reset_token' => ''],['id' => $user['id'],'email' => $user['email']]);
                $this->message = 'Your Password Changed Successfully';
                return '1';
            }
            else 
            {
                $this->message = 'Invalid Token';
                $this->code = 0;
                $this->status = 0;
            }
        }
        else
        {
            return $this->missingParam();
        }
    }

    public function actionLogout()
    {
        // if(!$this->user['id'] && !Yii::$app->request->post('token')){
        if(!Yii::$app->request->post('token')){
            return $this->missingParam();
        }

        // $user_id = $this->user['id'];
        $token = Yii::$app->request->post('token');

        // $device = UserDevice::find()->where(['token' => $token, 'user_id' => $user_id])->one();
        $devices = UserDevice::find()->where(['token' => $token])->all();
        if($devices){
            foreach ($devices as $device) {
                $device->delete();
            }
            return [
                'name' => 'Logout',
                'message' => 'Success',
                'code' => '1',
                'status' => '200',
                'data' => []
            ];
        } else {
            return [
                'name' => 'Logout Error',
                'message' => 'Invalid Token',
                'code' => '0',
                'status' => '401',
                'data' => []
            ];
        }    
    }

    private function allInvoiceCounts($customer_id = NULL)
    {
        $paid = \common\models\Invoice::find()
//            ->where("paid_amount > 0")
            ->andWhere("invoice_is_deleted != 1")
            ->andWhere(['=', 'customer_user_id', $customer_id])
            ->sum('paid_amount');

        /*$worth = \common\models\Vehicle::find()
            ->where(['=', 'status', 1])
            ->andWhere(['=', 'customer_user_id', $customer_id])
            ->sum('value');*/

        /*$partial = \common\models\Invoice::find()
            ->where("paid_amount>0 and paid_amount is not null and total_amount>(paid_amount+adjustment_damaged+adjustment_storage+adjustment_discount+adjustment_other)")
            ->andWhere("invoice_is_deleted !=1")
            ->andWhere(['=', 'customer_user_id', $customer_id])
            ->sum('paid_amount');*/

        $unpaid = \common\models\Invoice::find()
            ->andWhere(['=', 'customer_user_id', $customer_id])
            ->andWhere("invoice_is_deleted != 1")
            ->sum('total_amount-paid_amount-adjustment_damaged-adjustment_storage-adjustment_discount-adjustment_other');

        /*$discount = \common\models\Invoice::find()
            ->where(['=', 'customer_user_id', $customer_id])
            ->andWhere("invoice_is_deleted != 1")
            ->sum('adjustment_discount');*/

        $total = \common\models\Invoice::find()
            ->where(['=', 'customer_user_id', $customer_id])
            ->andWhere("invoice_is_deleted != 1")
            ->sum('total_amount-adjustment_damaged-adjustment_storage-adjustment_discount-adjustment_other');

        return ['paid' => $paid, 'unpaid' => $unpaid, 'total' => $total];
    }
}