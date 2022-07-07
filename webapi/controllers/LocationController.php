<?php

namespace app\controllers;


use app\components\WebApiController;
use common\models\Location;
use common\models\Lookup;
use yii\helpers\ArrayHelper;

class LocationController extends WebApiController
{
    public $modelClass = 'common\models\Location';
    
    public function actionIndex()
    {
        return Lookup::$apiLocations;
    }
}

?>