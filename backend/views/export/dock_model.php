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
        'id' => 'btndock',
        'btnClass' => 'btn btn-primary',
        'btnId' => 'btnPrintThisdock',
        'btnText' => 'Print',
        'btnIcon' => 'fa fa-print'
    ],
    'options' => [
        'debug' => false,
        'importCSS' => true,
        'importStyle' => false,
        //'loadCSS' => "path/to/my.css",
        'pageTitle' => "",
        'removeInline' => false,
        'printDelay' => 50,
        'header' => null,
        'formValues' => true,
    ]
]);
?>

<?php
echo Html::a('<i class="fa fa-file-pdf-o "></i> Open as Pdf', ['/export/dockpdf', 'id' => $model->id], [
    'class' => 'btn btn-primary',
    'target' => '_blank',
    'data-toggle' => 'tooltip',
    'title' => 'Will open the generated PDF file in a new window'
]);
?>

<div id="btndock" class="condition_reportss" contenteditable="true">
    <div class="cond_here">
        <div id="page_border" style="padding:15px;">
            <center><strong style="font-family:Arial, Helvetica, sans-serif; font-size:16px;">DOCK RECEIPT</strong></center>
            <table width="100%">
                <tbody>
                    <tr>
                        <td colspan="3" rowspan="2" width="50%" valign="top" style="height:100px;">
                            <i>2.EXPORTER (Principal or seller-license and address including ZIP Code)</i>
                            <br>
<?php
$vehicle_data = $model->vehicleExports;
$customer_detail = \common\models\Customer::findOne(['user_id' => $model->customer_user_id]);
echo $customer_detail->company_name . '&nbsp;' . $customer_detail->address_line_1;
?><br>
                            <?php echo $customer_detail->state; ?><br>
                            <?php echo  $customer_detail->zip_code; ?><br>
<!--                                 <p style="width:150px;"> Ref: </p>-->
                        </td>
                        <td colspan="2" valign="top" style="height:65px;"><i>5.BOOKING NUMBER</i>
                            
                            <br><strong> <?php echo $model->booking_number; ?></strong>
                        </td>
                        <td valign="top"><i>5a.B/L OR AWB NUMBER</i>
                            <br>	<?php echo $model->dockReceipt->awb_number; ?>	
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><i>6.EXPORT REFERENCES</i>
                            <br>	<?php echo $model->dockReceipt->export_reference; ?>	
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" rowspan="2" style="height:90px;"><i>3.CONSIGNED TO</i>
                            <br>	<?php
                            $consignee_id = $model->houstanCustomCoverLetter->consignee;
                            $consignee = \common\models\Consignee::find()->where(['=', 'id', $consignee_id])->one();
                            if ($consignee) {
                                ?>
                                <?php
                                echo $consignee->consignee_name . '&nbsp;';
                                ?><br>
                                <?php echo $consignee->consignee_address_1; ?><br>
                                <?php echo isset($consignee->customerUser->phone_two)? $consignee->customerUser->phone_two:""; ?>
                            <?php }?>
                        </td>
                        <td colspan="3" style="height:70px;"><i>7.FORWARDING AGENT (NAME &amp; ADDRESS - REFERENCES)</i>
                            <br>	<?php echo $model->dockReceipt->forwarding_agent; ?>	
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><i>8.POINT(STATE) OF ORIGIN OR FTZ NUMBER</i><br><strong><?php echo $model->port_of_loading; ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="height:90px;"><i>4.NOTIFY PARTY/INTERMEDIATE CONSIGNEE (Name and Address)</i>
                            <br><?php $notify_party_id = $model->houstanCustomCoverLetter->notify_party; ?> 
                            <?php
                            $notify_party = \common\models\Consignee::find()->where(['=', 'id', $notify_party_id])->one();
                            if ($notify_party) {
                                ?>
                                
                                <?php
                                echo $notify_party->consignee_name . '&nbsp;' . $notify_party->consignee_address_1;
                                ?><br>
                                <?php echo $notify_party->consignee_address_2 . '&nbsp;' . $notify_party->state; ?><br>
                                <?php echo $notify_party->country . '&nbsp;' . $notify_party->zip_code; ?>
                             <?php }?>                               
                        </td>
                        <td colspan="3" rowspan="2" style="height:125px;">
                            <i>9.DOMESTIC ROUTING/EXPORT INSTRUCTIONS</i>
                            <br>	<?php echo $model->dockReceipt->domestic_routing_insctructions; ?>		<br>
                            <div>
                                AUTO RECEIVING DATE:<?php echo $model->dockReceipt->auto_recieving_date; ?> <br>
                                AUTO CUT OFF:<?php echo $model->dockReceipt->auto_cut_off; ?>  <br>
                                VESSEL CUT OFF:<?php echo $model->dockReceipt->vessel_cut_off; ?> <br>
                                SAIL DATE: 		<?php echo $model->dockReceipt->sale_date; ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" width="25%" style="height: 40px;"><i>12.PRE-CARRIAGE BY</i>
                            <br>	<?php echo $model->dockReceipt->pre_carriage_by; ?>	
                        </td>
                        <td width="25%"><i style="font-size: 8px;">13.PLACE OF RECEIPT BY PRE-CARRIER</i>
                            <br>	<?php echo $model->dockReceipt->place_of_receipt_by_pre_carrier; ?>	
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="height: 40px;"><i>14.EXPORTING CARRIER</i>
                            <br><?php echo $model->dockReceipt->exporting_carrier; ?>
                        </td>
                        <td><i>15.PORT OF LOADING/EXPORT</i>
                            <br> <?php echo $model->port_of_loading; ?>		
                        </td>
                        <td colspan="3"><i>10.LOADING PIER/TERMINAL</i>
                            <br><strong> <?php echo $model->dockReceipt->loading_terminal; ?></strong>
                        </td>
                    </tr>
                    <!--
                       <tr>
                           <td colspan="2">16.FOREIGN PORT OF UNLOADING</td>
                           <td>17.FINAL DESTINATION</td>
                           <td colspan="3">11.AES#</td>
                       </tr>
                    -->
                    <tr>
                        <td colspan="2" rowspan="2" style="height: 40px;"><i>16.FOREIGN PORT OF UNLOADING</i>
                            <br>
