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
class VehicleController extends ActiveController
{
  public $modelClass = 'common\models\Vehicle'; 

  public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
  
  public function actions() 
  { 
      $actions = parent::actions();
      $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
      unset($actions['create']);
      unset($actions['update']);
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
           'actions' => ['create','index','update'],
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
      $searchModel = new \common\models\VehicleSearch();    
    
      return $searchModel->search(\Yii::$app->request->queryParams);
  }
  public function actionUpdate($id){
    $model = \common\models\Vehicle::findOne($id);
    $towing = \common\models\TowingRequest::findOne($model->towing_request_id);
    $vehiclefeatures = new \common\models\VehicleFeatures();
    $vehiclecondition = new \common\models\VehicleCondition();
        //$features = \common\models\Features::find()->all();
        //$condition = \common\models\Condition::find()->all();
        $all_images = '';
        $featuredata = '';
        $conditiondata = '';
        $session_data = '';

        $all_images_preview = [];
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '')) {
            if($model->is_export !=1){
                $model->is_export = 0;
            }
            if(isset(Yii::$app->request->getBodyParams()["TowingRequest"])){
                $towing->load(["TowingRequest"=>Yii::$app->request->getBodyParams()["TowingRequest"]]);
            }
            $vehiclefeatures->load(Yii::$app->getRequest()->getBodyParams(), '');
            $vehiclecondition->load(Yii::$app->getRequest()->getBodyParams(), '');
            
            
            if(empty($model->customer_user_id) || $model->customer_user_id=='null'){
                $model->customer_user_id = '7000178';
                //$model->legacy_customer_id = '7000000';
            }
            $transaction = Yii::$app->db->beginTransaction();
            try
            {
                if (!$towing->towed) {
                    $towing->towed = 0;
                }

                if ($towing->save()) {

                    // $model->customer_user_id = '11';
                    //$model->towing_request_id = $towing->id;
                    $user_id = Yii::$app->user->getId();
                    $Role = Yii::$app->authManager->getRolesByUser($user_id);

                    if (isset($Role['admin_LA'])) {
                        $model->location = '1';
                    } elseif (isset($Role['admin_GA'])) {
                        $model->location = '2';
                    } elseif (isset($Role['admin_NY'])) {
                        $model->location = '3';
                    } elseif (isset($Role['admin_TX'])) {
                        $model->location = '4';
                    } elseif (isset($Role['admin_TX2'])) {
                        $model->location = '5';
                    } elseif (isset($Role['admin_NJ2'])) {
                        $model->location = '6';
                    } elseif (isset($Role['admin_CA'])) {
                        $model->location = '6';
                    }
                }
                $model->vin = preg_replace('/\s+/', '', $model->vin);
                if(empty($model->status&& $model->isNewRecord)){
                    //$model->status = 3;
                }
                if($model->additional_charges=="null"){
                    $model->additional_charges = 0;
                }
                if($model->towed_amount=="null"){
                    $model->towed_amount = 0;
                }
                if($model->title_amount=="null"){
                    $model->title_amount = 0;
                }
                if($model->storage_amount=="null"){
                    $model->storage_amount = 0;
                }
                if($model->value=="null"){
                    $model->value = "";
                }
                if($model->license_number=="null"){
                    $model->license_number = "";
                }
                if($model->towed_from=="null"){
                    $model->towed_from = "";
                }
                if($model->check_number=="null"){
                    $model->check_number = "";
                }
				if(isset(Yii::$app->request->getBodyParams()["VehicleFeatures"]["value"][1])){
					$model->keys = Yii::$app->request->getBodyParams()["VehicleFeatures"]["value"][1];
				}else{
					$model->keys = '0';
				}
				if($model->keys=='null'){
					$model->keys = '0';
				}
                if (!$model->save()) {

                      $transaction->rollBack();
                    Yii::$app->response->statusCode = 422;
                    return $model->firstErrors;
                }else{
                    if (isset(Yii::$app->request->getBodyParams()["VehicleFeatures"]["value"])) {
                        $command = Yii::$app->db->createCommand() ->delete('vehicle_features', 'vehicle_id = ' . $model->id)->execute();
                        $vehicle_feature = \common\models\VehicleFeatures::inert_vehicle_feature($model, Yii::$app->request->getBodyParams()["VehicleFeatures"]["value"]);
                    }
                    //delete vehicle condition and add new features
        
                    if (isset(Yii::$app->request->getBodyParams()["VehicleCondition"]["value"])) {
                        $command = Yii::$app->db->createCommand()->delete('vehicle_condition', 'vehicle_id = ' . $model->id)->execute();
                        $vehicle_condition = \common\models\VehicleCondition::inert_vehicle_condition($model, Yii::$app->request->getBodyParams()["VehicleCondition"]["value"]);
                    }
                }
                    
        
                  
                  $photo = UploadedFile::getInstancesByName('photo'); 

                if ($photo !== null) {
                    $save_images = \common\models\Images::save_container_images($model->id, $photo);
                }
                  $transaction->commit();

                  return "Vehicle Updated Successfully";
                
             
            } catch (Exception $e) {
                $transaction->rollBack();

                throw $e;
            }
    
        }
  }
  public function actionCreate()
  {
        $model = new \common\models\Vehicle();
        $towing = new \common\models\TowingRequest();
        $images = new \common\models\Images();
        $vehiclefeatures = new \common\models\VehicleFeatures();
        $vehiclecondition = new \common\models\VehicleCondition();
        //$features = \common\models\Features::find()->all();
        //$condition = \common\models\Condition::find()->all();
        $all_images = '';
        $featuredata = '';
        $conditiondata = '';
        $session_data = '';

        $all_images_preview = [];
        $params = Yii::$app->getRequest()->getBodyParams();
        if(isset($params['Vehicle'])){
            $params = $params['Vehicle'];
        }
        //return json_encode($params);
        if ($model->load($params,'')) {
            if(isset(Yii::$app->getRequest()->getBodyParams()['TowingRequest'])){
                $towing->load(["TowingRequest"=>Yii::$app->request->getBodyParams()["TowingRequest"]]);
            }
            if(empty($model->hat_number) && isset($params['hat'])){
                $model->hat_number = $params['hat'];
            }
            if(empty($model->lot_number) && isset($params['lot_no'])){
                $model->lot_number = $params['lot_no'];
            }
            $vehiclefeatures->load(Yii::$app->getRequest()->getBodyParams(),'');
            $vehiclecondition->load(Yii::$app->getRequest()->getBodyParams(),'');
            
            if(empty($model->customer_user_id) || $model->customer_user_id=="null" || $model->customer_user_id=='600023'){
                $model->customer_user_id = 7000178;
                //$model->legacy_customer_id = '7000000';
            }
            if($model->pieces=="null"){
                $model->pieces = 1;
            }
            if($model->additional_charges=="null"){
                $model->additional_charges = 0;
            }
            if($model->towed_amount=="null"){
                $model->towed_amount = 0;
            }
            if($model->title_amount=="null"){
                $model->title_amount = 0;
            }
            if($model->storage_amount=="null"){
                $model->storage_amount = 0;
            }
            if($model->value=="null"){
                $model->value = "";
            }
            if($model->license_number=="null"){
                $model->license_number = "";
            }
            if($model->towed_from=="null"){
                $model->towed_from = "";
            }
            if($model->check_number=="null"){
                $model->check_number = "";
            }
            
            $model->is_export = 0;
            $transaction = Yii::$app->db->beginTransaction();
            try
            {
                if (!$towing->towed || $towing->towed=='null') {
                    $towing->towed = 0;
                }

                if ($towing->save()) {

                    // $model->customer_user_id = '11';
                    $model->towing_request_id = $towing->id;
                    $user_id = Yii::$app->user->getId();
                    $Role = Yii::$app->authManager->getRolesByUser($user_id);

                    if (isset($Role['admin_LA'])) {
                        $model->location = '1';
                    } elseif (isset($Role['admin_GA'])) {
                        $model->location = '2';
                    } elseif (isset($Role['admin_NY'])) {
                        $model->location = '3';
                    } elseif (isset($Role['admin_TX'])) {
                        $model->location = '4';
                    } elseif (isset($Role['admin_TX2'])) {
                        $model->location = '5';
                    } elseif (isset($Role['admin_NJ2'])) {
                        $model->location = '6';
                    } elseif (isset($Role['admin_CA'])) {
                        $model->location = '6';
                    }
                }
                $model->vin = preg_replace('/\s+/', '', $model->vin);
                if(empty($model->status) && $model->isNewRecord){
                    $model->status = 3;
                }
				if(isset(Yii::$app->request->getBodyParams()["VehicleFeatures"]["value"][1])){
					$model->keys = Yii::$app->request->getBodyParams()["VehicleFeatures"]["value"][1];
				}else{
					$model->keys = '0';
				}
                if (!$model->save()) {

                      $transaction->rollBack();
                    Yii::$app->response->statusCode = 422;
                    return $model->firstErrors;
                }else{
                    if (isset(Yii::$app->request->getBodyParams()["VehicleFeatures"]["value"])) {
                        //$command = Yii::$app->db->createCommand() ->delete('vehicle_features', 'vehicle_id = ' . $model->id)->execute();
                        $vehicle_feature = \common\models\VehicleFeatures::inert_vehicle_feature($model, Yii::$app->request->getBodyParams()["VehicleFeatures"]["value"]);
                    }
                    //delete vehicle condition and add new features
        
                    if (isset(Yii::$app->request->getBodyParams()["VehicleCondition"]["value"])) {
                        //$command = Yii::$app->db->createCommand()->delete('vehicle_condition', 'vehicle_id = ' . $model->id)->execute();
                        $vehicle_condition = \common\models\VehicleCondition::inert_vehicle_condition($model, Yii::$app->request->getBodyParams()["VehicleCondition"]["value"]);
                    }
                }
                    
        
                  
                  $photo = UploadedFile::getInstancesByName('photo'); 

                if ($photo !== null) {
                    $save_images = \common\models\Images::save_container_images($model->id, $photo);
                }
                  $transaction->commit();

                  return "Vehicle Added Successfully";
                
             
            } catch (Exception $e) {
                $transaction->rollBack();

                throw $e;
            }
    
        }
    
     
  }

     public function actionGetCustomer($withadmins = false) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
         
              $query = new \yii\db\Query();
                $query->select('user_id as id, company_name AS text')
                        ->from('customer')
                       ->where(['!=','is_deleted',1]);
                if(!$withadmins){
                    $query->andWhere(['not in','legacy_customer_id',['LAADMIN0001','GAOFFICE20018','NJOFFICE20018','TXOFFICE20018']]);
                }
              
                $command = $query->createCommand();
                $data = $command->queryAll();
                $out['results'] = array_values($data);
          
        return $out;
    }
 
  public function actionImageDelete()
  {


$s3 = S3Client::factory(array(
    'key'    => 'AKIAJLTYVI3FYMZ54ZHQ',
    'secret' => '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',
        'version' => 'latest',
        'region' => 'us-west-2',

));

// Delete the objects in the "photos" bucket with the a prefix of "thumbs/"

$s3->deleteMatchingObjects('AFG-ios-storage', 'App-Storage/');
  }
 public function actionLocations(){
     
    return \common\models\Lookup::$apiLocations;
 }
}
