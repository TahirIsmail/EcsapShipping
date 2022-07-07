<?php 
    $vehicle_data = $model->vehicleExports;
   $customer_detail = \common\models\Customer::find()->where(['user_id' => $model->customer_user_id])->one();
    $vehicle_weight = 0;
 foreach ($vehicle_data as $data) {
                $vehicle_detail = \common\models\Vehicle::find()->where(['id' => $data->vehicle_id])->one();
               
$vehicle_weight = $vehicle_weight + $vehicle_detail->weight;
}
?>
<div class="manifesta" style="overflow:hidden;">
<div class="row center" style="width: 100%;margin: auto;">
    <div class="cond_logo lefti center"style="width: 30%; float:left;border: 1px solid #000;height:78px;" >
    <img src="<?= \yii\helpers\Url::to('@web/uploads/logo.jpg', true) ?>"  height="75" alt="ArianaW Logo">
    </div>
    <div class="lefti title center" style="width: 40%;float:left;text-align:center;padding-top:5px;border: 1px solid #000;height:73px;"><h5>AFG GLOBAL SHIPPING<br> <br>
 </h5></div>
  	
    <div class="lefti title" style="width: 29%;float:left;text-align:center;padding-top:5px;border: 1px solid #000;height:73px;"> 
         <table class="lefti ui-widget-header" width="100%" >   
        <tbody><tr>
                <td   id="lli" style="border: 1px solid #000;background-color: #d9fbfa;width: 50%;height: 35px;"> MANIFEST</td>
                <td style="border: 1px solid #000;width: 50%;height: 35px;"><?php echo $model->ar_number;?></td>
            </tr>
            <tr>
            <td style="border: 1px solid #000;background-color: #d9fbfa;width: 50%;height: 35px;">Date:</td>
                <td style="border: 1px solid #000;width: 50%;height: 35px;"><?php echo $model->export_date; ?></td></tr>
        </tbody></table></div>
    </div>
  
<table width= "100%">
    <tr>
<td  width="50%" style="border: 1px solid #000;background-color: #d9fbfa;">
    <table id="shipi" class="lefti" width="100%" style="float:left;">
        <thead><tr class="ui-widget-header"><td><b>Shipper</b></td></tr></thead>
    </table>
</td>
<td  width="50%" style="border: 1px solid #000;background-color: #d9fbfa;">
    <table id="shipi" class="lefti" width="100%" style="float:left;">
        <thead><tr class="ui-widget-header"><td><b>Notify / Consignee</b></td></tr></thead>
    </table>
</td>

</tr>
</table>
<table width= "100%">
    <tr>
        <td  width="50%"  style="height: 140px;border: 1px solid #000;">
    <table width="100%" style="float:left;" class="lefti" id="olpa">

        <tbody>
        <tr><td>  <?php echo $customer_detail->company_name . '&nbsp;' . $customer_detail->address_line_1;?></td></tr>
                            <tr><td><?php echo $customer_detail->state; ?> </td></tr>
                            <tr><td><?php echo $customer_detail->city . '&nbsp;' . $customer_detail->zip_code; ?></td></tr>
                            <tr><td> <?php echo $customer_detail->phone; ?></td></tr>
        </tbody>
    </table>
</td>

