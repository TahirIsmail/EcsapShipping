<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior ;
use yii\db\Expression;
use common\components\AccessRule;
use common\models\User;
use common\models;
use Yii;

/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class PhotoController extends ActiveController
{
    public $modelClass = 'common\models\Photos';  
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
           'only' => ['create', 'index', 'delete'],
           'rules' => [[
           'actions' => ['create'],
           'allow' => true,
            // Allow users, moderators and admins to create
           'roles' => [
           User::ROLE_SHOP,
           User::ROLE_ADMIN
           ],
        ],
           [
           'actions' => ['index'],
           'allow' => true,
            // Allow moderators and admins to update
           'roles' => [
           User::ROLE_USER,
           User::ROLE_SHOP,
           User::ROLE_ADMIN
           ],
         ],
           [
           'actions' => ['delete'],
           'allow' => true,
            // Allow admins to delete
           'roles' => [
           User::ROLE_ADMIN,
           User::ROLE_SHOP
           ],
         ],
         ],
         ],


           ]



           );

    }  
 
    public function actions() 
{ 
    $actions = parent::actions();
    $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
      unset($actions['create']);
    return $actions;
}
public function actionCreate()
{
    $request=Yii::$app->request;
  	$post=$request->post();
  	if(isset($post['path']))
  	{
    	$data = [];
    	foreach($post['path'] as $p) {
        	$data[] = ['path' => $p, 'product_id' => $post['product_id']];

    }
      if(Yii::$app->db->createCommand()->batchInsert(
        \common\models\Photos::tableName(), 
        ['path', 'product_id'], 
        $data
    )->execute())
      {
      	return "success";

      }
      else{
      	return "no success";
      }
   }
   else{
   	return "Path Cannot be blank";
   }
}
	public function actionGetLabels()
{
  $model = new $this->modelClass;
  return $model->attributeLabels();

}


}
