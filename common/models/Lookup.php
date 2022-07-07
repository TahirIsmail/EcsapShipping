<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cash".
 *
 * @property integer $ID
 * @property string $name
 * @property string $details
 * @property double $total
 *
 * @property MoneyTransactions[] $moneyTransactions
 */
class Lookup {
    
    public static $container_type = [
        1 => "1 X 20'HC DRY VAN",
        2 => "1 X 45'HC DRY VAN",
        3 => "1 X 40'HC DRY VAN",
        
     
    ];
    public static $notes_status = [
        1=>'Closed',
        2=>'Open',
    ];
    public static $pricing_type = [
        1 => "Towing Price",
        2 => "Ocean Freight Price",
    ];
    public static $pricing_status_type = [
        1 => "Active",
        2 => "In Active",
     
    ];
    public static $consignee = [
        1 => "Alaroudh Used Cars & spare parts co llc",
        2 => "AFG Global SHIPPING LLC",
        3 => "AL AROUDH USED CARS CO LLC",
        4 => "FARID AHMAD",
    ];
    public static $status = [
        3 => "DISPATCHED",
        1 => "ON HAND",
        2 => "MANIFEST",
        4 => "SHIPPED",
        6 => "ARRIVED",
        5 => "PICKED UP",
    ];
    public static $status_picked = [
        1 => "ON HAND",
        2 => "MANIFEST",
        3 => "DISPATCHED",
        4 => "SHIPPED",
          6 => "ARRIVED",
        5 => "PICKED UP",
        ''=>'UNKNOWN'
    ];
    public static $status_invert = [
        "DISPATCHED"=>3,
        "ON HAND"=>1,
        "MANIFEST"=>2,
        "SHIPPED"=>4,
           "ARRIVED"=>6,
        "PICKED UP"=>5,
        'DISPATCHED'=>3

    ];
    public static $status_without_auto = [
        3 => "DISPATCHED",
        1 => "ON HAND",
        2=> "MANIFEST",
        4 => "SHIPPED",
        6 => "ARRIVED",
        // 5 => "PICKED UP",
    ];
     public static $vehicle_type = [
        'SUV' => "SUV",
        'Sedan' => "Sedan",
        'Van' => "Van",
        'Pickup' => "Pickup",
        'Truck' => "Truck",
        'Mortorcycle' => "Mortorcycle"
    ];
    public static  $location = [
        1 => "LA",
        2 => "GA",
        3 => "NY",
        4 => "TX",
        8 => "MD",
        // 5=>"TX-2",
        // 6=>'NJ-2',
        // 7=>'CA'
    ];
    public static $apiLocations = [
   ['id' => 1,'name'=> 'LA'],
   ['id' => 2,'name'=> 'GA'],
   ['id' => 3,'name'=> 'NY'],
   ['id' => 4,'name'=> 'TX'],
   ['id' => 5,'name'=> 'TX2'],
   ['id' => 6,'name'=> 'NJ2'],
   ['id' => 7,'name'=> 'CA'],
    ];
    public static $location_inverse=[
        'LA'=>1,
        'GA'=>2,
        'NY'=>3,
        'TX'=>4,
        'TX-2'=>5,
        'NJ-2'=>6,
        'CA'=>7,
        'la'=>1,
        'ga'=>2,
        'ny'=>3,
        'tx'=>4,
        'tx-2'=>5,
        'nj-2'=>6,
        'ca'=>7
    ];
    public static  $agent = [
        'NAME' => "AFG Global",
        'Address' => "ABC",
        'CITY' => " HOUSTON",
        'PHONE' => "112233",
        'STATE' => "TX",
        'CONTACT' => "HIKMAT",
        
    ];
    public static  $title_type = [
        '1' => 'EXPORTABLE',
        '2' => 'PENDING',
        '3' => 'BOS',
        '4' => 'LIEN',
        '5' => 'MV907',
        '6' => 'REJECTED',
        '0' => '',
	    '' => '',
    ];
    public static  $title_type_front = [
        '1' => 'EXPORTABLE',
        '2' => 'PENDING',
        '3' => 'BOS',
        '4' => 'LIEN',
        '5' => 'MV907',
        '6' => 'REJECTED',
    ];
    public static  $condition = [
        '1' => 'Operable',
        '0' => 'Non-Op',
    ];
    public static $condition_inverse = [
        'Non-Op'=>0,
        'Non-OP'=>0,
        'non-op'=>0,
        'Operable'=>1,
        'operable'=>1
    ];
    public static  $normal_condition = [
        '1' => 'YES',
        '0' => 'NO',
    ];
    public static $yes_no = [
        '0'=>'NO',
        '1'=>'YES',
        ''=>'NO',
    ];
    public static function roleNameFromRole($roles){
        if(isset($roles['admin_GA'])){return 'admin_GA';};
        if(isset($roles['admin_LA'])){return 'admin_LA';};
        if(isset($roles['admin_NY'])){return 'admin_NY';};
        if(isset($roles['admin_TX'])){return 'admin_TX';};
        if(isset($roles['admin_TX2'])){return 'admin_TX2';};
        if(isset($roles['admin_NJ2'])){return 'admin_NJ2';};
        if(isset($roles['admin_CA'])){return 'admin_CA';};
        if(isset($roles['admin_MD'])){return 'admin_MD';};
        if(isset($roles['customer'])){return 'customer';};
        if(isset($roles['super_admin'])){return 'super_admin';};
        if(isset($roles['admin_view_only'])){return 'admin_view_only';};
    }          
    public static function isAdmin(){
        return Yii::$app->user->can('admin_GA') || Yii::$app->user->can('admin_LA') || Yii::$app->user->can('admin_NY') || Yii::$app->user->can('admin_TX') || Yii::$app->user->can('admin_TX2') || Yii::$app->user->can('admin_NJ2') || Yii::$app->user->can('admin_CA') || Yii::$app->user->can('super_admin') || Yii::$app->user->can('sub_admin')|| Yii::$app->user->can('admin_view_only');
    }
}