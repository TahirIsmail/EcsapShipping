<?php

namespace api\modules\v1\controllers;

use yii\web\Response;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior ;
use yii\db\Expression;
use common\components\AccessRule;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models;
use common\models\UploadForm;
use yii\web\UploadedFile;
use Yii;

/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */

class EncodeController extends ActiveController {

    public $documentPath;
    public $modelClass = '';


  public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
          [
            'class' => \yii\filters\Cors::className(),
        ],
           [
           'class' => CompositeAuth::className(),
               'except' => ['options'],
           'authMethods' => [
           HttpBearerAuth::className(),

           
           ],
        ],
       
           [
           'class' => TimestampBehavior::className(),

           ],
             [
              'class' => 'yii\filters\ContentNegotiator',
              'only' => ['upload'],  // in a controller
              // if in a module, use the following IDs for user actions
              // 'only' => ['user/view', 'user/index']
              'formats' => [
                  'application/json' => Response::FORMAT_JSON,
              ],
           
          ],
           [
           'class' => AccessControl::className(),
    // We will override the default rule config with the new AccessRule class
           'ruleConfig' => [
           'class' => AccessRule::className(),
           ],
           'only' => ['upload'],
           'rules' => [[
           'actions' => ['upload'],
           'allow' => true,
            // Allow users, moderators and admins to create
           'roles' => [
           User::ROLE_SHOP,
           User::ROLE_ADMIN,
           User::ROLE_USER,
           ],
        ],
    
      
         ],
         ],


           ]



           );

    }   

   public function actionUpload() {

    if (Yii::$app->request->isPost) {
        if(isset($_POST['data']))
        {
        $data = $_POST['data'];
        $this->documentPath = \Yii::getAlias('@common') . '/upload/productpic/';
        }
        else if(isset($_POST['profilepic']))
        {
        $data = $_POST['profilepic'];
        $this->documentPath = \Yii::getAlias('@common') . '/upload/profilepic/';
        }
       else  if(isset($_POST['shoppic']))
        {
        $data = $_POST['shoppic'];
        $this->documentPath = \Yii::getAlias('@common') . '/upload/shoppic/';
        }
     else
        {
          return false;
        }

    //return  $data;
    //return $data.'test';
    
     // $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
      //return $data;
       $d = explode(',', $data);

        $data=base64_decode($d[1]);
        $basename = \Yii::$app->security->generateRandomString();
        $f = finfo_open();

        $mime_type = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);
       
        $split = explode('/', $mime_type);
        $type = $split[1];

    //return $mime_type.','.$split.','.type;
        $data = file_put_contents($this->documentPath . '/' . $basename . '.' . $type, $data);

        return $basename . '.' . $type;
        // return $data;
        }
        else
        {
            return "No image send";
        }
}
}