<td  width="50%" style="height: 140px;border: 1px solid #000;">
<table width="100%"  style="float:left;">
           <tbody>
                <?php $consignee_id =  $model->houstanCustomCoverLetter->notify_party; ?> 
                <?php
                    $consignee = \common\models\Consignee::find()->where(['=','id',$consignee_id])->one();
                    if($consignee){
                                 ?>
                               <tr><td><?php
                                    echo $consignee->consignee_name . '<br>' . $consignee->consignee_address_1;
                                        ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4">PHONE :<span class="inputtext"><?php echo $consignee->phone; ?></span></td>
                                </tr>
                                    <?php    }?>
                                </tbody>
                                </table>
                                </td>
                                </tr>
            </table>

    <table class="lefti line_under" width="100%">
        <tbody><tr class="ui-widget-header"><th style="border: 1px solid #000;text-align: center;background-color: #d9fbfa;font-size:15px;">Description</th></tr>
        </tbody></table>

    <table class="lefti" width="100%">
        <tbody>
            <tr>
                <td class="ui-state-active" style="border: 1px solid #000;background-color: #d9fbfa;" width="17%"><b>Vessel/Voyage:</b></td><td width="28%" style="border: 1px solid #000;"><?php echo $model->vessel.'&nbsp;/&nbsp;'.$model->voyage; ?></td>
                <td width="16%"></td>
                <td width="21%">
                </td>
                <td align="center" width="18%" class="ui-state-active"style="border: 1px solid #000;background-color: #d9fbfa;"><b>Weight</b></td>
            </tr>
            <tr>
                <td class="ui-state-active" style="border: 1px solid #000;background-color: #d9fbfa;">
                    <b>Cut Off:</b>
                </td>
                <td style="border: 1px solid #000;"><?php echo $model->cutt_off; ?></td><td>&nbsp;</td>
                <td></td><td align="center" class="line_under" style="border: 1px solid #000;"><?php  echo $vehicle_weight;?></td>
            </tr>
            <tr>
                <td class="ui-state-active" style="border: 1px solid #000;background-color: #d9fbfa;"><b>Booking#:</b></td>
                <td style="border: 1px solid #000;"> <?php echo $model->booking_number; ?></td><td>&nbsp;</td>
                <td>
                </td>


               
                <td align="center" class="ui-state-active" style="border: 1px solid #000;background-color: #d9fbfa;"><b>Pieces</b></td></tr>
            <tr><td class="ui-state-active" style="border: 1px solid #000;background-color: #d9fbfa;"><b>File Ref#:</b></td><td style="border: 1px solid #000;"><?php echo $model->ar_number;
                 ?></td><td>&nbsp;</td><td></td><td align="center" class="line_under" style="border: 1px solid #000;"><?php echo count($vehicle_data);?></td></tr>
            <tr><td class="ui-state-active" style="border: 1px solid #000;background-color: #d9fbfa;"><b>Container#:</b></td><td style="border: 1px solid #000;"><?php echo $model->container_number; ?></td><td>&nbsp;</td><td></td><td></td></tr>
            <tr><td class="ui-state-active" style="border: 1px solid #000;background-color: #d9fbfa;"><b>Seal#:</b></td><td style="border: 1px solid #000;"><?php echo $model->seal_number; ?></td><td>&nbsp;</td><td></td><td></td></tr>
            <tr><td class="ui-state-active" style="border: 1px solid #000;background-color: #d9fbfa;"><b>Export Terminal:</b></td><td style="border: 1px solid #000;"><?php echo $model->terminal; ?></td>
                <td class="ui-state-active" style="border: 1px solid #000;background-color: #d9fbfa;"><b>Export Date:</b></td><td style="border: 1px solid #000;"><?php echo $model->export_date; ?></td><td></td></tr>
        </tbody></table>

    <table width="100%" class="lefti">
        <thead>
            <tr class="ui-state-active" >
                <th width="6%" style="border: 1px solid #000;background-color: #d9fbfa;">Year</th>
                <th width="15%" style="border: 1px solid #000;background-color: #d9fbfa;">Make</th>
                <th width="16%" style="border: 1px solid #000;background-color: #d9fbfa;">Model</th>
                <th width="18%" style="border: 1px solid #000;background-color: #d9fbfa;">VIN</th>
                <th width="9%" style="border: 1px solid #000;background-color: #d9fbfa;">Towed From</th>
                <th width="6%" style="border: 1px solid #000;background-color: #d9fbfa;">Towing</th>
                <th width="7%" style="border: 1px solid #000;background-color: #d9fbfa;">Storage</th>
                <th width="9%" style="border: 1px solid #000;background-color: #d9fbfa;">Add. Ch.</th>
                <th width="8%" style="border: 1px solid #000;background-color: #d9fbfa;">Title Fee</th>
      <!--           <th width="8%" style="border: 1px solid #000;background-color: #d9fbfa;">A. Storage</th> -->
                <th width="6%" style="border: 1px solid #000;background-color: #d9fbfa;">Keys</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $towwed = 0;
            $storage = 0;
            $add_chg = 0;
            $arinastog = 0;
            $titlefeetotal = 0;
            foreach ($vehicle_data as $data) {
                $vehicle_detail = \common\models\Vehicle::find()->where(['id' => $data->vehicle_id])->andWhere(['!=','vehicle_is_deleted',true])->one();
                if($vehicle_detail){
                ?>
                <tr>
                    <td ><?php echo $vehicle_detail->year; ?></td>
                    <td  style="border-left: 1px solid black;"><?php echo $vehicle_detail->make; ?></td>
                    <td  style="border-left: 1px solid black;"><?php echo $vehicle_detail->model; ?></td>
                    <td  style="border-left: 1px solid black;"><?php echo $vehicle_detail->vin; ?></td>

                    <td  style="border-left: 1px solid black;"><?php echo $vehicle_detail->towed_from; ?></td>
                    <td  style="border-left: 1px solid black;"><?php echo $vehicle_detail->towed_amount; ?></td>
                    <td  style="border-left: 1px solid black;"><?php echo $vehicle_detail->storage_amount; ?></td>
                    <td  style="border-left: 1px solid black;"><?php echo $vehicle_detail->additional_charges; ?></td>
                    <td align="center" style="border-left: 1px solid black;"><?php echo $vehicle_detail->title_amount; ?></td>
             <!--        <td align="center" style="border-left: 1px solid black;">
                        <?php
                             $towing_request = \common\models\TowingRequest::find()->where(['id' => $vehicle_detail->towing_request_id])->one();
                            if ($vehicle_detail->status != '4' && $towing_request['deliver_date'] && date('Y-m-d') > $towing_request['deliver_date']) {

                                if($model->loading_date){
                                    $current_date = $model->loading_date;
                                }else{
                                    $current_date = date('Y-m-d');
                                }
                                $datediff = strtotime($current_date) - strtotime($towing_request['deliver_date']);
                                $days = floor($datediff / (60 * 60 * 24));
                                        if ($days > 30) {
                                            $days = $days - 30;
                                            echo $days = $days * 5;
                                            $arinastog = $arinastog + $days;
                                        } else {
                                            echo $days = '0';
                                        }
                                    } else {
                                        echo $days = '0';
                                    }
                            ?>
                        </td> -->
                    <td  style="border-left: 1px solid black;"><?php if ($vehicle_detail->keys) {echo 'Yes';} else {echo 'No';}?></td>
                </tr>
                <tr>
                    <th colspan="10" style="text-align:center">
                        <?php $image_base_64=''; //$image_base_64 = base64_encode(file_get_contents(\yii\helpers\Url::to('@web/vehicle/bar?text='.$vehicle_detail->vin, true))); ?>
                        
                    </th>
                </tr>
                <?php
                $towwed = $towwed + $vehicle_detail->towed_amount;

                $storage = $storage + (int)$vehicle_detail->storage_amount;
                $add_chg = $add_chg + $vehicle_detail->additional_charges;
                $titlefeetotal+=floatval($vehicle_detail->title_amount);
                }
                //$towwed = $towwed +$vehicle_detail->towed_amount;
            }
            ?>




            <tr><td style="border: 1px solid #000;background-color: #d9fbfa;"class="ui-state-highlight" align="right" colspan="5"><b>Total:</b></td>
                <td align="center" class="ui-state-active" width="6%"><?php echo $towwed; ?></td>
                <td class="ui-state-active" align="center" width="7%"><?php echo $storage; ?></td>
                <td class="ui-state-active" align="center" width="9%"><?php echo $add_chg; ?></td>
                  <td width="8%" class="ui-state-active" align="center"><?php echo $titlefeetotal; ?></td>
           <!--      <td width="8%" class="ui-state-active" align="center"><?php echo $arinastog; ?></td> -->
              
                <td width="6%"></td></tr>     
        </tbody>
    </table>

    <table class=" lefti line_under" width="100%">
        <tbody><tr><td>VEHICLES ARE BRACED AND BLOCKED.FUEL TANKS HAVE BEEN SECURELY CLOSED.THE KEYS ARE NOT IN THE IGNITION.BATERIES ARE SECURED AND FASTENED IN THE UPRIGHT POSITION AND PROTECTED AGAINST SHORT CIRCUITS. THE FUEL TANKS ARE EMPTY AND THE ENGINE STOPPED DUE TO LACK OF FUEL.THE VEHICLES HAVE BEEN LOADED INTO THE CONTAINER IN RANCHO DOMINGUEZ, CALIFORNIA.</td></tr>
        </tbody></table>
    <table class="lefti" width="100%">
        <tbody><tr><td width="23%" style="border: 1px solid #000;background-color: #d9fbfa;">Received in Good Order</td><td width="34%"  style="border: 1px solid black;" class="line_under"></td><td width="10%" style="border: 1px solid #000;background-color: #d9fbfa;">Date/Time</td><td width="33%" class="line_under" style="border: 1px solid black;"><?php //date('Y-m-d h:i:s a', time());?></td></tr>
            <tr><td style="border: 1px solid #000;background-color: #d9fbfa;">Drivers Signature</td><td class="line_under" style="border: 1px solid black;"></td><td style="border: 1px solid #000;background-color: #d9fbfa;">Date/Time</td><td class="line_under" style="border: 1px solid black;"><?php //date('Y-m-d h:i:s a', time());?></td></tr>
            <tr><td style="border: 1px solid #000;background-color: #d9fbfa;">Shippers Signature</td><td class="line_under" style="border: 1px solid black;"></td><td style="border: 1px solid #000;background-color: #d9fbfa;">Date/Time</td><td class="line_under" style="border: 1px solid black;"><?php //date('Y-m-d h:i:s a', time());?></td></tr>


        </tbody></table>
    <table class=" lefti" width="100%">
        <tbody><tr><td>
        <span style="display:block;margin-top:10px;">            
The liability of AFG Global Shipping, for any reason shall in no case exceed $0.50 cent per hundred pounds or $500.00 per shipment whichever is less.
AFG Global Shipping will not be liable for consequential or incidental damages or loss of profits. Net 15 days, with a monthly finance charge of 1.5% on all balances over thirty days.
AFG Global Shipping reserves the right to hold or lien cargo for nonpayment Payment is required within (15) days of presentation.
Failure to pay billed charges may result in lien on future shipment, including cost of storage and appropriate security for the subsequent shipment(s) held pursuant to California Civil Code, Section 3051.5
</span>
<span style="display:block;margin-top:10px;">AFG Global Shipping is a freight forwarding company, and we are not liable for any charges if your container is stopped by the US Customs for random, routine procedural checks.
</span><span style="display:block;margin-top:10px;">
On our end, we will always make sure to have all the necessary paperwork attached when we ship your container and take the correct steps to meet all requirements.  However, due to US Customs policy, they can always stop a container for random inspections.  Although we will try our best to help you with anything we can, we are not responsible for this stop or any fees related to it because they are a completely separate entity from us.  You will be liable to US Customs and all charges pertaining to this stop will be covered by you and paid directly to them.
</span>
        </td></tr>
        </tbody></table>
</div>
