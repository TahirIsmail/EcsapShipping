<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\Response;
use common\models\LoginForm;
use common\models\User;
use common\models\UserDevice;

/**
 * Site controller
 */
class LoginController extends ActiveController
{
    public $modelClass = 'common\models\User';
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
    }
    
    /**
     * {@inheritdoc}
     */
    protected function verbs()
    {
        $verbs = parent::verbs();
        $verbs['index'] = ['POST'];
        return $verbs;
    }

    /**
     * Common actions accross across webapi
     */
    public function actions()
    {
        return [];
    }
    /**
     * Login action.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new LoginForm();
        $model->username = Yii::$app->request->post('username');
        $model->password = Yii::$app->request->post('password');
        $device_id = Yii::$app->request->post('deviceid');
        $token = Yii::$app->request->post('token');
        
        if ($user = $model->serviceLogin()) 
        {
            $role = \Yii::$app->authManager->getRolesByUser($user->id);

            if($role && !empty($role) && array_key_exists('super_admin', $role))
            {
                if(!$user->auth_key)
                {
                    $auth_key = \Yii::$app->security->generateRandomString();
                    User::updateAll(['auth_key' =>  $auth_key],['id' => $user->id]);
                    $user->auth_key = $auth_key;
                }
                
                $this->SetDeviceData($device_id,$token,$user->id);
                
                return ['name' => 'Login',
                    'message' => 'Success',
                    'code' => '1',
                    'status' => '200',
                    'data' => ['auth_key' => $user->auth_key]];
                
            }
            else
            {
                return ['name' => 'Forbidden  Error',
                    'message' => 'Not Allow to login ',
                    'code' => '0',
                    'status' => '401',
                    'data' => []];
            }
        } 
        else 
        {
            $error = $model->getErrors();
            $errorstr = '';
            if($error && is_array($error)){
                foreach ($error as $k=>$val){
                    $errorstr .= implode(' ', $val);
                }
            }
            $errorstr = ($errorstr) ? $errorstr : 'Incorrect username or password';

            return ['name' => 'Login Error',
                'message' => $errorstr,
                'code' => '0',
                'status' => '401',
                'data' => []];
        }
    }
    
    private function SetDeviceData($device_id,$token,$user_id)
    {
        if($device_id && $token && $user_id)
        {
            $device = UserDevice::find()->where(['device_id' => $device_id])->one();
            if($device && !empty($device)){
                $device->updated_at = time();
            }
            else{
                $device = new UserDevice();
                $device->status = 1;
                $device->created_at = time();
            }
            
            $device->user_id = $user_id;
            $device->updated_at = time();
            $device->token = $token;
            $device->device_id = $device_id;
            $device->udid = "";
            $device->save();
            return "1";
        }
    }
}
