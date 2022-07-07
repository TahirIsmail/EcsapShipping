<div id="page_border" style="margin:15px;">

	<center><strong style=" font-size:16px;">DOCK RECEIPT</strong></center>
	<table width="100%" style="border:1px solid black; border-collapse:collapse; vertical-align:top; padding:5px;">
    <tbody><tr>
        <td colspan="3" rowspan="2" width="50%" valign="top" style="height:100px;border:1px solid black; border-collapse:collapse; vertical-align:top; padding:5px;"><i>2.EXPORTER (Principal or seller-license and address including ZIP Code)</i>
		<br>
        <?php $vehicle_data = $model->vehicleExports;
$customer_detail = \common\models\Customer::find()->where(['user_id' => $model->customer_user_id])->one();
echo $customer_detail->company_name . '&nbsp;' . $customer_detail->address_line_1;
?><br>
        <?php echo $customer_detail->state; ?><br>
        <?php echo $customer_detail->zip_code; ?><br>
		<p style="width:150px;"> Ref: </p>
		</td>
        <td colspan="2" valign="top" style="height:65px;border:1px solid black;border-collapse:collapse;vertical-align:top;padding:5px;"><i>5.BOOKING NUMBER</i>
		<br>
		<br><strong> <?php echo $model->booking_number; ?></strong>
		</td>
        <td colspan="" width="20%" valign="top" style="border:1px solid black;border-collapse:collapse;vertical-align:top;	padding:5px;"><i>5a.B/L OR AWB NUMBER</i>
		<br>	<?php echo $model->dockReceipt->awb_number; ?>	</td>
    </tr>
    <tr>
        <td colspan="3" style="border:1px solid black; 	border-collapse:collapse; 	vertical-align:top; 	padding:5px; 	"><i>6.EXPORT REFERENCES</i>
		<br>	<?php echo $model->dockReceipt->export_reference; ?>	</td>

    </tr>
    <tr>
        <td colspan="3" rowspan="2" style="height:90px;border:1px solid black;
	border-collapse:collapse;
	vertical-align:top;
	padding:5px;
	"><i>3.CONSIGNED TO</i>
		   <br>	<?php $consignee_id = $model->houstanCustomCoverLetter->consignee;
$consignee = \common\models\Consignee::find()->where(['=', 'id', $consignee_id])->one();
if ($consignee) {
    ?>
 <?php
echo $consignee->consignee_name . '&nbsp;';
    ?><br>
	<?php echo $consignee->consignee_address_2; ?><br>
<?php echo isset($consignee->customerUser->phone_two) ? $consignee->customerUser->phone_two : ""; ?>
<?php }?><br>	</td>
        <td colspan="3" style="height:70px;border:1px solid black;
	border-collapse:collapse;
	vertical-align:top;
	padding:5px;
	"><i>7.FORWARDING AGENT (NAME &amp; ADDRESS - REFERENCES)</i>
		<br>	<?php echo $model->dockReceipt->forwarding_agent; ?>	</td>
    </tr>
    <tr>
        <td colspan="3" style="border:1px solid black; 	border-collapse:collapse;vertical-align:top;padding:5px;"><i>8.POINT(STATE) OF ORIGIN OR FTZ NUMBER</i><br><strong><?php echo $model->port_of_loading; ?></strong></td>
    </tr>
    <tr>
        <td colspan="3" style="height:90px;border:1px solid black;
	border-collapse:collapse;
	vertical-align:top;
	padding:5px;
	"><i>4.NOTIFY PARTY/INTERMEDIATE CONSIGNEE (Name and Address)</i>
	      <br><?php $notify_party_id = $model->houstanCustomCoverLetter->notify_party;?>
        <?php
