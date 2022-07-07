<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use yii2assets\printthis\PrintThis;
?>

<?php
echo PrintThis::widget([
'htmlOptions' => [
    'id' => 'btncover',
    'btnClass' => 'btn btn-primary',
    'btnId' => 'btnPrintThiscover',
    'btnText' => 'Print',
    'btnIcon' => 'fa fa-print'
],
'options' => [
    'debug' => false,
    'importCSS' => true,
    'importStyle' => true,
    'loadCSS' => "/assets_b/css/huston.css",
    'pageTitle' => "",
    'removeInline' => false,
    'printDelay' => 2000,
    'header' => null,
    'formValues' => true,
]
]);
$vehicle_data = $model->vehicleExports;
//$vehicle_id = $vehicle_data[0]['vehicle_id'];
//$vehicle_detail = \common\models\Vehicle::find()->where(['id' => $vehicle_id])->one();
$customer_detail = \common\models\Customer::find()->where(['user_id' => $model->customer_user_id])->one();
?>


<div id="btncover" class="">
<div class="cond_here" contenteditable="true">
    <div class="toppper">
        <table width="100%">
            <tbody><tr><th width="15%" rowspan="2"><img src="<?= \yii\helpers\Url::to('@web/uploads/department-of-homeland-security-logo.jpg', true) ?>" width="80" height="80"></th>
                    <td width="85%" align="left">
                        <span style="font-size:18px;"><strong>U.S. CUSTOMS &amp; BORDER PROTECTION</strong></span>
                        <br>
                        <span style="font-size:18px;"><strong>VEHICLE EXPORT COVER SHEET</strong></span>
                    </td>
                </tr><tr>
                    <td align="left" style="padding-left:4px; border:1px solid black;">PORT OF EXPORT : <span style="font-family:Arial, Helvetica, sans-serif;">HOUSTON APM BARBOURS CUT</span></td>
                </tr>

            </tbody></table>
    </div>
    <div class="lefti pika" style="line-height:8px;">

        <table width="100%">

        </table>

        <table width="100%" class="inner">
            <thead>
                <tr><th colspan="7" class="spec1"><strong>DESCRIPTION OF VEHICLE/EQUIPMENT</strong></th></tr>
                <tr class="car_list_heading"><th width="5%">YEAR</th><th width="15%">MAKE</th><th width="15%">MODEL</th><th width="25%">VIN</th><th width="25%">TITLE NUMBER</th><th width="20%">STATE</th><th width="10%">VALUE</th></tr>
            </thead>
            <tbody>
<?php
foreach ($vehicle_data as $data) {

$vehicle_detail = \common\models\Vehicle::find()->where(['id' => $data->vehicle_id])->one();
$towing_request = \common\models\TowingRequest::find()->where(['id' => $vehicle_detail->towing_request_id])->one();

if ($vehicle_detail->location) {
    $locations = \common\models\Lookup::$location[$vehicle_detail->location];
} else {
    $locations = 'nothing';
}
?>
                    <tr class="car_list">
                        <td align="center"><?php echo $vehicle_detail->year; ?></td>
                        <td align="center" style="border-left: 1px solid black;"><?php echo $vehicle_detail->make; ?></td>
                        <td align="center" style="border-left: 1px solid black;"><?php echo $vehicle_detail->model; ?></td>
                        <td align="center" style="border-left: 1px solid black;"><?php echo $vehicle_detail->vin; ?></td>
                        <td align="center" style="border-left: 1px solid black;"><?php echo $towing_request->title_number; ?></td>
                        <td align="center" style="border-left: 1px solid black;"><?php echo $towing_request->title_state; ?></td>
                        <td align="center" style="border-left: 1px solid black;">$<?php echo $vehicle_detail->value; ?></td>
                    </tr>
<?php } ?>
            </tbody>
        </table>


    </div>




    <div class="informations" style="line-height:12px;">

        <table width="100%" class="inner">
            <tbody><tr><th colspan="2">TRANSPORTATION INFORMATION</th></tr>
                <tr>
                    <td width="50%">ITN : <span class="inputtext"><?= $model->itn; ?></span></td>
                    <td width="50%">VALUE : <span class="inputtext"></span></td>
                </tr>
                <tr>
                    <td width="50%">CARRIER : <span class="inputtext"><?= $model->streamship_line; ?></span></td>
                    <td width="50%">VESSEL : <span class="inputtext"><?= $model->vessel; ?></span></td>
                </tr>
                <tr>
                    <td colspan="2" width="100%">BoL/AWB/BOOKING # : <span class="inputtext"><?= $model->booking_number; ?></span></td>
                </tr>
                <tr>
                    <td width="50%">EXPORT DATE : <span class="inputtext"><?= $model->export_date; ?></span></td>
                    <td width="50%">PORT OF UNLADING :<?php //$model->port_of_discharge; ?> </td>
                </tr>
                <tr>
                    <td colspan="2" width="100%">ULTIMATE DESTINATION : <span class="inputtext"><?= $model->destination; ?></span></td>
                </tr>
                <tr>
                    <td colspan="2" width="100%">VEHICLE LOCATION : <span class="inputtext"><?php echo $model->houstanCustomCoverLetter->vehicle_location; ?></span></td>
                </tr>

            </tbody></table>
        <br>
        <table width="100%" class="inner">
            <tbody><tr><th colspan="4">SHIPPER/EXPORTER</th></tr>
                <tr>
                    <td colspan="3" width="60%">NAME : <span class="inputtext"><?php echo isset($customer_detail->company_name)?$customer_detail->company_name:""; ?></span></td>
                    <td width="40%">DOB : <?php // $model->houstanCustomCoverLetter->exporter_dob; ?> </td>
                </tr>
                <tr>
                    <td colspan="4" width="100%">ADDRESS: <span class="inputtext"><?php echo isset($customer_detail->address_line_1)?$customer_detail->address_line_1:"";?>.</span></td>
                </tr>
                <tr>
                    <td colspan="2" width="35%">CITY : <span class="inputtext"><?php echo isset($customer_detail->city)?$customer_detail->city:""; ?></span></td>
                    <td width="30%">STATE : <span class="inputtext"><?php echo isset($customer_detail->state)?$customer_detail->state:""; ?></span></td>
                    <td width="35%">ZIP CODE : <span class="inputtext"><?php echo isset($customer_detail->zip_code)?$customer_detail->zip_code:""; ?></span></td>
                </tr>
                <tr>
                    <td colspan="4">PHONE : TEL:<span class="inputtext"><?php echo isset($customer_detail->phone)?$customer_detail->phone:""; ?></span>,FAX:<span class="inputtext"><?php echo isset($customer_detail->fax)?$customer_detail->fax:""; ?></span></td>
                </tr>
                <tr>
                    <td colspan="2" width="35%">ID # : <?php echo $model->houstanCustomCoverLetter->exporter_dob; ?></td>
                    
                    <!-- <td colspan="2" width="65%">TYPE &amp; ISSUER : TAX ID <?php //echo $customer_detail->tax_id; ?></td> -->
                    <td colspan="2" width="65%">TYPE &amp; ISSUER : <?php ?></td>
                </tr></tbody></table>
        <br>
        <table width="100%" class="inner">
            <tbody><tr><th colspan="4">ULTIMATE CONSIGNEE<span style="font-weight:normal;"> ([&nbsp;&nbsp;&nbsp;&nbsp;] CHECK IF SHIPPER)</span></th></tr>
