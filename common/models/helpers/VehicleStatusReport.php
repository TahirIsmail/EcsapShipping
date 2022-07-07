<?php

namespace common\models\helpers;

use Yii;
class VehicleStatusReport extends \yii\base\Model {
    function __construct($column_name,$condition_column,$condition_value)
    {
       
        $this->ColumnName=$column_name;
        $this->ConditionColumn=$condition_column;
        $this->ConditionValue=$condition_value;
    }
    
    public $ColumnName;
    public $ConditionColumn;
    public $ConditionValue;
    public static function GetConditions()
    {
        $conditions_array[] = new \common\models\helpers\VehicleStatusReport('on_hand', 'vehicle.status','1');
        $conditions_array[] = new \common\models\helpers\VehicleStatusReport('manifest', 'vehicle.status','2');
        $conditions_array[] = new \common\models\helpers\VehicleStatusReport('picked_up', 'vehicle.status','5');
        $conditions_array[] = new \common\models\helpers\VehicleStatusReport('car_on_way', 'vehicle.status','3');
        $conditions_array[] = new \common\models\helpers\VehicleStatusReport('shipped', 'vehicle.status','4');
        $conditions_array[] = new \common\models\helpers\VehicleStatusReport('on_hand_with_towed', 'towing_request.towed',Null);
        $conditions_array[] = new \common\models\helpers\VehicleStatusReport('on_hand_with_title', 'towing_request.title_recieved','1');
        $conditions_array[] = new \common\models\helpers\VehicleStatusReport('on_hand_with_out_title', 'towing_request.title_recieved',Null);
        
        $conditions_array[] = new \common\models\helpers\VehicleStatusReport('towed', 'towing_request.towed','1');
        $conditions_array[] = new \common\models\helpers\VehicleStatusReport('not_towed', 'towing_request.towed',Null);
        $conditions_array[] = new \common\models\helpers\VehicleStatusReport('with_title', 'towing_request.title_recieved','1');
        $conditions_array[] = new \common\models\helpers\VehicleStatusReport('with_out_title', 'towing_request.title_recieved',Null);
        $conditions_array[] = new \common\models\helpers\VehicleStatusReport('towed_with_title', 'towing_request.title_recieved','1');
        $conditions_array[] = new \common\models\helpers\VehicleStatusReport('towed_with_out_title', 'towing_request.title_recieved',Null);
       
        return $conditions_array;
    }
    
   
}