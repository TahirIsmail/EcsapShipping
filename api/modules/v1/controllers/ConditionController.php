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
use yii\filters\auth\QueryParamAuth;
use common\models;
use Yii;

/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class ConditionController extends ActiveController
{
    public $modelClass = 'common\models\Condition';  
        public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
  
  public function actions() 
  { 
      $actions = parent::actions();
    
      unset($actions['create']);
        unset($actions['update']);
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
           'only' => [ 'index'],
           'rules' => [[
           'actions' => ['index'],
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



}