<?php echo $model->port_of_discharge; ?>		
                        </td>
                        <td rowspan="2"><i>17.FINAL DESTINATION</i>
                            <br>
<?php echo $model->dockReceipt->final_destination; ?>	
                        </td>
                        <td rowspan="2" width="30%"><i>11.AES#</i>
                            <br> <?php echo $model->itn; ?>			
                        </td>
                        <td colspan="2"><i>11a.CONTAINERIZED(VESSEL)</i></td>
                    </tr>
                    <tr>
                        <?php
                        if ($model->vessel) {
                            $vessel_status = 'YES';
                        } else {
                            $vessel_status = 'NO';
                        }
                        ?>
                        <td width="15%"><i><?= $vessel_status ?></i></td>
                        <td><i>NO</i></td>
                    </tr>
                    <tr>
                        <td width="20%" style="height: 40px;"><i>MARKS &amp; NUMBERS</i></td>
                        <td width="5%"><i>NUMBER OF PACKAGES(19)</i></td>
                        <td colspan="2"><i>(20)DESCRIPTION OF COMMODITIES</i><br><strong>AUTOS</strong></td>
                        <td><i>GROSS WEIGHT<br>(LBS.)(21)</i></td>
                        <td><i>MEASUREMENT<br>(22)</i></td>
                    </tr>
                    <tr>
                        <td style=""><strong>CONTAINER NO.:</strong><br>
                            <strong><?php echo $model->container_number; ?></strong>
                            <br>
                            <strong>SEAL#<br><?php echo $model->seal_number; ?></strong>
                        </td>
                        <td><?php echo $model->dockReceipt->number_of_packages; ?></td>
                        <td colspan="2">
                            
                            <table id="cars_no_border">
                                <tbody>
                                <center><?php echo \yii\helpers\ArrayHelper::getValue(\common\models\Lookup::$container_type, $model->container_type);?></center>
                                    <?php
                                    $vehicle_weight = 0;
                                    $i = 1;
                                    foreach ($vehicle_data as $data) {

                                        $vehicle_detail = \common\models\Vehicle::find()->where(['id' => $data->vehicle_id])->one();
                                        $vehicle_weight = $vehicle_weight + $vehicle_detail->weight;
                                        ?>
                                        <tr class="table_td_no_border">
                                                   <td align="center"><?php echo $i;?></td>
                                            <td align="center" ><?php echo $vehicle_detail->year; ?></td>
                                            <td align="center" ><?php echo $vehicle_detail->make; ?></td>
                                            <td align="center" ><?php echo $vehicle_detail->model; ?></td>
                                            <td align="center" ><?php echo $vehicle_detail->vin; ?></td>
                                            <td align="center" >Wt:<?php echo $vehicle_detail->weight; ?> &nbsp;lbs</td>
                                          
                                        </tr>

<?php $i++; } ?>
                                    </tr>
                                </tbody>
                            </table>
                         
                <center>BATTERIES DISCONNECTED &amp; GASOLINE DRAINED</center>
                </td>
                <td><?= $vehicle_weight; ?>LBS</td>
                <td></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:initial;padding-right:5px;">
                        DELIVERED BY:
                    
                        <br>LIGHTER TRUCK-------------------------------------------------------------
                    
                        <br>ARRIVED-DATE-------------------------------TIME-----------------------
                        
                        <br>UNLOADED-DATE--------------------------TIME-----------------------
                    
                        <br>CHECKED BY------------------------------------------------------------------
                    
                        <br>PLACED &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:9px;">IN SHIP</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  LOCATION-----------------
                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:9px;">ON DOCK</span>
                    </td>
                    <td colspan="3" style="text-align:initial;padding-right:5px;">
                        <i>
                            RECEIVED THE ABOVE DESCRIBED GOODS OR PACKAGES SUBJECT TO
                            ALL THE TERMS OF THE UNDERSIGNED'S REGULAR FORM OF DOCK
                            RECEIPT AND BILL OF LADING WHICH SHALL CONSTITUTE THE
                            CONTRACT UNDER WHICH THE GOODS ARE RECEIVED, COPIES OF
                            WHICH ARE AVAIABLE FROM THE CARRIER ON REQUEST AND MAY BE
                            INSPECTED AT ANY OF ITS OFFICES.
                        </i>
                        <br>
                        <div style="padding:5px;">
                  
                            <span style="">FOR THE MASTER</span><br>
                            <table style="border:none;">
                                <tbody>
                                    <tr style="width: 50%;float: left;">
                                        <td style="border:none;padding: 10px;">BY</td>
                                        <td style="border:none;padding: 10px;"><span style="border-bottom-width: 1px;
                                                                                     border-bottom-style: solid;
                                                                                     border-bottom-color: #000;
                                                                                     margin-top: 10px;
                                                                                     margin-bottom: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
                                        </td>
                                    </tr>
                                    <tr  style="width: 50%;float: left;">
                                        <td style="border:none;padding: 10px;">
                                            DATE
                                        </td>
                                        <td style="border:none;padding: 10px;">
                                            <span style="border-bottom-width: 1px;
                                                  border-bottom-style: solid;
                                                  border-bottom-color: #000;
                                                  margin-top: 10px;
                                                  margin-bottom: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