$notify_party = \common\models\Consignee::find()->where(['=', 'id', $notify_party_id])->one();
if ($notify_party) {
    ?>
<?php
echo $notify_party->consignee_name . '&nbsp;' . $notify_party->consignee_address_1;
    ?><br>
<?php echo $notify_party->consignee_address_2 . '&nbsp;' . $notify_party->state; ?><br>
<?php echo $notify_party->country . '&nbsp;' . $notify_party->zip_code; ?>
		<?php }?><br>  		</td>
        <td colspan="3" rowspan="2" style="height:125px;border:1px solid black;
	border-collapse:collapse;
	vertical-align:top;
	padding:5px;
	">
		<i>9.DOMESTIC ROUTING/EXPORT INSTRUCTIONS</i>
		<br>	<?php echo $model->dockReceipt->domestic_routing_insctructions; ?>		<br>
		<div>
		AUTO RECEIVING DATE:<?php echo $model->dockReceipt->auto_recieving_date; ?> <br>
		AUTO CUT OFF:<?php echo $model->dockReceipt->auto_cut_off; ?>  <br>
		VESSEL CUT OFF:<?php echo $model->dockReceipt->vessel_cut_off; ?> <br>
		SAIL DATE: 		<?php echo $model->dockReceipt->sale_date; ?></div>
		</td>
    </tr>
    <tr>
        <td colspan="2" width="25%" style="height: 40px;border:1px solid black;
	border-collapse:collapse;
	vertical-align:top;
	padding:5px;
	"><i>12.PRE-CARRIAGE BY</i>
		<br>	<?php echo $model->dockReceipt->pre_carriage_by; ?>	</td>
        <td width="25%" style="border:1px solid black;
	border-collapse:collapse;
	vertical-align:top;
	padding:5px;
	"><i style="font-size: 9px;">13.PLACE OF RECEIPT BY PRE-CARRIER</i>
		<br>	<?php echo $model->dockReceipt->place_of_receipt_by_pre_carrier; ?>	</td>
    </tr>
    <tr>
        <td colspan="2" style="border:1px solid black; 	border-collapse:collapse; 	vertical-align:top; 	padding:5px; 	 height:40px;"><i>14.EXPORTING CARRIER</i>
		<br><?php echo $model->dockReceipt->exporting_carrier; ?>
				</td>
        <td style="border:1px solid black; 	border-collapse:collapse; 	vertical-align:top; 	padding:5px; 	"><i>15.PORT OF LOADING/EXPORT</i>
		<br> <?php echo $model->port_of_loading; ?>		</td>
        <td colspan="3" style="border:1px solid black; 	border-collapse:collapse; 	vertical-align:top; 	padding:5px; 	"><i>10.LOADING PIER/TERMINAL</i>
		<br><strong> <?php echo $model->dockReceipt->loading_terminal; ?></strong>
		</td>
    </tr>
	<!--
    <tr>
        <td colspan="2">16.FOREIGN PORT OF UNLOADING</td>
        <td style="border:1px solid black; 	border-collapse:collapse; 	vertical-align:top; 	padding:5px; 	">17.FINAL DESTINATION</td>
        <td colspan="3" style="border:1px solid black; 	border-collapse:collapse; 	vertical-align:top; 	padding:5px; 	">11.AES#</td>
    </tr>
	-->
    <tr>
        <td colspan="2" rowspan="2" style="height: 40px;border:1px solid black;
	border-collapse:collapse;
	vertical-align:top;
	padding:5px;
	"><i>16.FOREIGN PORT OF UNLOADING</i>
		<br>
        <?php echo $model->port_of_discharge; ?>		</td>
		<td rowspan="2" style="border:1px solid black;
	border-collapse:collapse;
	vertical-align:top;
	padding:5px;
	"><i>17.FINAL DESTINATION</i>
		<br>
        <?php echo $model->dockReceipt->final_destination; ?>	</td>
        <td rowspan="2" width="30%" style="border:1px solid black;
	border-collapse:collapse;
	vertical-align:top;
	padding:5px;
	"><i>11.AES#</i>
		<br> <?php echo $model->itn; ?>			</td>
        <td colspan="2" style="border:1px solid black;
	border-collapse:collapse;
	vertical-align:top;
	padding:5px;
	"><i>11a.CONTAINERIZED(VESSEL)</i></td>
    </tr>
    <tr>
          <?php if ($model->vessel) {
    $vessel_status = 'YES';
} else {
    $vessel_status = 'No';
}
?>
        <td width="15%" style="border:1px solid black;
	border-collapse:collapse;
	vertical-align:top;
	padding:5px;
	"><i><?=$vessel_status?></i></td>
        <td style="border:1px solid black; 	border-collapse:collapse; 	vertical-align:top; 	padding:5px; 	"><i>NO</i></td>
    </tr>
    <tr>
        <td width="18%" style="height: 40px;border:1px solid black;border-collapse:collapse;vertical-align:top;padding:5px;	"><i>MARKS &amp; NUMBERS</i></td>
        <td width="15%" style="border:1px solid black;border-collapse:collapse;vertical-align:top;padding:5px;"><i>NUMBER OF PACKAGES(19)</i></td>
        <td colspan="2" style="border:1px solid black;border-collapse:collapse;vertical-align:top;padding:5px;"><i>(20)DESCRIPTION OF COMMODITIES</i><br><strong>AUTOS</strong></td>
        <td width='10%' style="border:1px solid black; 	border-collapse:collapse; 	vertical-align:top; 	padding:5px; 	"><i>GROSS WEIGHT<br>(LBS.)(21)</i></td>
        <td width='10%' style="border:1px solid black; 	border-collapse:collapse; 	vertical-align:top; 	padding:5px; 	"><i>MEASUREMENT<br>(22)</i></td>
    </tr>
	<tr>
		<td style="height:200px;border:1px solid black;border-collapse:collapse;vertical-align:top;padding:5px;"><strong>CONTAINER NO.:</strong><br>
		<strong><?php echo $model->container_number; ?></strong>
		<br>
		<strong>SEAL#<br><?php echo $model->seal_number; ?></strong>
		</td>
		<td style="border:1px solid black; 	border-collapse:collapse; vertical-align:top; 	padding:5px; 	"><?php echo $model->dockReceipt->number_of_packages; ?></td>
		<td colspan="2" style="border:1px solid black;border-collapse:collapse;vertical-align:top;padding:5px;">
		<table id="cars" style="border:none;">
                <tbody>

