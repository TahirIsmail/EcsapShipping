<?php

namespace backend\controllers;

use common\models\Vehicle;
use common\models\VehicleSearch;
use kartik\mpdf\Pdf;
use Yii;
$session = Yii::$app->session;
$session->open();

if(!isset($_SESSION)) { 
     echo Yii::$app->urlManager->baseUrl;
     }
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use ZipArchive;
use yii\filters\AccessControl;

/**
 * VehicleController implements the CRUD actions for Vehicle model.
 */
class ImportController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['start','on-hand','on-hand-images','pix'],
                        'allow' => true,
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public static function CopyUser($customerid,&$export,$customer){
        try{
            
            $web_user = Yii::$app->safi->createCommand(
                "select * from web_users where `Customer ID`=$customerid"
            )->queryOne();

            $contacts_table_email = Yii::$app->safi->createCommand(
                "select * from contacts where `Customer ID`=$customerid and Type='email'"
            )->queryOne();
            
            $already = Yii::$app->db->createCommand("
                select * from user where `id` = $customerid;")->queryOne();
            
            $already_email = Yii::$app->db->createCommand("
                select * from user where `email` = '".$contacts_table_email['Data']."'")->queryOne();
            if(!$already){
                if($already_email){
                    $pick_username_from_web_users = $web_user['username']."-".$customerid;
                    $email_is_in_contacts_table = $contacts_table_email['Data']."-".$customerid;
                }else{
                    $pick_username_from_web_users = $web_user['username'];
                    $email_is_in_contacts_table = $contacts_table_email['Data'];
                }
                if(empty($pick_username_from_web_users)){
                    $pick_username_from_web_users = $customerid;
                }
                if(empty($email_is_in_contacts_table)){
                    $email_is_in_contacts_table = $customerid."@AFG Globalworldwideshipping.com";
                }
                //create user for customer and return id
                $user= Yii::$app->db->createCommand("INSERT INTO user 
                SET id=:id,
                    username=:username,
                    auth_key=:auth_key,
                    password_hash=:password_hash,
                    password_reset_token=:password_reset_token,
                    email=:email,
                    status=:status,
                    created_at=:created_at,
                    updated_at=:updated_at,
                    is_deleted=:is_deleted,
                    created_by=:created_by,
                    updated_by=:updated_by,
                    address_line_1=:address_line_1,
                    address_line_2=:address_line_2,
                    city=:city,
                    state=:state,
                    zip_code=:zip_code,
                    phone=:phone,
                    fax=:fax,
                    customer_name=:customer_name
                ")
                ->bindValue(":id",$customerid)
                ->bindValue(":username",$pick_username_from_web_users)
                ->bindValue(":auth_key","")
                ->bindValue(":password_hash",\Yii::$app->security->generatePasswordHash($customerid))
                ->bindValue(":password_reset_token",uniqid().time())
                ->bindValue(":email",$email_is_in_contacts_table)
                ->bindValue(":status",10)
                ->bindValue(":created_at",$customer['ts'])
                ->bindValue(":updated_at",$customer['ts'])
                ->bindValue(":is_deleted","")
                ->bindValue(":created_by",1)
                ->bindValue(":updated_by",1)
                ->bindValue(":address_line_1","")
                ->bindValue(":address_line_2","")
                ->bindValue(":city","")
                ->bindValue(":state","")
                ->bindValue(":zip_code","")
                ->bindValue(":phone","")
                ->bindValue(":fax","")
                ->bindValue(":customer_name",$customer['Company Name'])        
                ->execute();
            }
            
            return $customerid;
        }catch(\Exception $e){
            return 1;
        }
        
    }
    public static function CopyConsignee($customerid,$customer,&$export){
        $consignee = Yii::$app->safi->createCommand(
            "select * from cons_notify where `Customer ID`=$customerid"
        )->queryOne();
        $create = Yii::$app->db->createCommand("INSERT INTO consignee 
        SET id=:id,
            customer_user_id=:customer_user_id,
            consignee_name=:consignee_name,
            consignee_address_1=:consignee_address_1,
            consignee_address_2=:consignee_address_2,
            city=:city,
            state=:state,
            country=:country,
            zip_code=:zip_code,
            phone=:phone,
            created_at=:created_at,
            updated_at=:updated_at,
            created_by=:created_by,
            updated_by=:updated_by,
            consignee_is_deleted=:consignee_is_deleted,
            added_by_role=:added_by_role
            ")
        ->bindValue(":id",$customerid)
        ->bindValue(":customer_user_id",$customerid)//our own id
        ->bindValue(":consignee_name",$consignee['Consignee Name'])
        ->bindValue(":consignee_address_1",$consignee['Consignee Address L1'])
        ->bindValue(":consignee_address_2",$consignee['Consignee Address L2'])
        ->bindValue(":city",$consignee['Consignee City'])
        ->bindValue(":state",$consignee['Consignee State'])
        ->bindValue(":country",$consignee['Consignee Country'])
        ->bindValue(":zip_code",$consignee['Consignee Zip'])
        ->bindValue(":phone",$consignee['Consignee Telephone'])
        ->bindValue(":created_at",date('Y-m-d h:i:s',strtotime($customer['ts'])))
        ->bindValue(":updated_at",date('Y-m-d h:i:s',strtotime($customer['ts'])))
        ->bindValue(":created_by",1)
        ->bindValue(":updated_by",1)
        ->bindValue(":consignee_is_deleted",0)
        ->bindValue(":added_by_role",NULL)
        ->execute();
    }
    public static function CopyCustomer($customerid,&$export){
        //copy customer
        $customer = Yii::$app->safi->createCommand("
            select * from customers where `Customer ID` = $customerid;")
            ->queryOne();
        //create user
        $userid = self::CopyUser($customerid,$export,$customer);
        $contacts_table_phone = Yii::$app->safi->createCommand(
            "select * from contacts where `Customer ID`=$customerid and Type='phone'"
        )->queryOne();
        $phone = $contacts_table_phone['Data'];
        $customer_already = Yii::$app->db->createCommand("
        select * from customer where `user_id` = $userid;")->queryOne();
        if($customer and !$customer_already){
            //insert customer and update needed set to 1
            Yii::$app->db->createCommand("INSERT INTO customer 
            SET user_id=:user_id,
            customer_name=:customer_name,
            company_name=:company_name,
            phone=:phone,
            address_line_1=:address_line_1,
            address_line_2=:address_line_2,
            city=:city,
            state=:state,
            country=:country,
            zip_code=:zip_code,
            tax_id=:tax_id,
            created_at=:created_at,
            updated_at=:updated_at,
            created_by=:created_by,
            updated_by=:updated_by,
            is_deleted=:is_deleted,
            legacy_customer_id=:legacy_customer_id,
            fax=:fax,
            trn=:trn,
            phone_two=:phone_two,
            added_by_role=:added_by_role
            ")
            ->bindValue(":user_id",$userid)
            ->bindValue(":customer_name",$customer['Company Name'])
            ->bindValue(":company_name",$customer['Company Name'])
            ->bindValue(":phone",$phone)// this is again tricky. You need to pick this data from contacts table. And see yourself how tricky t is.
            ->bindValue(":address_line_1",$customer['Address L1'])
            ->bindValue(":address_line_2",$customer['Address L2'])
            ->bindValue(":city",$customer['City'])
            ->bindValue(":state",$customer['State'])
            ->bindValue(":country",$customer['Country'])
            ->bindValue(":zip_code",$customer['Zip Code'])
            ->bindValue(":tax_id",$customer['Tax ID'])
            ->bindValue(":created_at",date('Y-m-d h:i:s',strtotime($customer['ts'])))
            ->bindValue(":updated_at",date('Y-m-d h:i:s',strtotime($customer['ts'])))
            ->bindValue(":created_by",1)
            ->bindValue(":updated_by",1)
            ->bindValue(":is_deleted","")
            ->bindValue(":legacy_customer_id",$customer['Customer ID'])
            ->bindValue(":fax","")//not in previous system
            ->bindValue(":trn","")//not in previous system
            ->bindValue(":phone_two","")//not in previous system
            ->bindValue(":added_by_role","")            
            ->execute();
            Yii::$app->safi->createCommand("UPDATE customers SET update_needed=:update_needed where `Customer ID`=:customer_id")
                ->bindValue(':update_needed',1)
                ->bindValue(':customer_id', $customerid)
                ->execute();
            self::CopyConsignee($customerid,$customer,$export);
        }else{
            return $customer_already;
        }
    }
    public static function CopyVehicleExport($customerid,$car_from_old_db,$our_vehicle,$arnumber,&$export){
        $create = Yii::$app->db->createCommand("INSERT INTO vehicle_export 
        SET vehicle_id=:vehicle_id,
            export_id=:export_id,
            customer_user_id=:customer_user_id,
            custom_duty=:custom_duty,
            clearance=:clearance,
            towing=:towing,
            shipping=:shipping,
            `storage`=:storage,
            `local`=:local,
            others=:others,
            additional=:additional,
            vat=:vat,
            remarks=:remarks,
            title=:title,
            discount=:discount,
            vehicle_export_is_deleted=:vehicle_export_is_deleted,
            notes_status=:notes_status,
            exchange_rate=:exchange_rate
            ")
        ->bindValue(":vehicle_id",$car_from_old_db['id'])
        ->bindValue(":export_id",$export['id'])
        ->bindValue(":customer_user_id",$customerid)
        ->bindValue(":custom_duty",0)
        ->bindValue(":clearance",0)
        ->bindValue(":towing",0)
        ->bindValue(":shipping",0)
        ->bindValue(":storage",0)
        ->bindValue(":local",0)
        ->bindValue(":others",0)
        ->bindValue(":additional",0)
        ->bindValue(":vat",0)
        ->bindValue(":remarks","")
        ->bindValue(":title",0)
        ->bindValue(":discount",0)
        ->bindValue(":vehicle_export_is_deleted",0)
        ->bindValue(":notes_status",0)
        ->bindValue(":exchange_rate",0)        
        ->execute();
    }
    public static function insertFeature($add_or_not,$vehicle_id,$feature_id,$value){
        if($add_or_not){
            $create = Yii::$app->db->createCommand("INSERT INTO vehicle_features
            SET value=:value,
            vehicle_id=:vehicle_id,
            features_id=:features_id
                ")
            ->bindValue(":value",trim($value))
            ->bindValue(":vehicle_id",$vehicle_id)
            ->bindValue(":features_id",$feature_id)//our feature id is in features table. AFG Global old system created the sperate columns for each feature. Safi has written logic for that. Get from there
            ->execute();
        }
    }
    public static function insertCondition($add_or_not,$vehicle_id,$condition_id){
            if($add_or_not){
                $value = $add_or_not;
            }else{
                $value = '';
            }
            $create = Yii::$app->db->createCommand("INSERT INTO vehicle_condition
            SET value=:value,
            vehicle_id=:vehicle_id,
            condition_id=:condition_id
                ")
            ->bindValue(":value",$value)
            ->bindValue(":vehicle_id",$vehicle_id)
            ->bindValue(":condition_id",$condition_id)//our condition id is in conditions table. AFG Global old system created the sperate columns for each condtion. Safi has written logic for that. Get from there
            ->execute();
    }
    public static function CopyVehicleCondition($customerid,$car_from_old_db,$our_vehicle,$arnumber,&$export){
        $index = 1;
        for ($i = 1;$i<=21; $i++){
            self::insertCondition($car_from_old_db['c'.$i],$car_from_old_db['id'],$i);
            $index++;
        }
    }
    public static function CopyVehicleFeatures($customerid,$car_from_old_db,$our_vehicle,$arnumber,&$export){
        self::insertFeature($car_from_old_db['Keys'],$car_from_old_db['id'],1,1);
        self::insertFeature($car_from_old_db['CD Changer'],$car_from_old_db['id'],2,1);
        self::insertFeature($car_from_old_db['GPS Navigation System'],$car_from_old_db['id'],3,1);
        self::insertFeature($car_from_old_db['Spare Tire/Jack'],$car_from_old_db['id'],4,1);
        self::insertFeature($car_from_old_db['Wheel Covers'],$car_from_old_db['id'],5,1);
        self::insertFeature($car_from_old_db['Radio'],$car_from_old_db['id'],6,1);
        self::insertFeature($car_from_old_db['CD Player'],$car_from_old_db['id'],7,1);
        self::insertFeature($car_from_old_db['Mirror'],$car_from_old_db['id'],8,1);
        self::insertFeature($car_from_old_db['Speakers'],$car_from_old_db['id'],9,1);
        self::insertFeature($car_from_old_db['Other'],$car_from_old_db['id'],10,1);
    }
    public static function CopyVehicleAdditions($customerid,$car_from_old_db,$our_vehicle,$arnumber,&$export){
        //insert vehicle condition
        self::CopyVehicleCondition($customerid,$car_from_old_db,$our_vehicle,$arnumber,$export);
        //insert vehicle features
        self::CopyVehicleFeatures($customerid,$car_from_old_db,$our_vehicle,$arnumber,$export);
    }
    public static function CopySingleVehicleTowingRequest($car_from_old_db,$carid,$arnumber,&$export){
        $carid = $car_from_old_db['id'];
        $already = Yii::$app->db->createCommand("
        select * from towing_request where `id` = $carid;")->queryOne();
        if(!$already){
        $towing_create = Yii::$app->db->createCommand("INSERT INTO towing_request 
        SET id=:id,
            `condition`=:condition,
            damaged=:damaged,
            pictures=:pictures,
            towed=:towed,
            title_recieved=:title_recieved,
            title_recieved_date=:title_recieved_date,
            title_number=:title_number,
            title_state=:title_state,
            towing_request_date=:towing_request_date,
            pickup_date=:pickup_date,
            deliver_date=:deliver_date,
            note=:note,
            title_type=:title_type")
        ->bindValue(":id",$carid)
        ->bindValue(":condition",\common\models\Lookup::$condition_inverse[$car_from_old_db['Condition']])
        ->bindValue(":damaged",$car_from_old_db['Damage']=='Yes'?1:0)//integer in our case
        ->bindValue(":pictures",$car_from_old_db['pictures']=='Yes'?1:0)//it is boolean in our case
        ->bindValue(":towed",$car_from_old_db['Towed']=='Yes'?1:0)//boolean in our case
        ->bindValue(":title_recieved",$car_from_old_db['Title Received']=='Yes'?1:0)//boolean in our case 1 in case of yes and 0 in case of No
        ->bindValue(":title_recieved_date",$car_from_old_db['Title Received Date']?date('Y-m-d',strtotime($car_from_old_db['Title Received Date'])):Date('Y-m-d h:i:s'))
        ->bindValue(":title_number",$car_from_old_db['Title Number'])
        ->bindValue(":title_state",$car_from_old_db['Title State'])
        ->bindValue(":towing_request_date",$car_from_old_db['Towing Request Date']?date('Y-m-d',strtotime($car_from_old_db['Towing Request Date'])):Date('Y-m-d h:i:s'))
        ->bindValue(":pickup_date",$car_from_old_db['Pickup Date']?date('Y-m-d',strtotime($car_from_old_db['Pickup Date'])):date('Y-m-d h:i:s'))
        ->bindValue(":deliver_date",$car_from_old_db['Deliver Date']?date('Y-m-d',strtotime($car_from_old_db['Deliver Date'])):date('Y-m-d h:i:s'))
        ->bindValue(":note",$car_from_old_db['notes'])
        ->bindValue(":title_type",0)      //not in the previous system  
        ->execute();
        }
    }
    public static function CopySingleVehicle($customerid,$car_from_old_db,$arnumber,&$export){
            if(!isset($export['Date Prepared'])){
                $export['Date Prepared'] = $car_from_old_db['Date Received'];
            }
            $vin = $car_from_old_db['VIN'];
            $already = Yii::$app->db->createCommand("
            select * from vehicle where `vin` = '$vin';")->queryOne();
            if(!$already){
                $location_from_vin_rel_location = Yii::$app->safi->createCommand("
                select * from vin_rel_location where `VIN` = '$vin';")->queryOne();
                $customer_exists = Yii::$app->db->createCommand("
                select * from customer where `legacy_customer_id` = $customerid;")->queryOne();
                if(!$customer_exists){
                    echo "".$customerid.",";
                    return;
                }
                
                $carid = $car_from_old_db['id'];
                self::CopySingleVehicleTowingRequest($car_from_old_db,$carid,$arnumber,$export);
                $tamount = preg_replace('/[^0-9]/', '', $car_from_old_db['Tow Amount']);
                $our_vehicle_create = Yii::$app->db->createCommand("INSERT INTO vehicle 
                SET id=:id,
                    hat_number=:hat_number,
                    year=:year,
                    color=:color,
                    model=:model,
                    make=:make,
                    vin=:vin,
                    weight=:weight,
                    pieces=:pieces,
                    value=:value,
                    license_number=:license_number,
                    towed_from=:towed_from,
                    lot_number=:lot_number,
                    towed_amount=:towed_amount,
                    storage_amount=:storage_amount,
                    status=:status,
                    check_number=:check_number,
                    additional_charges=:additional_charges,
                    location=:location,
                    customer_user_id=:customer_user_id,
                    towing_request_id=:towing_request_id,
                    created_at=:created_at,
                    updated_at=:updated_at,
                    created_by=:created_by,
                    updated_by=:updated_by,
                    is_export=:is_export,
                    title_amount=:title_amount,
                    container_number=:container_number,
                    `keys`=:keys,
                    vehicle_is_deleted=:vehicle_is_deleted,
                    notes_status=:notes_status,
                    added_by_role=:added_by_role
                ")
                ->bindValue(":id",$car_from_old_db['id'])// there is no Id in car_info in  this case we need to create our own
                ->bindValue(":hat_number",$car_from_old_db['Hat Number'])
                ->bindValue(":year",$car_from_old_db['Year'])
                ->bindValue(":color",$car_from_old_db['Color'])
                ->bindValue(":model",$car_from_old_db['Model'])
                ->bindValue(":make",$car_from_old_db['Make'])
                ->bindValue(":vin",$car_from_old_db['VIN'])
                ->bindValue(":weight",$car_from_old_db['Weight'])
                ->bindValue(":pieces","")
                ->bindValue(":value",$car_from_old_db['Value'])
                ->bindValue(":license_number",$car_from_old_db['License Number'])
                ->bindValue(":towed_from",$car_from_old_db['Towed From'])
                ->bindValue(":lot_number",$car_from_old_db['Lot Number'])
                ->bindValue(":towed_amount",$tamount?$tamount:0)// this is double in our case but in previous system some string values were also there so safi skipped those values. You have choice here either you convert it to varchar(this will impact the invoice calculation) or skip the varchar values or pick number from the string is another option. Same case for all amount related fields  especially additional charges
                ->bindValue(":storage_amount",$car_from_old_db['AFG Global Storage'])
                ->bindValue(":status",\common\models\Lookup::$status_invert[$car_from_old_db['Status']])
                ->bindValue(":check_number",$car_from_old_db['Check Number']?$car_from_old_db['Check Number']:NULL)
                ->bindValue(":additional_charges",0)//$car_from_old_db['Additional Charges'] can't work
                ->bindValue(":location",\common\models\Lookup::$location_inverse[trim(strtolower($location_from_vin_rel_location['loc_code']))])
                ->bindValue(":customer_user_id",$customer_exists['user_id'])
                ->bindValue(":towing_request_id",$car_from_old_db['id'])//from where towing request id
                ->bindValue(":created_at",date('Y-m-d h:i:s',strtotime($export['Date Prepared'])))
                ->bindValue(":updated_at",date('Y-m-d h:i:s',strtotime($export['Date Prepared'])))
                ->bindValue(":created_by",1)
                ->bindValue(":updated_by",1)
                ->bindValue(":is_export",1)
                ->bindValue(":title_amount","")
                ->bindValue(":container_number",$car_from_old_db['Container Number'])
                ->bindValue(":keys",$car_from_old_db['Keys']?1:0)
                ->bindValue(":vehicle_is_deleted",0)
                ->bindValue(":notes_status",0)
                ->bindValue(":added_by_role","")          
                ->execute();
                if(!$our_vehicle_create){
                    echo "|".$car_from_old_db['VIN']."|";
                }
                self::CopyVehicleAdditions($customerid,$car_from_old_db,$carid,$arnumber,$export);
                
            }else{
                echo "Duplicate found";
            }
            
    }
    public static function CopyContainerVehicles($customerid,$arnumber,&$export){
        //copy all vehicles in a container
        $connection = Yii::$app->safi->createCommand("
        select * from car_info where `AR Number` = '$arnumber';");
        $result = $connection->queryAll();
        foreach($result as $car_from_old_db){
            self::CopySingleVehicle($customerid,$car_from_old_db,$arnumber,$export);
            self::CopyVehicleExport($customerid,$car_from_old_db,1,$arnumber,$export);
        }
    }
    public static function CopyExportItself($customerid,&$export){
        $already = Yii::$app->db->createCommand("
        select * from export where `id` = ".$export['id'].";")->queryOne();
        if(!$already){
            Yii::$app->db->createCommand("INSERT INTO export
            SET    id=:id,
                   export_date=:export_date,
                   loading_date=:loading_date,
                   broker_name=:broker_name,
                   booking_number=:booking_number,
                   eta=:eta,
                   ar_number=:ar_number,
                   xtn_number=:xtn_number,
                   seal_number=:seal_number,
                   container_number=:container_number,
                   cutt_off=:cutt_off,
                   vessel=:vessel,
                   voyage=:voyage,
                   terminal=:terminal,
                   streamship_line=:streamship_line,
                   destination=:destination,
                   itn=:itn,
                   contact_details=:contact_details,
                   special_instruction=:special_instruction,
                   container_type=:container_type,
                   port_of_loading=:port_of_loading,
                   port_of_discharge=:port_of_discharge,
                   export_invoice=:export_invoice,
                   bol_note=:bol_note,
                   export_is_deleted=:export_is_deleted,
                   created_by=:created_by,
                   updated_by=:updated_by,
                   created_at=:created_at,
                   updated_at=:updated_at,
                   legacy_customer_id=:legacy_customer_id,
                   added_by_role=:added_by_role,
                   customer_user_id=:customer_user_id")
                  ->bindValue(":id",$export['id'])
                  ->bindValue(":export_date",date('Y-m-d', strtotime($export['Export Date'])))
                  ->bindValue(":loading_date",date('Y-m-d',strtotime($export['Loading Date'])))
                  ->bindValue(":broker_name",$export['Broker Name'])
                  ->bindValue(":booking_number",$export['Booking Number'])
                  ->bindValue(":eta",date('Y-m-d',strtotime($export['ETA'])))
                  ->bindValue(":ar_number",$export['AR Number'])
                  ->bindValue(":xtn_number",$export['XTN Number'])
                  ->bindValue(":seal_number",$export['Seal Number'])
                  ->bindValue(":container_number",$export['Container Number'])
                  ->bindValue(":cutt_off",date('Y-m-d', strtotime($export['Cut Off'])))
                  ->bindValue(":vessel",$export['Vessel'])
                  ->bindValue(":voyage",$export['Voyage'])
                  ->bindValue(":terminal",$export['Terminal'])
                  ->bindValue(":streamship_line",$export['Steamship Line'])
                  ->bindValue(":destination",$export['Destination'])
                  ->bindValue(":itn",$export['ITN'])
                  ->bindValue(":contact_details","")
                  ->bindValue(":special_instruction",$export['SPECINS'])
                  ->bindValue(":container_type",$export['Container Type'])
                  ->bindValue(":port_of_loading",$export['Port of Loading'])
                  ->bindValue(":port_of_discharge",$export['Port of Discharge'])
                  ->bindValue(":export_invoice","")
                  ->bindValue(":bol_note",$export['BOL Note'])
                  ->bindValue(":export_is_deleted",0)
                  ->bindValue(":created_by",1)
                  ->bindValue(":updated_by",1)
                  ->bindValue(":created_at",$export['DATE']?date('Y-m-d h:i:s',strtotime($export['DATE'])):date('Y-m-d h:i:s'))
                  ->bindValue(":updated_at",$export['DATE']?date('Y-m-d h:i:s',strtotime($export['DATE'])):date('Y-m-d h:i:s'))
                  ->bindValue(":legacy_customer_id",$export['Customer ID'])
                  ->bindValue(":added_by_role","")
                  ->bindValue(":customer_user_id",$customerid)// this is our own user id
                  ->execute();
        }
        
    }
    public static function CopyDocReceipt($customerid,&$export){
        $already = Yii::$app->db->createCommand("
        select * from dock_receipt where `export_id` = ".$export['id'].";")->queryOne();
        if(!$already){
            Yii::$app->db->createCommand("INSERT INTO dock_receipt
            SET    export_id=:export_id,
                   awb_number=:awb_number,
                   export_reference=:export_reference,
                   forwarding_agent=:forwarding_agent,
                   domestic_routing_insctructions=:domestic_routing_insctructions,
                   pre_carriage_by=:pre_carriage_by,
                   place_of_receipt_by_pre_carrier=:place_of_receipt_by_pre_carrier,
                   exporting_carrier=:exporting_carrier,
                   final_destination=:final_destination,
                   loading_terminal=:loading_terminal,
                   container_type=:container_type,
                   number_of_packages=:number_of_packages,
                   `by`=:by,
                   `date`=:date,
                   auto_recieving_date=:auto_recieving_date,
                   auto_cut_off=:auto_cut_off,
                   vessel_cut_off=:vessel_cut_off,
                   sale_date=:sale_date")
                   ->bindValue(':export_id',$export['id'])
                   ->bindValue(':awb_number',$export['BLorAWBnumber'])
                   ->bindValue(':export_reference','')
                   ->bindValue(':forwarding_agent',$export['Forwarding Agent'])
                   ->bindValue(':domestic_routing_insctructions','')
                   ->bindValue(':pre_carriage_by','')
                   ->bindValue(':place_of_receipt_by_pre_carrier',$export['PlaceOfReceiptPreCarrier'])
                   ->bindValue(':exporting_carrier',$export['ExportingCarrier'])
                   ->bindValue(':final_destination',$export['FinalDestination'])
                   ->bindValue(':loading_terminal',$export['LoadingTerminal'])
                   ->bindValue(':container_type',$export['ContainerType'])
                   ->bindValue(':number_of_packages',$export['Number of packages'])
                   ->bindValue(':by',$export['BY'])
                   ->bindValue(':date',$export['DATE']?date('Y-m-d h:i:s',strtotime($export['DATE'])):date('Y-m-d h:i:s'))
                   ->bindValue(':auto_recieving_date',$export['AUTO RECEIVING DATE']?date('Y-m-d',strtotime($export['AUTO RECEIVING DATE'])):date('Y-m-d h:i:s'))
                   ->bindValue(':auto_cut_off',$export['AUTO CUT OFF']?$export['AUTO CUT OFF']:date('Y-m-d h:i:s'))
                   ->bindValue(':vessel_cut_off',$export['VESSEL CUT OFF']?date('Y-m-d',strtotime($export['VESSEL CUT OFF'])):date('Y-m-d h:i:s'))
                   ->bindValue(':sale_date',$export['SAIL DATE']?$export['SAIL DATE']:date('Y-m-d h:i:s'))
                   ->execute();
        }
        
    }
    public static function CopyHuston($customerid,&$export){
        $already = Yii::$app->db->createCommand("
        select * from houstan_custom_cover_letter where `export_id` = ".$export['id'].";")->queryOne();
        if(!$already){
            Yii::$app->db->createCommand("INSERT INTO houstan_custom_cover_letter
            SET export_id=:export_id,
               vehicle_location=:vehicle_location,
               exporter_id=:exporter_id,
               exporter_type_issuer=:exporter_type_issuer,
               transportation_value=:transportation_value,
               exporter_dob=:exporter_dob,
               ultimate_consignee_dob=:ultimate_consignee_dob,
               consignee=:consignee,
               notify_party=:notify_party,
               menifest_consignee=:menifest_consignee")
               ->bindValue(":export_id",$export['id'])
               ->bindValue(":vehicle_location","'".$export['Vehicle Location']."'")
               ->bindValue(":exporter_id",$export['id'])
               ->bindValue(":exporter_type_issuer",$export['Exporter Type Issuer'])
               ->bindValue(":transportation_value",$export['Transportation Value'])
               ->bindValue(":exporter_dob",$export['Shipper Exp Dob'])
               ->bindValue(":ultimate_consignee_dob",$export['Ultimate Consignee Dob'])
               ->bindValue(":consignee","'".$export['Consignee']."'")
               ->bindValue(":notify_party","'".$export['Notify Party']."'")
               ->bindValue(":menifest_consignee","'".$export['Manifest Consignee']."'")
               ->execute();
        }
        
    }
    public static function CloseContainer($id){
        Yii::$app->safi->createCommand("UPDATE export SET update_needed=:update_needed where `id`=:id")
                ->bindValue(':update_needed',1)
                ->bindValue(':id', $id)
                ->execute();
    }
    public function actionStart(){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit','-1');
        $connection = Yii::$app->safi->createCommand("
        select * from export where update_needed = '';");
        $result = $connection->queryAll();
        foreach($result as $c){
            self::CopyCustomer($c['Customer ID'],$c);
            self::CopyExportItself($c['Customer ID'],$c);
            self::CopyDocReceipt($c['Customer ID'],$c);
            self::CopyHuston($c['Customer ID'],$c);
            self::CopyContainerVehicles($c['Customer ID'],$c['AR Number'],$c);
            self::CloseContainer($c['id']);
        }
    }
    public static function UR_exists($url){
        $headers=get_headers($url);
        return stripos($headers[0],"200 OK")?true:false;
     }
    public function actionOnHandImages(){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit','-1');
        $result = Yii::$app->safi->createCommand("
        select * from car_info join vin_rel_location on vin_rel_location.vin = car_info.vin where status = 'ON HAND';")->queryAll();
        foreach($result as $r){
            $folder = 'pics/'.$r['VIN'];
            try{
                if(!file_exists($folder)){
                    mkdir ($folder, 0755);
                }
                for($i=1;$i<16;$i++){
                    $url = 'http://manage.AFG Globalworldwide.com/veh_images2/'.$r['VIN'].'/pic'.$i.'.jpeg';
                    $img = $folder.'/pic'.$i.'.jpeg';
                    if(!file_exists($img)){
                        if(self::UR_exists($url)){
                            file_put_contents($img, file_get_contents($url));
                        }else{
                            echo $url.",";
                        }
                    }
                }
            }catch(\Exception $e){
                echo $r['VIN'].',';
                continue;
            }
            
        }
        
    }
    public function actionPix(){
        exit();
        $dirs = array_filter(glob('uploads/photos/*'), 'is_dir');
        foreach($dirs as $pics){
            $vin = basename($pics);
            $already = Yii::$app->db->createCommand("
        select * from vehicle where `vin` like '".$vin."';")->queryOne();
        if($already){
                foreach(glob($pics."/*") as $pic_path){
                    $picname = basename($pic_path);
                    Yii::$app->db->createCommand("INSERT INTO images
                        SET 
                        name=:name,
                        thumbnail=:thumbnail,
                        normal=:normal,
                        vehicle_id=:vehicle_id")
                        ->bindValue(":name","photos/".$vin."/".$picname)
                        ->bindValue(":thumbnail","photos/".$vin."/".$picname)
                        ->bindValue(":normal",NULL)
                        ->bindValue(":vehicle_id",$already['id'])
                        ->execute();
                    echo "<br/>";
                }
                echo "<br/>";
            }else{
                echo "not<br/>";
            }
        }
        //$folder = 'pics/'.$r['VIN'];
        //$img = $folder.'/pic'.$i.'.jpeg';
        exit();
    }
    public function actionOnHand(){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit','-1');
        $result = Yii::$app->safi->createCommand("
        select * from car_info join vin_rel_location on vin_rel_location.vin = car_info.vin where status like 'ON HAND';")->queryAll();
        //var_dump($result);
        $carsonhand = [];
        foreach($result as $c){
            $v = Yii::$app->db->createCommand("
            select * from vehicle where vin='".$c['VIN']."';")->queryOne();
            if($v){
                $carsonhand[]=$v;
            }else{
                $xyz = NULL;
                if($c['Customer ID']){
                    self::CopySingleVehicle($c['Customer ID'],$c,$c['AR Number'],$xyz);
                }
            }
        }
        $array = $carsonhand;
        $html = '<table>';
    // header row
    $html .= '<tr>';
    if(isset($array[0]))
    foreach($array[0] as $key=>$value){
            $html .= '<th>' . htmlspecialchars($key) . '</th>';
        }
    $html .= '</tr>';

    // data rows
    foreach( $array as $key=>$value){
        $html .= '<tr>';
        foreach($value as $key2=>$value2){
            $html .= '<td>' . htmlspecialchars($value2) . '</td>';
        }
        $html .= '</tr>';
    }

    // finish table and return it

    $html .= '</table>';
    echo $html;
    exit();
    }
}