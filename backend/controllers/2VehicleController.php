<?php

namespace backend\controllers;
use Yii;
$session = Yii::$app->session;
$session->open();

if(!isset($_SESSION)) { 
     echo Yii::$app->urlManager->baseUrl;
     } 
use common\models\Vehicle;
use common\models\VehicleSearch;
use kartik\mpdf\Pdf;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use ZipArchive;

/**
 * VehicleController implements the CRUD actions for Vehicle model.
 */
class VehicleController extends \backend\components\AmayaController
{
    
    public function actionExportExcel()
    {
        $user_id = Yii::$app->user->getId();
        $user_detail = \common\models\User::find()->where(['id' => $user_id])->one();
        if ($user_detail->status == 0) {
            return $this->redirect(['index']);
        }
        
        try {
            $searchModel = new VehicleSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams,50000);
            $models = $dataProvider->getModels();

           // echo count($models);exit();
            $excelArray = array();
            foreach ($models as $model) {
                $data = new \common\models\helpers\VehicleExcel();
                $data->color = $model['color'];
                $data->hat_number = $model->hat_number;
                $data->tow_req_date = $model->towingRequest->towing_request_date;
                $data->received_date = $model->towingRequest->deliver_date;
                $data->year = $model['year'];
                $data->make = $model['make'];
                $data->model = $model['model'];
                $data->customer_name = $model->customerUser->customer_name;
                $data->vin = $model['vin'];
                $data->lot_number = $model->lot_number;
                $data->vehicle_type = $model->vehicle_type;
                $data->title_type = isset(\common\models\Lookup::$title_type_front[$model->towingRequest->title_type]) ? \common\models\Lookup::$title_type_front[$model->towingRequest->title_type] : 'NO-TITLE';
                $data->buyer_id = $model->license_number;
                $data->loading_status = ($model->status == 1 && ($model->towingRequest->title_type == 1 || $model->towingRequest->title_recieved == 1)) ? strtoupper($model->load_status) : '';
                if ($model->keys == 1) {
                    $data->keys = 'Yes';
                } else {
                    $data->keys = 'No';
                }
                $data->loc = \common\models\Location::getLocationById($model->location);

                $vehicle_export = \common\models\VehicleExport::find()->joinWith(['export'])->where("vehicle_export_is_deleted!=1")->andWhere(['vehicle_id' => $model->id])->asArray()->one();
               

                 if ($model->status == '4' && $vehicle_export['export']['eta'] <= date("Y-m-d")) {
               $data->status = 'Arrived';
                    
        } else if ($model->status == '4' && $vehicle_export['export']['eta'] > date("Y-m-d")) {
                $data->status = 'Shipped';
        } else {
                 $data->status = isset(\common\models\Lookup::$status[$model->status]) ? \common\models\Lookup::$status[$model->status] : $model->status;
        }

                $data->manifest_date = isset($vehicle_export['export']['created_at']) ? date('Y-m-d',
                    strtotime($vehicle_export['export']['created_at'])) : '';
                $data->container_number = $model->container_number;
                $data->created_at = date('Y-m-d', strtotime($model->created_at));
                $excelArray[] = $data;
            }
            require_once Yii::getAlias('@vendor/phpoffice/phpexcel/Classes/PHPExcel.php');
            \moonland\phpexcel\Excel::widget([
                'models' => $excelArray,
                'mode' => 'export',
            ]);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function actionMoveUpload()
    {
        $vid = 180967;
        $vehicle = \common\models\Vehicle::findOne($vid);
        $images = Yii::$app->db->createCommand('select * from images where vehicle_id='.$vid)->queryAll();
        foreach ($images as $image) {
            $path_with_image = 'uploads/'.$image['name'];
            $path_with_thumb = 'uploads/'.$image['thumbnail'];
            $new_path = 'uploads/c'.$vehicle->customer_user_id;
            echo '<br/>';
            if (file_exists($path_with_image)) {
                if (!file_exists($new_path)) {
                    mkdir($new_path);
                }
            }
            $updated_db_image = 'c'.$vehicle->customer_user_id.'/'.$image['name'];
            $updated_db_thumb = 'c'.$vehicle->customer_user_id.'/'.$image['thumbnail'];
            copy($path_with_image, $new_path.'/'.$image['name']);
            copy($path_with_thumb, $new_path.'/'.$image['thumbnail']);
            Yii::$app->db->createCommand("update images set name='".$updated_db_image."',thumbnail='".$updated_db_thumb."'  where id=".$image['id'])->query();
            //$path_with_image_updated = \yii\helpers\Url::to('@web/../uploads/'.$vehicle->vin."/".$image['name'], true);
            //copy($path_with_image, $path_with_image_updated);
            //echo $path_with_image_updated;
        }
        //var_dump($images);
    }

    public function actionBar()
    {
        $text = (isset($_GET['text']) ? $_GET['text'] : '0');
        $size = (isset($_GET['size']) ? $_GET['size'] : '20');
        $width_scale = (isset($_GET['width_scale']) ? $_GET['width_scale'] : 1.0);

        $orientation = (isset($_GET['orientation']) ? $_GET['orientation'] : 'horizontal');
        $code_type = (isset($_GET['codetype']) ? $_GET['codetype'] : 'code128');
        $code_string = '';

        if (strtolower($code_type) == 'code128') {
            $chksum = 104;
            // Must not change order of array elements as the checksum depends on the array's key to validate final code
            $code_array = array(' ' => '212222', '!' => '222122', '"' => '222221', '#' => '121223', '$' => '121322', '%' => '131222', '&' => '122213', "'" => '122312', '(' => '132212', ')' => '221213', '*' => '221312', '+' => '231212', ',' => '112232', '-' => '122132', '.' => '122231', '/' => '113222', '0' => '123122', '1' => '123221', '2' => '223211', '3' => '221132', '4' => '221231', '5' => '213212', '6' => '223112', '7' => '312131', '8' => '311222', '9' => '321122', ':' => '321221', ';' => '312212', '<' => '322112', '=' => '322211', '>' => '212123', '?' => '212321', '@' => '232121', 'A' => '111323', 'B' => '131123', 'C' => '131321', 'D' => '112313', 'E' => '132113', 'F' => '132311', 'G' => '211313', 'H' => '231113', 'I' => '231311', 'J' => '112133', 'K' => '112331', 'L' => '132131', 'M' => '113123', 'N' => '113321', 'O' => '133121', 'P' => '313121', 'Q' => '211331', 'R' => '231131', 'S' => '213113', 'T' => '213311', 'U' => '213131', 'V' => '311123', 'W' => '311321', 'X' => '331121', 'Y' => '312113', 'Z' => '312311', '[' => '332111', '\\' => '314111', ']' => '221411', '^' => '431111', '_' => '111224', "\`" => '111422', 'a' => '121124', 'b' => '121421', 'c' => '141122', 'd' => '141221', 'e' => '112214', 'f' => '112412', 'g' => '122114', 'h' => '122411', 'i' => '142112', 'j' => '142211', 'k' => '241211', 'l' => '221114', 'm' => '413111', 'n' => '241112', 'o' => '134111', 'p' => '111242', 'q' => '121142', 'r' => '121241', 's' => '114212', 't' => '124112', 'u' => '124211', 'v' => '411212', 'w' => '421112', 'x' => '421211', 'y' => '212141', 'z' => '214121', '{' => '412121', '|' => '111143', '}' => '111341', '~' => '131141', 'DEL' => '114113', 'FNC 3' => '114311', 'FNC 2' => '411113', 'SHIFT' => '411311', 'CODE C' => '113141', 'FNC 4' => '114131', 'CODE A' => '311141', 'FNC 1' => '411131', 'Start A' => '211412', 'Start B' => '211214', 'Start C' => '211232', 'Stop' => '2331112');
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ($X = 1; $X <= strlen($text); ++$X) {
                $activeKey = substr($text, ($X - 1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum = ($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

            $code_string = '211214'.$code_string.'2331112';
        } elseif (strtolower($code_type) == 'code39') {
            $code_array = array('0' => '111221211', '1' => '211211112', '2' => '112211112', '3' => '212211111', '4' => '111221112', '5' => '211221111', '6' => '112221111', '7' => '111211212', '8' => '211211211', '9' => '112211211', 'A' => '211112112', 'B' => '112112112', 'C' => '212112111', 'D' => '111122112', 'E' => '211122111', 'F' => '112122111', 'G' => '111112212', 'H' => '211112211', 'I' => '112112211', 'J' => '111122211', 'K' => '211111122', 'L' => '112111122', 'M' => '212111121', 'N' => '111121122', 'O' => '211121121', 'P' => '112121121', 'Q' => '111111222', 'R' => '211111221', 'S' => '112111221', 'T' => '111121221', 'U' => '221111112', 'V' => '122111112', 'W' => '222111111', 'X' => '121121112', 'Y' => '221121111', 'Z' => '122121111', '-' => '121111212', '.' => '221111211', ' ' => '122111211', '$' => '121212111', '/' => '121211121', '+' => '121112121', '%' => '111212121', '*' => '121121211');

            // Convert to uppercase
            $upper_text = strtoupper($text);

            for ($X = 1; $X <= strlen($upper_text); ++$X) {
                $code_string .= $code_array[substr($upper_text, ($X - 1), 1)].'1';
            }

            $code_string = '1211212111'.$code_string.'121121211';
        } elseif (strtolower($code_type) == 'code25') {
            $code_array1 = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
            $code_array2 = array('3-1-1-1-3', '1-3-1-1-3', '3-3-1-1-1', '1-1-3-1-3', '3-1-3-1-1', '1-3-3-1-1', '1-1-1-3-3', '3-1-1-3-1', '1-3-1-3-1', '1-1-3-3-1');

            for ($X = 1; $X <= strlen($text); ++$X) {
                for ($Y = 0; $Y < count($code_array1); ++$Y) {
                    if (substr($text, ($X - 1), 1) == $code_array1[$Y]) {
                        $temp[$X] = $code_array2[$Y];
                    }
                }
            }

            for ($X = 1; $X <= strlen($text); $X += 2) {
                $temp1 = explode('-', $temp[$X]);
                $temp2 = explode('-', $temp[($X + 1)]);
                for ($Y = 0; $Y < count($temp1); ++$Y) {
                    $code_string .= $temp1[$Y].$temp2[$Y];
                }
            }

            $code_string = '1111'.$code_string.'311';
        } elseif (strtolower($code_type) == 'codabar') {
            $code_array1 = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-', '$', ':', '/', '.', '+', 'A', 'B', 'C', 'D');
            $code_array2 = array('1111221', '1112112', '2211111', '1121121', '2111121', '1211112', '1211211', '1221111', '2112111', '1111122', '1112211', '1122111', '2111212', '2121112', '2121211', '1121212', '1122121', '1212112', '1112122', '1112221');

            // Convert to uppercase
            $upper_text = strtoupper($text);

            for ($X = 1; $X <= strlen($upper_text); ++$X) {
                for ($Y = 0; $Y < count($code_array1); ++$Y) {
                    if (substr($upper_text, ($X - 1), 1) == $code_array1[$Y]) {
                        $code_string .= $code_array2[$Y].'1';
                    }
                }
            }
            $code_string = '11221211'.$code_string.'1122121';
        }

        // Pad the edges of the barcode
        $code_length = 10;
        for ($i = 1; $i <= strlen($code_string); ++$i) {
            $code_length = $code_length + (int) (substr($code_string, ($i - 1), 1));
        }

        if (strtolower($orientation) == 'horizontal') {
            $img_width = $code_length * $width_scale;
            $img_height = $size;
        } else {
            $img_width = $size;
            $img_height = $code_length * $width_scale;
        }

        $image = \imagecreate($img_width, $img_height);
        $black = \imagecolorallocate($image, 0, 0, 0);
        $white = \imagecolorallocate($image, 255, 255, 255);

        imagefill($image, 0, 0, $white);

        $location = 5;
        for ($position = 1; $position <= strlen($code_string); ++$position) {
            $cur_size = $location + (substr($code_string, ($position - 1), 1));
            if (strtolower($orientation) == 'horizontal') {
                imagefilledrectangle($image, $location * $width_scale, 0, $cur_size * $width_scale, $img_height, ($position % 2 == 0 ? $white : $black));
            } else {
                imagefilledrectangle($image, 0, $location * $width_scale, $img_width, $cur_size * $width_scale, ($position % 2 == 0 ? $white : $black));
            }
            $location = $cur_size;
        }
        // Draw barcode to the screen
        header('Content-type: image/png');
        imagepng($image);
        imagedestroy($image);
    }

    public function actionAddToCart()
    {
        $id = Yii::$app->request->post('id');
        $array = Yii::$app->session['cart'];
        if ($array) {
            if (!in_array($id, $array)) {
                $array[] = $id;
            }
        } else {
            $array[] = $id;
        }
        Yii::$app->session['cart'] = $array;

        return sizeof(Yii::$app->session['cart']);
    }

    public function actionRemoveFromCart()
    {
        $id = Yii::$app->request->post('id');
        $array = Yii::$app->session['cart'];
        if ($array) {
            $key = array_search($id, $array);
            if (false !== $key) {
                unset($array[$key]);
            }
        }

        Yii::$app->session['cart'] = $array;

        return sizeof(Yii::$app->session['cart']);
    }

    /**
     * Lists all Vehicle models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VehicleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->pagination->pageSize=500;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionVehicle()
    {
        $searchModel = new VehicleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('vehicle', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdateLoadStatus()
    {
        $id = Yii::$app->request->post('id');
        $load_status = Yii::$app->request->post('load_status');
        $update_exported_vehicle = Yii::$app->db->createCommand()
            ->update('vehicle', ['load_status' => $load_status,
            ], 'id ="'.$id.'"')
            ->execute();

        return $load_status;
    }

    public function actionFrontsearch()
    {
        $vin_get = Yii::$app->request->get('vin');

        $vin = \yii\helpers\Html::encode($vin_get);

        $vehicle_detail = \common\models\Vehicle::find()->orWhere(['or', ['vin' => $vin], ['lot_number' => $vin]])->asArray()->one();

        if ($vehicle_detail) {
            return $this->render('front_view',
                ['model' => $this->findModel($vehicle_detail['id'])]);
        } else {
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionBringExport()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $connection = Yii::$app->safi->createCommand('
        select * from export;');
        $result = $connection->queryAll();
        foreach ($result as $c) {
            Yii::$app->db->createCommand('INSERT INTO export
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
                    customer_user_id=:customer_user_id')
                   ->bindValue(':id', $c['id'])
                   ->bindValue(':export_date', $c['Export Date'])
                   ->bindValue(':loading_date', $c['Loading Date'])
                   ->bindValue(':broker_name', $c['Broker Name'])
                   ->bindValue(':booking_number', $c['Booking Number'])
                   ->bindValue(':eta', $c['ETA'])
                   ->bindValue(':ar_number', $c['AR Number'])
                   ->bindValue(':xtn_number', $c['XTN Number'])
                   ->bindValue(':seal_number', $c['Seal Number'])
                   ->bindValue(':container_number', $c['Container Number'])
                   ->bindValue(':cutt_off', $c['Cut Off'])
                   ->bindValue(':vessel', $c['Vessel'])
                   ->bindValue(':voyage', $c['Voyage'])
                   ->bindValue(':terminal', $c['Terminal'])
                   ->bindValue(':streamship_line', $c['Steamship Line'])
                   ->bindValue(':destination', $c['Destination'])
                   ->bindValue(':itn', $c['ITN'])
                   ->bindValue(':contact_details', '')
                   ->bindValue(':special_instruction', $c['SPECINS'])
                   ->bindValue(':container_type', $c['Container Type'])
                   ->bindValue(':port_of_loading', $c['Port of Loading'])
                   ->bindValue(':port_of_discharge', $c['Port of Discharge'])
                   ->bindValue(':export_invoice', '')
                   ->bindValue(':bol_note', $c['BOL Note'])
                   ->bindValue(':export_is_deleted', 0)
                   ->bindValue(':created_by', '')
                   ->bindValue(':updated_by', '')
                   ->bindValue(':created_at', '')
                   ->bindValue(':updated_at', '')
                   ->bindValue(':legacy_customer_id', $c['Customer ID'])
                   ->bindValue(':added_by_role', '')
                   ->bindValue(':customer_user_id', '')
                    ->execute();
        }
    }
    public function actionImages($id){
        $images = \common\models\Images::find()->where(['=', 'vehicle_id', $id])->all();
        return $this->renderAjax('images',['images'=>$images]);
    }
    public function actionDocHustonFix()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $connection = Yii::$app->safi->createCommand('
        select * from export;');
        $result = $connection->queryAll();
        $stop = false;
        foreach ($result as $c) {
            try {
                Yii::$app->db->createCommand('INSERT INTO houstan_custom_cover_letter
                SET export_id=:export_id,
                   vehicle_location=:vehicle_location,
                   exporter_id=:exporter_id,
                   exporter_type_issuer=:exporter_type_issuer,
                   transportation_value=:transportation_value,
                   exporter_dob=:exporter_dob,
                   ultimate_consignee_dob=:ultimate_consignee_dob,
                   consignee=:consignee,
                   notify_party=:notify_party,
                   menifest_consignee=:menifest_consignee')
                   ->bindValue(':export_id', $c['id'])
                   ->bindValue(':vehicle_location', "'".$c['Vehicle Location']."'")
                   ->bindValue(':exporter_id', $c['id'])
                   ->bindValue(':exporter_type_issuer', $c['Exporter Type Issuer'])
                   ->bindValue(':transportation_value', $c['Transportation Value'])
                   ->bindValue(':exporter_dob', $c['Shipper Exp Dob'])
                   ->bindValue(':ultimate_consignee_dob', $c['Ultimate Consignee Dob'])
                   ->bindValue(':consignee', "'".$c['Consignee']."'")
                   ->bindValue(':notify_party', "'".$c['Notify Party']."'")
                   ->bindValue(':menifest_consignee', "'".$c['Manifest Consignee']."'")
                   ->execute();
            } catch (\Exception $e) {
                $stop = true;
                var_dump($e);
                //continue;
            }
            if ($stop) {
                exit();
            }
        }
    }

    public function actionDocReceiptFix()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $connection = Yii::$app->safi->createCommand('
        select * from export;');
        $result = $connection->queryAll();
        foreach ($result as $c) {
            try {
                Yii::$app->db->createCommand('INSERT INTO dock_receipt
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
                    by=:by,
                    date=:date,
                    auto_recieving_date=:auto_recieving_date,
                    auto_cut_off=:auto_cut_off,
                    vessel_cut_off=:vessel_cut_off,
                    sale_date=:sale_date')
                    ->bindValue(':export_id', $c['id'])
                    ->bindValue(':awb_number', $c['BLorAWBnumber'])
                    ->bindValue(':export_reference', '')
                    ->bindValue(':forwarding_agent', $c['Forwarding Agent'])
                    ->bindValue(':place_of_receipt_by_pre_carrier', $c['PlaceOfReceiptPreCarrier'])
                    ->bindValue(':exporting_carrier', $c['ExportingCarrier'])
                    ->bindValue(':final_destination', $c['FinalDestination'])
                    ->bindValue(':loading_terminal', $c['LoadingTerminal'])
                    ->bindValue(':container_type', $c['ContainerType'])
                    ->bindValue(':number_of_packages', $c['Number of packages'])
                    ->bindValue(':by', $c['BY'])
                    ->bindValue(':date', $c['DATE'])
                    ->bindValue(':auto_recieving_date', $c['AUTO RECEIVING DATE'])
                    ->bindValue(':auto_cut_off', $c['AUTO CUT OFF'])
                    ->bindValue(':vessel_cut_off', $c['VESSEL CUT OFF'])
                    ->bindValue(':sale_date', $c['SAIL DATE'])
                    ->execute();
            } catch (\Exception $e) {
                //continue;
            }
        }
    }

    public function actionPasswordFix()
    {
        ini_set('max_execution_time', 0);
        $connection = Yii::$app->db->createCommand('
        select * from user where id!=10001;');
        $result = $connection->queryAll();
        foreach ($result as $c) {
            $customer = \common\models\Customer::findOne(['user_id' => $c['id']]);
            if ($customer) {
                Yii::$app->db->createCommand('UPDATE user SET password_hash=:hash WHERE id=:id')
                ->bindValue(':hash', \Yii::$app->security->generatePasswordHash($customer->legacy_customer_id))
                ->bindValue(':id', $c['id'])
                ->execute();
                unset($customer);
            }
        }
    }

    public function actionAuthFix()
    {
        ini_set('max_execution_time', 0);
        $connection = Yii::$app->db->createCommand('
        select * from user where id>2;');
        $result = $connection->queryAll();
        foreach ($result as $c) {
            Yii::$app->db->createCommand('INSERT INTO auth_assignment SET item_name=:item_name, user_id=:user_id, created_at=:created_at')
            ->bindValue(':item_name', 'customer')
            ->bindValue(':user_id', $c['id'])
            ->bindValue(':created_at', '1516023225')
            ->execute();
        }
    }

    public function actionExportFix()
    {
        ini_set('max_execution_time', 0);
        $connection = Yii::$app->db->createCommand('
        select * from export;');
        $result = $connection->queryAll();
        foreach ($result as $e) {
            $customer = \common\models\Customer::findOne(['legacy_customer_id' => $e['legacy_customer_id']]);
            Yii::$app->db->createCommand('UPDATE export SET customer_user_id=:customer_user_id where legacy_customer_id=:legacy_customer_id')
            ->bindValue(':customer_user_id', $customer->user_id)
            ->bindValue(':legacy_customer_id', $e['legacy_customer_id'])
            ->execute();
        }
    }

    public function actionConsigneeFix()
    {
        ini_set('max_execution_time', 0);
        $connection = Yii::$app->safi->createCommand('
        select * from cons_notify;');
        $result = $connection->queryAll();
        foreach ($result as $c) {
            $consignee = new \common\models\Consignee();
            $customer = \common\models\Customer::findOne(['legacy_customer_id' => $c['Customer ID']]);
            if ($customer) {
                //$consignee->customer_user_id = $c['Customer ID'];
                $consignee->customer_user_id = $customer->user_id;
                $consignee->consignee_name = $c['Consignee Name'];
                $consignee->consignee_address_1 = $c['Consignee Address L1'];
                $consignee->consignee_address_2 = $c['Consignee Address L2'];
                $consignee->city = $c['Consignee City'];
                $consignee->state = $c['Consignee State'];
                $consignee->country = $c['Consignee Country'];
                $consignee->zip_code = $c['Consignee Zip'];
                $consignee->phone = $c['Consignee Telephone'];
                $consignee->save();
            }
        }
    }

    public function actionFixLocation()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        for ($i = 1; $i < 100; ++$i) {
            $limit = $i * 100;
            $connection = Yii::$app->safi->createCommand("
            select * from vin_rel_location where processed is null order by ts desc LIMIT $limit OFFSET $i;");
            $l = ['LA' => 1, 'GA' => 2, 'NY' => 3, 'TX' => 4, 'G2' => 5, 'TEXAS' => 7, 'NJ' => 8];
            $result = $connection->queryAll();
            $qlong = '';
            foreach ($result as $v) {
                Yii::$app->db->createCommand('UPDATE vehicle SET location=:location WHERE vin=:vin')
                ->bindValue(':vin', $v['VIN'])
                ->bindValue(':location', $l[$v['loc_code']])
                ->execute();
                Yii::$app->safi->createCommand('UPDATE vin_rel_location SET processed=:processed WHERE vin=:vin')
                ->bindValue(':vin', $v['VIN'])
                ->bindValue(':processed', '1')
                ->execute();
            }
            ob_flush();
            flush();
        }

        exit();
    }

    /**
     * Displays a single Vehicle model.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionDocuments($id)
    {
        return $this->renderAjax('documents', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionConditionreport($id)
    {
        return $this->renderAjax('condition_report', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionNotesmodal($id)
    {
        return $this->renderAjax('notes_model', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionNotes()
    {
        $note_export = \common\models\Note::notevehicel(Yii::$app->request->post());
        $user_id = Yii::$app->user->id;
        if ($user_id != 1) {
            $created_by = \common\models\Customer::findOne(['user_id' => $user_id]);
            if ($created_by) {
                $created_by = $created_by->customer_name;
                $color = '#23c6c8';
            } else {
                $created_by = 'Admin';
                $color = '#9C27B0';
            }
        } else {
            $created_by = 'Super Admin';
            $color = '#9C27B0';
        }
        $single_note = '';
        if ($note_export) {
            $single_note .= '<li> <div class="rotate-1 lazur-bg" style="background-color: '.$color.'"><p>'.$created_by.'</p><p>'.date('Y-m-d H:i:s').'</p><p>'.$note_export->description.'</p>';
            if ($note_export->imageurl) {
                $single_note .= '<span class="image_show_note"><a target="_blank" href="/'.$note_export->imageurl.'">View Attachment</a></span>';
            }
            $single_note .= '</div></li>';
        }

        return $single_note;
    }

    /**
     * Creates a new Vehicle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCloseConversatition()
    {
        $id = Yii::$app->request->post('id');
        $open = Yii::$app->request->post('open');
        if ($open == '0') {
            $open = 2;
        }
        $update_exported_vehicle = Yii::$app->db->createCommand()
            ->update('vehicle', ['notes_status' => $open,
            ], 'id ="'.$id.'"')
            ->execute();

        return $open;
    }

    public function actionUploadNotes()
    {
        $model = new Vehicle();

        $imageFile = UploadedFile::getInstance($model, 'imageFile');

        $directory =  Yii::getAlias('@app').'/../uploads/';
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }

        if ($imageFile) {
            $uid = uniqid(time(), true);
            $fileName = $uid.'.'.$imageFile->extension;
            $filePath = $directory.$fileName;
            if ($imageFile->saveAs($filePath)) {
                $path = 'uploads/'.$fileName;

                return Json::encode([
                    'files' => [
                        [
                            'name' => $fileName,
                            'size' => $imageFile->size,
                            'url' => $path,
                            'thumbnailUrl' => $path,
                            'deleteUrl' => 'vehicle/image-delete?name='.$fileName,
                            'deleteType' => 'POST',
                        ],
                    ],
                ]);
            }
        }

        return '';
    }

    public function actionCreate()
    {        
        $user_id = Yii::$app->user->getId();
        $user_detail = \common\models\User::find()->where(['id' => $user_id])->one();
        if ($user_detail->status == 0) {
            return $this->redirect(['index']);
        }

    ini_set('max_execution_time', 0);
        $model = new Vehicle();
        $towing = new \common\models\TowingRequest();
        $images = new \common\models\Images();
        $docs = new \common\models\Documents();
        $vehiclefeatures = new \common\models\VehicleFeatures();
        $vehiclecondition = new \common\models\VehicleCondition();
        $features = \common\models\Features::find()->all();
        $condition = \common\models\Condition::find()->all();
        $all_images = '';
        $all_docs = '';
        $featuredata = '';
        $conditiondata = '';
        $session_data = '';
        $all_images_preview = [];
        $all_docs_preview = [];
        if ($model->load(Yii::$app->request->post()) && $towing->load(Yii::$app->request->post()) || $vehiclefeatures->load(Yii::$app->request->post()) && $vehiclecondition->load(Yii::$app->request->post()) && $images->load(Yii::$app->request->post()) && $docs->load(Yii::$app->request->post())) {
            $model->pieces = 1;
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!$towing->towed) {
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
                    } elseif (isset($Role['admin_BALTO'])) {
                        $model->location = '5';
                    } elseif (isset($Role['admin_NJ2'])) {
                        $model->location = '6';
                    } elseif (isset($Role['admin_TEXAS'])) {
                        $model->location = '7';
                    }
                    elseif (isset($Role['admin_NEWJ'])) {
                        $model->location = '8';
                    }

                }
                $model->vin = preg_replace('/\s+/', '', $model->vin);
                if (empty($model->status)) {
                    $model->status = 3;
                }
                if ($model->save()) {
                    $model->currentAction = \Yii::$app->user->identity->username . ' created';
                    \common\models\Vehicle::Notify(json_encode(array_merge($model->getAttributes(),['currentAction'=>$model->currentAction])),$model->location);
                    if (isset(Yii::$app->request->post('VehicleFeatures')['value'])) {
                        $vehicle_feature = \common\models\VehicleFeatures::inert_vehicle_feature($model, Yii::$app->request->post('VehicleFeatures')['value']);
                    }
                    if (isset(Yii::$app->request->post('VehicleCondition')['value'])) {
                        $vehicle_condition = \common\models\VehicleCondition::inert_vehicle_condition($model, Yii::$app->request->post('VehicleCondition')['value']);
                    }

                    $photos = UploadedFile::getInstances($images, 'name');

                    if ($photos !== null) {
                        $save_images = \common\models\Images::save_container_images($model->id, $photos);
                    }
                    $documents = UploadedFile::getInstances($docs, 'docs');

                    if ($documents !== null) {
                        $save_docs = \common\models\Documents::save_vehicle_documents($model->id, $documents);
                    }
                    $transaction->commit();

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
        if (empty($model->status) && $model->isNewRecord) {
            $model->status = 3;
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model,
                'towing' => $towing,
                'images' => $images,
                'docs' => $docs,
                'features' => $features,
                'condition' => $condition,
                'vehiclefeatures' => $vehiclefeatures,
                'vehiclecondition' => $vehiclecondition,
                'all_images' => $all_images,
                'all_docs' => $all_docs,
                'featuredata' => $featuredata,
                'conditiondata' => $conditiondata,
                'session_data' => $session_data,
                'all_images_preview' => $all_images_preview,
                'all_docs_preview' => $all_docs_preview,
            ]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'towing' => $towing,
                'images' => $images,
                'docs' => $docs,
                'features' => $features,
                'condition' => $condition,
                'vehiclefeatures' => $vehiclefeatures,
                'vehiclecondition' => $vehiclecondition,
                'all_images' => $all_images,
                'all_docs' => $all_docs,
                'featuredata' => $featuredata,
                'conditiondata' => $conditiondata,
                'session_data' => $session_data,
                'all_images_preview' => $all_images_preview,
                'all_docs_preview' => $all_docs_preview,
            ]);
        }
    }

    /**
     * Updates an existing Vehicle model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
    ini_set('max_execution_time', 0);
        $model = $this->findModel($id);
        $oldStatus = $model->status;
        $session_data = \common\models\Customer::find()->where(['user_id' => $model->customer_user_id])->one();
        $towing = \common\models\TowingRequest::find()->where(['id' => $model->towing_request_id])->one();
        $images_old = \common\models\Images::find()->where(['=', 'vehicle_id', $model->id])->all();
        $docs_old = \common\models\Documents::find()->where(['=', 'vehicle_id', $model->id])->all();
        $images = new \common\models\Images();
        $docs = new \common\models\Documents();
        $vehiclefeatures = new \common\models\VehicleFeatures();
        $vehiclecondition = new \common\models\VehicleCondition();
        $featuredata = \common\models\VehicleFeatures::find()->where(['=', 'vehicle_id', $model->id])->all();
        $conditiondata = \common\models\VehicleCondition::find()->where(['=', 'vehicle_id', $model->id])->all();
        $features = \common\models\Features::find()->all();
        $condition = \common\models\Condition::find()->all();

        $all_images_preview = [];
        $all_images = [];
        $all_docs_preview = [];
        $all_docs = [];
        if ($images_old) {
            foreach ($images_old as $image) {
                $baseurl = \Yii::$app->request->BaseUrl;
                $image_url = $baseurl.'/uploads/'.$image->thumbnail;
                $all_images[] = Html::img("$image_url", ['class' => 'file-preview-image']);
                $obj = (object) array('caption' => '', 'url' => $baseurl.'/vehicle/delete-image', 'key' => $image->id);
                $all_images_preview[] = $obj;
            }
        }
        if ($docs_old) {
            foreach ($docs_old as $doc) {
                $baseurl = \Yii::$app->request->BaseUrl;
                $doc_url = $baseurl.'/uploads/'.$doc->name;
                $all_docs[] = "$doc_url";//Html::img("$doc_url", ['class' => 'file-preview-image']);
                $obj = (object) array('caption' => '','previewAsData'=> true,'type'=>'pdf', 'url' => $baseurl.'/vehicle/delete-docs', 'key' => $doc->id);
                $all_docs_preview[] = $obj;
            }
        }
        if ($model->load(Yii::$app->request->post()) && $towing->load(Yii::$app->request->post()) || $vehiclefeatures->load(Yii::$app->request->post()) && $vehiclecondition->load(Yii::$app->request->post()) && $images->load(Yii::$app->request->post()) && $docs->load(Yii::$app->request->post())) {
            $towing->save();
            $model->vin = preg_replace('/\s+/', '', $model->vin);
            if(empty($model->status)){
                $model->status = $oldStatus;
            }
          //  print_r($model->key_note);exit();
            if (!$model->save()) {
                $result = [];
                // The code below comes from ActiveForm::validate(). We do not need to validate the model
                // again, as it was already validated by save(). Just collect the messages.
                foreach ($model->getErrors() as $attribute => $errors) {
                    $result[Html::getInputId($model, $attribute)] = $errors;
                }
                return $this->asJson(['validation' => $result]);
            }else{
                $model->currentAction = \Yii::$app->user->identity->username . ' updated';
                \common\models\Vehicle::Notify(json_encode(array_merge($model->getAttributes(),['currentAction'=>$model->currentAction])),$model->location);
            }
            //delet vehicle features and add new features

            if (isset(Yii::$app->request->post('VehicleFeatures')['value'])) {
                $command = Yii::$app->db->createCommand()
                ->delete('vehicle_features', 'vehicle_id = '.$model->id)
                ->execute();
                $vehicle_feature = \common\models\VehicleFeatures::inert_vehicle_feature($model, Yii::$app->request->post('VehicleFeatures')['value']);
            }
            //delete vehicle condition and add new features

            if (isset(Yii::$app->request->post('VehicleCondition')['value'])) {
                $command = Yii::$app->db->createCommand()
                ->delete('vehicle_condition', 'vehicle_id = '.$model->id)
                ->execute();
                $vehicle_condition = \common\models\VehicleCondition::inert_vehicle_condition($model, Yii::$app->request->post('VehicleCondition')['value']);
            }
            $photos = UploadedFile::getInstances($images, 'name');

            if ($photos) {
                $save_images = \common\models\Images::save_container_images($model->id, $photos);
            }

            $documents = UploadedFile::getInstances($docs, 'name');

            if ($documents) {
                $save_documents = \common\models\Documents::save_vehicle_documents($model->id, $documents);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model,
                'towing' => $towing,
                'images' => $images,
                'docs' => $docs,
                'features' => $features,
                'condition' => $condition,
                'vehiclefeatures' => $vehiclefeatures,
                'vehiclecondition' => $vehiclecondition,
                'all_images' => $all_images,
                'all_docs' => $all_docs,
                'featuredata' => $featuredata,
                'conditiondata' => $conditiondata,
                'session_data' => $session_data,
                'all_images_preview' => $all_images_preview,
                'all_docs_preview' => $all_docs_preview,
                'images_old' => $images_old,
                'docs_old' => $docs_old,
            ]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'towing' => $towing,
                'images' => $images,
                'docs' => $docs,
                'features' => $features,
                'condition' => $condition,
                'vehiclefeatures' => $vehiclefeatures,
                'vehiclecondition' => $vehiclecondition,
                'all_images' => $all_images,
                'all_docs' => $all_docs,
                //'featuredata' => $featuredata,
                //'conditiondata' => $conditiondata,
                'session_data' => $session_data,
                'all_images_preview' => $all_images_preview,
                'all_docs_preview' => $all_docs_preview,
                'images_old' => $images_old,
                'docs_old' => $docs_old,
            ]);
        }
    }

    public function actionDeleteImage()
    {
        $id = Yii::$app->request->post('key');
        $command = Yii::$app->db->createCommand()
            ->delete('images', ['id'=>$id])
            ->execute();
        return $command;
    }
    public function actionDeleteDocs()
    {
        $id = Yii::$app->request->post('key');
        $command = Yii::$app->db->createCommand()
            ->delete('documents', ['id'=>$id])
            ->execute();
        return $command;
    }
    public function actionSearchVin($term)
    {
        if (Yii::$app->request->isAjax) {
            $results = [];

            if (is_numeric($term)) {
                /** @var Tag $model */
                $model = Vehicle::findOne(['vin' => $term]);

                if ($model) {
                    $results[] = [
                        'vin' => $model['vin'],
                    ];
                }
            } else {
                $q = addslashes($term);

                foreach (Vehicle::find()->where("(`vin` like '%{$q}%')")->all() as $model) {
                    $results[] = [
                        'vin' => $model['vin'],
                    ];
                }
            }

            echo Json::encode($results);
        }
    }
public function actionDownloadImages($id)
    {
        $allImages = \common\models\Images::find()->where(['=', 'vehicle_id', $id])->all();
        $v = \common\models\Vehicle::findOne(['id' => $id]);
        if (empty($allImages)) {
            return 'No-Images';
        }

        $absPath =  realpath(dirname(__FILE__) . '/../../uploads') . '/';
        $file = $v->vin.'.zip';
        $dest = $absPath . $file;
        $zipFileUrl = Yii::getAlias('@webroot').'/uploads/'.$file;

        if (file_exists($zipFileUrl)) {
            unlink($zipFileUrl);
        }

        try {
            $zip = new ZipArchive;
            if ($zip->open($dest, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) != TRUE) {
                throw new \Exception('Cannot create a zip file');
            }

            foreach ($allImages as $files) {
                $relativeFile = $files->name;
                $absoluteFile = $absPath.$relativeFile;
                $zip->addFile($absoluteFile, $relativeFile);
            }
            $zip->close();

            if (file_exists($zipFileUrl)) {
                return Yii::$app->response->sendFile($zipFileUrl)
                    ->on(\yii\web\Response::EVENT_AFTER_SEND, function($event) {
                        unlink($event->data);
                    }, $dest);
            }
        } catch (\Exception $e) {

        }
    }
    // public function actionDownloadImages($id)
    // {
    //     $allimages = \common\models\Images::find()->where(['=', 'vehicle_id', $id])->all();
    //     $v = \common\models\Vehicle::findOne(['id' => $id]);
    //     if (empty($allimages)) {
    //         return 'No-Images';
    //     }

    //     $file = $v->vin.'.zip';
    //     if (file_exists('uploads/'.$file)) {
    //         unlink('uploads/'.$file);
    //     }

    //     $zip = new ZipArchive();
    //     if ($zip->open('uploads/'.$file, ZipArchive::CREATE|ZipArchive::OVERWRITE) !== true) {
    //         throw new \Exception('Cannot create a zip file');
    //     }
    //     foreach ($allimages as $files) {
    //         $url = \yii\helpers\Url::to('uploads/'.$files->name, true);
    //         $download_file = file_get_contents($url);

    //         //add it to the zip
    //         if($download_file){
    //              $zip->addFromString(basename($url), $download_file);
    //         }
           
    //     }

    //     $zip->close();
    //     header('Content-disposition: attachment; filename="'.$file.'"');
    //     //header('Content-type: application/zip');
    //     header('Pragma: public');
    //     header('Expires: 0');
    //     header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    //     header('Content-Type: application/force-download');
    //     header('Content-Transfer-Encoding: binary');
    //     header('Connection: close');
    //     readfile(\yii\helpers\Url::to('uploads/'.$file, true));
    //     unlink($tmp_file);
    //     unlink('uploads/'.$file);
    // }

    public function actionVehicledetail($vin_id)
    {
        $vehicle_detail = \common\models\Vehicle::find()->orWhere(['or', ['vin' => $vin_id], ['lot_number' => $vin_id]])->one();
        $update_singel_towing = \common\models\TowingRequest::find()->where(['=', 'id', $vehicle_detail->towing_request_id])->one();
        $customer_name = \common\models\Customer::find()->where(['=', 'user_id', $vehicle_detail->customer_user_id])->one();
        if ($vehicle_detail->status) {
            $location = \common\models\Lookup::$status[$vehicle_detail->status];
        } else {
            $location = '';
        }
        if ($vehicle_detail->location) {
            $v_location = \common\models\Location::getLocationById($vehicle_detail->location);
        } else {
            $v_location = 'no location';
        }
        $vehicle['year'] = $vehicle_detail->year;
        $vehicle['make'] = $vehicle_detail->make;
        $vehicle['model'] = $vehicle_detail->model;
        $vehicle['color'] = $vehicle_detail->color;
        $vehicle['vin'] = $vehicle_detail->vin;
        $vehicle['status'] = $location;
        $vehicle['location'] = $v_location;
        $vehicle['title_number'] = $update_singel_towing->title_number;
        $vehicle['title_state'] = $update_singel_towing->title_state;
        $vehicle['lot_number'] = $vehicle_detail->lot_number;
        $vehicle['customer'] = $customer_name->company_name;

        return json_encode($vehicle);
    }

    public function actionMpdf($id, $mail = null)
    {
        $vehicleDetail = $this->findModel($id);
        $customerDetail = \common\models\Customer::findOne(['user_id' => $vehicleDetail->customer_user_id]);
        $customerMail = \common\models\User::findOne(['id' => $customerDetail->user_id]);
        $customerMail = $customerMail->email;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
            'content' => $this->renderPartial('pdf', [
                'model' => $this->findModel($id),
            ]),
            'filename' => 'CONDITION_REPORT2_FOR_VIN_'.$vehicleDetail->vin.'.pdf',
            'options' => [
                'title' => 'Privacy Policy',
                'subject' => 'Generated PDF By ASL SHIPPING LINE',
            ],
            'methods' => [
                'SetHeader' => ['Generated By: ASL Shipping Line ||Generated On: '.date('r')],
                'SetFooter' => ['|Page {PAGENO}|'],
            ],
        ]);
        if ($mail) {
            $content = $pdf->content;
            $filename = $pdf->filename;
            //  $mpdf = $pdf->getApi();
            //  $mpdf->WriteHtml($content);

            if ($customerMail) {
                $path = $pdf->Output($content, Yii::getAlias('@backend').'/uploads/pdf/'.$filename.'.pdf', \Mpdf\Output\Destination::FILE);
                $sendemail = Yii::$app->mailer->compose()
                    ->attach(Yii::getAlias('@backend').'/uploads/pdf/'.$filename.'.pdf')
                    ->setFrom([\Yii::$app->params['supportEmail'] => 'ASL SHIPPING LINE'])
                    ->setTo($customerMail)
                    ->setSubject('VEHICLE CONDITION REPORT (LOT #:'.$vehicleDetail->lot_number.')')
                    ->setHtmlBody('Dear Valued Customer,<br/><br/>
                    Good Day!<br/><br/>

                    Please check attached condition report for your vehicle.<br/><br/>

                    <b>Please read the following terms and condition:</b><br/>
                    <b>*</b>Vehicle Condition should be checked and compared as soon as vehicle reched in USA yard.<br/>
                    <b>*</b>ASL Shipping Line will not be liable for any missing (Keys, CD player, Navigation etc.) or
                    any damage after it arrives in destination which is already mentioned in the condition report.<br/>
                    <b>*</b>Any other vehicle damage will not be accepted.<br/><br/>
                    Thank You<br/><br/>
                    ASL SHIPPING LINE
                    ')
                    ->send();

                unlink(Yii::getAlias('@backend').'/uploads/pdf/'.$filename.'.pdf');
            } else {
                $sendemail = '';
            }

            if ($sendemail) {
                $mailed = true;
            } else {
                $mailed = false;
            }

            return $this->redirect(array('view',
                'model' => $this->findModel($id),
                'id' => $id,
                'mailed' => $mailed,
            ));
        } else {
            return $pdf->render();
        }
    }

    public function actionGetexport_vehicle($id, $export_id)
    {
        $all_vehicles = \common\models\Vehicle::find()->select('vehicle.*')->join('join vehicle_export on vehicle.id = vehicle_export.vehicle_id', [])->where(['=', 'export_id', $export_id])
            ->andwhere(['=', 'vehicle_export.customer_user_id', $id])
        //  ->andWhere(['=','vehicle.is_export',Null])
            ->asArray()
            ->all();

        $already_invoice = \common\models\Invoice::find()->where(['=', 'export_id', $export_id])->andWhere(['=', 'customer_user_id', $id])->one();
        if ($already_invoice) {
            return '';
        } else {
            return json_encode($all_vehicles);
        }
    }

    /**
     * Deletes an existing Vehicle model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $export_vehicle = \common\models\VehicleExport::find()->where(['vehicle_id' => $id])->all();
        foreach ($export_vehicle as $ev) {
            $ev->delete();
        }

        return $this->redirect(['index']);
    }

    public function actionAllvehicle($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new \yii\db\Query();
            $query->select('vin as id, vin AS text')
                ->from('vehicle')
                ->where(['!=', 'vehicle_is_deleted', 1])
                ->andWhere(['or', ['like', 'vin', $q], ['like', 'lot_number', $q]])
                ->andWhere('is_export is null or is_export=0')
                ->limit(20);

            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Vehicle::find($id)->vin];
        }

        return $out;
    }
    public function actionOnhandVehicle($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new \yii\db\Query();
            $query->select('vin as id, vin AS text')
                ->from('vehicle')
                ->where(['!=', 'vehicle_is_deleted', 1])
                ->andWhere(['=', 'status', 1])
                ->andWhere(['or', ['like', 'vin', $q], ['like', 'lot_number', $q]])
                ->andWhere('is_export is null or is_export=0')
                ->limit(20);

            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Vehicle::find($id)->vin];
        }

        return $out;
    }
    /**
     * Finds the Vehicle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Vehicle the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vehicle::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
