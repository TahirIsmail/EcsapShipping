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
use vlaim\fileupload\FileUploadException;
use vlaim\fileupload\FileUpload;
use Yii;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UploadController extends ActiveController
{

    public $documentPath;
    public $modelClass = '';
   // public function behaviors()
   //  {
   //      return ArrayHelper::merge(parent::behaviors(),[
   //        [
   //          'class' => \yii\filters\Cors::className(),
   //      ],
   //         [
   //         'class' => CompositeAuth::className(),
   //             'except' => ['options'],
   //         'authMethods' => [
   //         HttpBearerAuth::className(),

           
   //         ],
   //      ],
       
   //         [
   //         'class' => TimestampBehavior::className(),

   //         ],
   //           [
   //            'class' => 'yii\filters\ContentNegotiator',
   //            'only' => ['upload'],  // in a controller
   //            // if in a module, use the following IDs for user actions
   //            // 'only' => ['user/view', 'user/index']
   //            'formats' => [
   //                'application/json' => Response::FORMAT_JSON,
   //            ],
           
   //        ],
   //         [
   //         'class' => AccessControl::className(),
   //  // We will override the default rule config with the new AccessRule class
   //         'ruleConfig' => [
   //         'class' => AccessRule::className(),
   //         ],
   //         'only' => ['create', 'index', 'delete'],
   //         'rules' => [[
   //         'actions' => ['create'],
   //         'allow' => true,
   //          // Allow users, moderators and admins to create
   //         'roles' => [
   //         User::ROLE_SHOP,
   //         User::ROLE_ADMIN,
   //         User::ROLE_USER,
   //         ],
   //      ],
    
      
   //       ],
   //       ],


   //         ]



   //         );

   //  }   
      public function actionUpload()
    {
        $model = new UploadForm();
        //return Yii::$app->getRequest()->getBodyParams();
       // return    $model->load(Yii::$app->getRequest()->getBodyParams(), '');
   
        if (Yii::$app->request->isPost) {

        	if (UploadedFile::getInstanceByName('data'))
        	{
            	$model->image = UploadedFile::getInstanceByName('data');
            	$path=\Yii::getAlias('@common').'/upload/productpic/' ;
   			}
   			else if  (UploadedFile::getInstanceByName('profilepic'))
   			{
   				$model->image = UploadedFile::getInstanceByName('profilepic');
   				$path=\Yii::getAlias('@common').'/upload/profilepic/' ;
   			}
   			else if  (UploadedFile::getInstanceByName('shoppic'))
   			{
   				$model->image = UploadedFile::getInstanceByName('shoppic');
   				$path=\Yii::getAlias('@common').'/upload/shoppic/' ;
   			}
        else
        {
          return false;
        }

           if ($model->validate()) 
           {
            	$basename = \Yii::$app->security->generateRandomString();
            	$model->image->saveAs($path. $basename . '.' . $model->image->extension);
            	return $basename.".".$model->image->extension;
         	}   
         	else
            {
            	return $model->firstErrors;
            }
              
        }
    }

public function actionAws()
{
 //$model = new UploadForm();


$photo = UploadedFile::getInstancesByName('photo'); 

try{
$uploader = new FileUpload(FileUpload::S_S3, [
    'version' => 'latest',
    'region' => 'us-west-2',
    'credentials' => [
        'key' => 'AKIAJLTYVI3FYMZ54ZHQ',
        'secret' => '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'
    ],
    'bucket' => 'AFG-ios-storage'
]);
   //$uploader = $model->photo;
  $image=array();
  foreach($photo as $ph)
  {
  
    $image[] = $uploader->uploadFromFile($ph)->path;

  }
return $image;
}

catch(FileUploadException $e){
  echo $e->getMessage();
} 
}
}