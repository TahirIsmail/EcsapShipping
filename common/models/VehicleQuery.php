<?php 
namespace common\models;

use yii\db\ActiveQuery;

class VehicleQuery extends ActiveQuery
{
    // conditions appended by default (can be skipped)
    public function init()
    {
        $this->andOnCondition(['!=','vehicle_is_deleted',1]);
        parent::init();
    }  
}