<?php
$vehicle_weight = 0;
$i = 1;
foreach ($vehicle_data as $data) {
    $vehicle_detail = \common\models\Vehicle::find()->where(['id' => $data->vehicle_id])->one();
    $vehicle_weight = $vehicle_weight + $vehicle_detail->weight;
    ?>
                                        <tr class="">
                                            <td align="center" style="font-size:12px;padding:0px;margin:0px"><?php echo $i; ?>.</td>
                                            <td align="center" style="font-size:12px;padding:0px;margin:0px"><?php echo $vehicle_detail->year; ?></td>
                                            <td align="center" style="font-size:12px;padding:0px;margin:0px"><?php echo $vehicle_detail->make; ?></td>
                                            <td align="center" style="font-size:12px;padding:0px;margin:0px"><?php echo $vehicle_detail->model; ?></td>
                                            <td align="center" style="font-size:12px;padding:0px;margin:0px;"><?php echo $vehicle_detail->vin; ?></td>
                                            <td width='73px' align="center" style="font-size:12px;padding:0px;margin:0px">Wt:<?php echo $vehicle_detail->weight; ?> &nbsp;lbs</td>

                                        </tr>

<?php $i++;}?>
                                    </tr>
                                </tbody>
                            </table>
							<br/>
		<center>BATTERIES DISCONNECTED &amp; GASOLINE DRAINED</center>
		</td>
		<td style="border:1px solid black; 	border-collapse:collapse; 	vertical-align:top; 	padding:5px; 	"><?=$vehicle_weight;?>LBS</td>
		<td style="border:1px solid black; 	border-collapse:collapse; 	vertical-align:top; 	padding:5px; 	"></td>
	</tr>
	<tr>
		<td colspan="3" style="height:190px;border:1px solid black;
	border-collapse:collapse;
	vertical-align:top;
	padding:5px;
	">
		DELIVERED BY:
		<br>
		<br>LIGHTER TRUCK-------------------------------------------------------------
		<br>
		<br>ARRIVED-DATE-------------------------------TIME-----------------------
		<br>
		<br>UNLOADED-DATE--------------------------TIME-----------------------
		<br>
		<br>CHECKED BY------------------------------------------------------------------
		<br>
		<br>PLACED &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:9px;">IN SHIP</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  LOCATION-----------------
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:9px;">ON DOCK</span>
		</td>
		<td colspan="3" style="border:1px solid black; 	border-collapse:collapse; 	vertical-align:top; 	padding:5px; 	">
		<i>
		RECEIVED THE ABOVE DESCRIBED GOODS OR PACKAGES SUBJECT TO
		ALL THE TERMS OF THE UNDERSIGNED'S REGULAR FORM OF DOCK
		RECEIPT AND BILL OF LADING WHICH SHALL CONSTITUTE THE
		CONTRACT UNDER WHICH THE GOODS ARE RECEIVED, COPIES OF
		WHICH ARE AVAIABLE FROM THE CARRIER ON REQUEST AND MAY BE
		INSPECTED AT ANY OF ITS OFFICES.
		</i>
		<br>
		<span style="font-weight: bold;">FOR THE MASTER</span><br>
		<table>
		<tbody>
		<tr>
		<td style="border:none;padding: 10px;">BY-----------------</td>

		</td>
		</tr>
		<tr>
		<td style="border:none;padding: 10px;">DATE-----------------</td>

		</td>
		</tr>
		</tbody>
		</table>
		<!-- <div style="padding:5px;"> -->
		<!--
		<span style="">FOR THE MASTER</span><br/>
		<br/>
		<span style="padding-top:12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
		<br/>
		BY_______________________________<br/>
		<span style="padding-top:12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
		<br/>
		DATE____________________________<br/>
		-->
        </td>
	</tr>
</tbody></table>
		<!-- <table style="border:none;">
		<tbody><tr>
		<td style="border:none;padding: 10px;">BY</td><td style="border:none;padding: 10px;"><span style="border-bottom-width: 1px;
border-bottom-style: solid;
border-bottom-color: #000;
margin-top: 10px;
margin-bottom: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
		</td>
		</tr>
		<tr>
		<td style="border:none;padding: 10px;border:1px solid black;
	border-collapse:collapse;
	vertical-align:top;
	padding:5px;
	">
		DATE</td>
		<td style="border:none;padding: 10px;border:1px solid black;
	border-collapse:collapse;
	vertical-align:top;
	padding:5px;
	">
		<span style="border-bottom-width: 1px;
border-bottom-style: solid;
border-bottom-color: #000;
margin-top: 10px;
margin-bottom: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
		</td>
		</tr>
		</tbody></table> -->
		</div>



</div>