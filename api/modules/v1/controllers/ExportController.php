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
use Yii;

/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class ExportController extends ActiveController
{
  public $modelClass = 'common\models\Export'; 

  public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
  
  public function actions() 
  { 
      $actions = parent::actions();
      $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
      unset($actions['create']);
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
           'actions' => ['create','index'],
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

  public function prepareDataProvider() 
  {
      $p = \Yii::$app->request->queryParams;
      $searchModel = new \common\models\ExportSearch();
      if(isset($p['ExportSearch']['ar_number'])){
          $p2 = ['ExportSearch'=>['export_global_search'=>$p['ExportSearch']['ar_number']]];
      }else{
          $p2 = $p;
      }
      return $searchModel->search($p2);
  }


 

 
}
