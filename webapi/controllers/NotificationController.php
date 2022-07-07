<?php
namespace app\controllers;

use common\models\Notification;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\Response;
use app\models\VehicleData;
use app\components\WebApiController;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


/**
 * Site controller
 */
class NotificationController extends WebApiController
{
    public $modelClass = 'common\models\Notification';
    public function actionIndex()
    {
        if (!$this->user['id']) {
            return $this->missingParam();
        }

        return Notification::find()->where("expire_date <=  ".date('Y-m-d'))->andWhere("user_id = ".$this->user['id'])->orderBy("id desc")->asArray()->all();
    }

}
