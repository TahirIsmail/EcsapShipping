<?php

namespace api\modules\v1\controllers;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\helpers\ArrayHelper;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior ;
use yii\db\Expression;
use common\components\AccessRule;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use common\models;
use common\models\UploadForm;
use vlaim\fileupload\FileUploadException;
use vlaim\fileupload\FileUpload;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Yii;

/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class ExportImagesController extends ActiveController
{
   
  public $modelClass = 'common\models\ExportImages'; 
  public $serializer = [
    'class' => 'yii\rest\Serializer',
    'collectionEnvelope' => 'items',
];
public function actions() 
{ 
    $actions = parent::actions();
   // $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
    unset($actions['delete']);
   // unset($actions['update']);
    return $actions;
}

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
          QueryParamAuth::className()

           
           ],
        ],
       
           [
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
           [
           'class' => AccessControl::className(),
    // We will override the default rule config with the new AccessRule class
           'ruleConfig' => [
           'class' => AccessRule::className(),
           ],
           'only' => ['create', 'index', 'delete','update'],
           'rules' => [[
           'actions' => ['create','index','delete'],
           'allow' => true,
            // Allow users, moderators and admins to create
               'matchCallback' => function ($rule, $action) {
                           // $user = Yii::$app->user->identity->id;
                            $role =   Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id);
                        if (ArrayHelper::keyExists('super_admin', $role, true) || ArrayHelper::keyExists('admin_LA', $role, false)||ArrayHelper::keyExists('admin_GA', $role, false)||ArrayHelper::keyExists('admin_NY', $role, false)||ArrayHelper::keyExists('admin_TX', $role, false)||ArrayHelper::keyExists('admin_TX2', $role, false)||ArrayHelper::keyExists('admin_NJ2', $role, false)||ArrayHelper::keyExists('admin_CA', $role, false))  {
                            return true;   // let them in
                        }
                        return false;   // get lost
                    },
        ],
    ],
         ],

           ]

           );

    }  


public function actionAddImages(){
    $data = Yii::$app->request->post();
    $export_id = $data['export_id'];
    $photo = UploadedFile::getInstancesByName('photo'); 
    
    // $export=  \common\models\Export::findOne($export_id);
    // $bucket = 'AFG-ios-storages/export/'.$export->ar_number;
    // try{
    //     $uploader = new FileUpload(FileUpload::S_S3, [
    //         'version' => 'latest',
    //         'region' => 'us-west-2',
    //         'credentials' => [
    //             'key' => 'AKIAJLTYVI3FYMZ54ZHQ',
    //             'secret' => '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'
    //         ],
    //        'bucket' => $bucket,
           
    //     ]);
    //       $image=array();
    //       foreach($photo as $ph)
    //       {
    //         $images = new \common\models\ExportImages();
    //         $images->export_id=$export_id;
    //         $images->name=$uploader->uploadFromFile($ph)->path;
    //         $base_url='https://s3-us-west-2.amazonaws.com/AFG-ios-storages';
    //         $imagename =    explode($base_url,$images->name);
    //         $images->name=  $imagename[1];
    //         $images->baseurl = $base_url;
            
    //         if(!$images->save())
    //         {
    //           return $images->getErrors();
    //       }
    //       }
    //     }catch(FileUploadException $e){
    //       throw $e;
       
    //     } 
    if ($photo !== null) {
        $save_images = \common\models\ExportImages::save_container_images($export_id, $photo);
    }
        return "Image added Successfully";
}

 
  public function actionDelete($id)
  {
    $model=  \common\models\ExportImages::findOne($id);
    if($model){
    // $base_url='https://s3-us-west-2.amazonaws.com/AFG-ios-storages';
    // $s3 = S3Client::factory(array(
    //     'key'    => 'AKIAJLTYVI3FYMZ54ZHQ',
    //     'secret' => '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',
    //         'version' => 'latest',
    //         'region' => 'us-west-2',
    // ));
    // $bucket = 'AFG-ios-storages';
  
    // // $key=urldecode(explode($base_url,$exportImage->name)[1]);// $images->name is  Path from Db, base url is path to s3 server
    // $key=urldecode($exportImage->name);// $images->name is  Path from Db, base url is path to s3 server
   
    // $delete =  $s3->deleteObject([
    //     'Bucket' => 'AFG-ios-storages',
    //     'Key' => $key
    // ]);
    // $object_exist =  $s3->doesObjectExist($bucket,$key);
    unlink('/var/www/html/api/../uploads/'.$model->name);
    unlink('/var/www/html/api/../uploads/'.$model->thumbnail);
        \Yii::$app
        ->db
        ->createCommand()
        ->delete('export_images', ['id' => $id])
        ->execute();
        return "succesfully deleted";
    }else{
        return "there is some problem while procesing the deletion";
    }
  }
 
}
