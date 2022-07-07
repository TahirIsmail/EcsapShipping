<?php
namespace app\controllers;

use common\models\Pricing;
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
class PricingController extends WebApiController
{
    public $modelClass = 'common\models\Pricing';

    public function actionIndex()
    {
        if (!$this->user['id']) {
            return $this->missingParam();
        }

        $data = Pricing::find()->andFilterWhere(['!=', 'status', 2])->orderBy("status")->asArray()->all();

        foreach ($data as $key => $item) {
            $data[$key]['upload_file'] = !empty($data[$key]['upload_file']) ? str_replace(['backend/','backend','webapi/','webapi'], '', \yii\helpers\Url::to(['@web'],TRUE)).'uploads/' . $data[$key]['upload_file'] : '';
        }

        return $data;
    }

}