<?php $notify_party_id = $model->houstanCustomCoverLetter->consignee; ?> 
<?php
$notify_party = \common\models\Consignee::find()->where(['=', 'id', $notify_party_id])->one();
if ($notify_party) {
?>
                    
                    <tr>
                        <td colspan="3" width="60%">NAME : <span class="inputtext"><?php echo $notify_party->consignee_name ?></span></td>
                        <td width="40%">DOB : </td>
                    </tr>
                    <tr>
                        <td colspan="4" width="100%">ADDRESS: <span class="inputtext"><?php echo $notify_party->consignee_name . '&nbsp;' . $notify_party->consignee_address_1; ?></span></td>
                    </tr>
                    <tr>
                        <td colspan="2" width="35%">CITY : <span class="inputtext"> <?php echo $notify_party->city ?> </span></td><td width="30%">STATE : <span class="inputtext"> <?php echo $notify_party->state ?> </span></td><td width="35%"><span class="inputtext">COUNTRY :  <?php echo $notify_party->country ?> </span></td>
                    </tr>
                    <tr>
                        <td colspan="4">PHONE : <span class="inputtext"> <?php echo $notify_party->phone; ?> </span></td>
                    </tr>
<?php } ?>

            </tbody></table>
        <br>
        <table width="100%" class="inner">
            <tbody><tr>
                    <th colspan="2">DESIGNATED AGENT/BROKER/FREIGHT FORWARDER</th>
                </tr>
                <tr>
                    <td colspan="2"><span class="inputtext">NAME : <?php echo \common\models\Lookup::$agent ['NAME']; ?></span></td>
                </tr>
                <tr>
                    <td colspan="2"><span class="inputtext">ADDRESS : <?php echo \common\models\Lookup::$agent ['Address']; ?></span></td>
                </tr>
                <tr>
                    <td><span class="inputtext">CITY : <?php echo \common\models\Lookup::$agent ['CITY']; ?></span></td>
                    <td><span class="inputtext">STATE : <?php echo \common\models\Lookup::$agent ['STATE']; ?></span></td> 
                </tr>
                <tr>
                    <td><span class="inputtext">PHONE : <?php echo \common\models\Lookup::$agent ['PHONE']; ?></span></td>
                    <td><span class="inputtext">CONTACT :<?php echo \common\models\Lookup::$agent ['CONTACT']; ?></span></td>
                </tr>
            </tbody></table>
        <br>
        <p>
        </p><center><span style="text-align: center; letter-spacing: 6px; font-weight: bold; font-family:  Arial, Helvetica, sans-serif;">UNITED STATES CUSTOMS AND BORDER PROTECTION</span></center>
        <p></p>


    </div>

</div>
</div>

