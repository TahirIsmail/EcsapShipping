<?php

namespace api\modules\v1\controllers;
//namespace \common\models;
use Yii;
use common\models\User;

use yii\rest\ActiveController;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use api\modules\v1\models\LoginForm;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior ;
use yii\db\Expression;
use common\components\AccessRule;
use yii\filters\AccessControl;
class UserController extends ActiveController
{
  public $modelClass = 'common\models\User';
 


  public function behaviors()
  {
   // $behaviors[] = parent::behaviors();
    return ArrayHelper::merge(parent::behaviors(),[
     [
   
     'class' => CompositeAuth::className(),
       'except' => ['login','options'],
     'authMethods' => [
     HttpBearerAuth::className(),
     ],
     ],
        'corsFilter' => [
            'class' => \yii\filters\Cors::className(),
        ],
     'timestamp' => [
     'class' => TimestampBehavior::className(),

     ],
      [
          'class' => 'yii\filters\ContentNegotiator',
          'only' => ['view', 'index'],  // in a controller
              // if in a module, use the following IDs for user actions
              // 'only' => ['user/view', 'user/index']
              'formats' => [
                  'application/json' => Response::FORMAT_JSON,
              ],
           
          ],
   
     'contentNegotiator' => [
     'formats' => [
     'application/json' => Response::FORMAT_JSON,
     ],
     ],


     ] );

  }


 



  public function actionLogin() {
      
          
    $model = new \api\modules\v1\models\LoginForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
    if ($model->login()) {  
      $userRole = array_keys(Yii::$app->authManager->getRolesByUser(\Yii::$app->user->identity->id))[0];
      $data=[

        'access_token'=>\Yii::$app->user->identity->getAuthKey(),
        'id'=>\Yii::$app->user->identity->id,
        'role'=>$userRole,
      ];
       
   return $data;

    }
      
       
         else {
        Yii::$app->response->statusCode = 422;
      return  $model->firstErrors;
      
     
    }

  
  }







}




