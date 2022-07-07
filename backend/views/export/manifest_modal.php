<?php

use yii2assets\printthis\PrintThis;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
?>

<?php
echo PrintThis::widget([
    'htmlOptions' => [
        'id' => 'btnmanifest',
        'btnClass' => 'btn btn-primary',
        'btnId' => 'btnmanifests',
        'btnText' => 'Print',
        'btnIcon' => 'fa fa-print',
    ],
    'options' => [
        'debug' => false,
        'importCSS' => true,
        'importStyle' => false,
        'loadCSS' => "/assets_b/css/print.css",
        'pageTitle' => "",
        'removeInline' => false,
        'printDelay' => 3000,
        'header' => null,
        'formValues' => true,
    ],
]);
?>

<?php
if(\common\models\Lookup::isAdmin()){
    /*
    echo Html::a('<i class="fa fa-envelope"></i> Email', ['/export/manifestpdf', 'id' => $model->id, 'mail' => true], [
        'class' => 'btn btn-primary',
        'target' => '_blank',
        'data-toggle' => 'tooltip',
        'title' => 'Will send the mail to customer',
    ]);
    */
    ?>
    <a class="btn btn-primary" onclick='if(confirm("Send email to <?= $model->user->email; ?>?")){return true;}else{return false;}' href="/export/manifestpdf?id=<?=$model->id?>&mail=1" title="Will send  email to the customer" target="_blank" data-toggle="tooltip"><i class="fa fa-envelope"></i> Email</a>
<?php }?>

<?php
echo Html::a('<i class="fa fa-file-pdf-o"></i> Open as Pdf', ['/export/manifestpdf', 'id' => $model->id], [
    'class' => 'btn btn-primary',
    'target' => '_blank',
    'data-toggle' => 'tooltip',
    'title' => 'Will open the generated PDF file in a new window',
]);

$vehicle_data = $model->vehicleExports;
$customer_detail = \common\models\Customer::find()->where(['user_id' => $model->customer_user_id])->one();
$vehicle_weight = 0;
foreach ($vehicle_data as $data) {
    $vehicle_detail = \common\models\Vehicle::find()->where(['id' => $data->vehicle_id])->one();

    $vehicle_weight = $vehicle_weight + $vehicle_detail->weight;
}
?>

<div id="btnmanifest" class="condition_reports menifest_modal_print" contenteditable="true">
    <div class="cond_here">

        <div class="manifesta">


            <table class=" ui-widget-header" width="100%" contenteditable="false">
                <tbody><tr>
                        <td width="70%" rowspan="2" id="lli">AFG GlOBAL MANIFEST</td>
                        <td width="12%">Manifest #:</td><td width="18%"></td>
                    </tr>
                    <?php if(!empty($model->ar_number)){ ?>
                        <tr>
                            <td colspan=3>
                            <img class="barcodeimge" src="<?= \yii\helpers\Url::to('@web/vehicle/bar?text='.$model->ar_number, true) ?>">
                            </td>
                        </tr>
                    <?php } ?>
                    <tr><td>ETA:</td><td><?php echo $model->eta; ?></td></tr>
                </tbody></table>

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

        <table width="100%">
            <tr>
                <td width="50%">
                    <table  class="" id="olpa">
                            <tbody>
                                <?php if($customer_detail){ ?>
                                <tr><td>  <?php echo $customer_detail->company_name . '&nbsp;' . $customer_detail->address_line_1;?></td></tr>
                                <tr><td><?php echo $customer_detail->state; ?> </td></tr>
                                <tr><td><?php echo $customer_detail->city . '&nbsp;' . $customer_detail->zip_code; ?></td></tr>
                                <tr><td> <?php echo $customer_detail->phone; ?></td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                </td>
                <td width="50%">
                    <table id="olpa" class="manifest_second_table" >
                                <tbody>
                                    <?php $consignee_id = $model->houstanCustomCoverLetter->notify_party;?>
                                    <?php
                                    $consignee = \common\models\Consignee::find()->where(['=', 'id', $consignee_id])->one();
                                    if ($consignee) {
                                    ?>
                                        <tr><td colspan="4"><?php
                                            echo $consignee->consignee_name . '<br>' . $consignee->consignee_address_1;
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">PHONE :<span class="inputtext"><?php echo $consignee->phone; ?></span></td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                        </table>
                </td>
            </tr>
        </table>
        <table class=" line_under" width="100%">
            <tbody><tr class="ui-widget-header"><th>Description</th></tr>
                <tr>
                    <td><?php echo $model->special_instruction; ?></td>
                </tr>
            </tbody></table>

        <table class="" width="100%">
            <tbody><tr>
                    <td class="ui-state-active" width="17%"><b>Vessel/Voyage:</b></td><td width="28%"><?php echo $model->vessel . '&nbsp;/&nbsp;' . $model->voyage; ?></td>
                    <td width="16%"></td>
                    <td width="21%">
                    </td>
                    <td align="center" width="18%" class="ui-state-active"><b>Weight</b></td>
                </tr>
                <tr>
                    <td class="ui-state-active">
                        <b>Cut Off:</b>
                    </td>
                    <td><?php echo $model->cutt_off; ?></td><td>&nbsp;</td>
                    <td></td><td align="center" class="line_under"><?php echo $vehicle_weight ?></td>
                </tr>
                <tr>
                    <td class="ui-state-active"><b>Booking#:</b></td>
                    <td><?php echo $model->booking_number; ?></td><td>&nbsp;</td>
                    <td>
                    </td>
                    <td align="center" class="ui-state-active"><b>Pieces</b></td></tr>
                <tr><td class="ui-state-active"><b>File Ref#:</b></td><td><?php echo $model->ar_number;?></td><td></td><td></td><td align="center" class="line_under"><?php echo count($vehicle_data); ?></td></tr>
                <tr><td class="ui-state-active"><b>Container#:</b></td><td><?php echo $model->container_number; ?></td><td>&nbsp;</td><td></td><td></td></tr>
                <tr><td class="ui-state-active"><b>Seal#:</b></td><td><?php echo $model->seal_number; ?></td><td>&nbsp;</td><td></td><td></td></tr>
                <tr><td class="ui-state-active"><b>Export Terminal:</b></td><td><?php echo $model->terminal; ?></td>
                    <td class="ui-state-active"><b>Export Date:</b></td><td><?php echo $model->export_date; ?></td><td></td></tr>
            </tbody></table>

        <table width="100%" class="">
            <thead>
                <tr class="ui-state-active">
                    <th width="6%">Year</th>
                    <th width="15%">Make</th>
                    <th width="16%">Model</th>
                    <th width="18%">VIN</th>
                    <th width="9%">Towed From</th>
                    <th width="6%">Towing</th>
                    <th width="7%">Storage</th>
                    <th width="9%">Add. Ch.</th>
                    <th width="8%">Title Fee</th>
           <!--          <th width="8%">A. Storage</th> -->
                    <th width="6%">Keys</th>
                </tr>
            </thead>
            <tbody>
                <?php
$towwed = 0;
$storage = 0;
$add_chg = 0;
$arinastog = 0;
$titlefeetotal= 0;
foreach ($vehicle_data as $data) {
    $vehicle_detail = \common\models\Vehicle::find()->where(['id' => $data->vehicle_id])->andWhere(['!=','vehicle_is_deleted',true])->one();
    ?>
                    <tr>
                        <td align="center"><?php echo $vehicle_detail->year; ?></td>
                        <td align="center" style="border-left: 1px solid black;"><?php echo $vehicle_detail->make; ?></td>
                        <td align="center" style="border-left: 1px solid black;"><?php echo $vehicle_detail->model; ?></td>
                        <td align="center" style="border-left: 1px solid black;"><?php echo $vehicle_detail->vin; ?></td>
                        <td align="center" style="border-left: 1px solid black;"><?php echo $vehicle_detail->towed_from; ?></td>
                        <td align="center" style="border-left: 1px solid black;"><?php echo $vehicle_detail->towed_amount; ?></td>
                        <td align="center" style="border-left: 1px solid black;"><?php echo $vehicle_detail->storage_amount; ?></td>
                        <td align="center" style="border-left: 1px solid black;"><?php echo $vehicle_detail->additional_charges; ?></td>
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
                        <td align="center" style="border-left: 1px solid black;"><?php if ($vehicle_detail->keys) {echo 'Yes';} else {echo 'No';}?></td>
                    </tr>
                    <tr>
                        <th colspan="10" style="text-align:center">
                        <?php //$image_base_64 = base64_encode(file_get_contents()); ?>
                        <img class="barcodeimge" src="<?= \yii\helpers\Url::to('@web/vehicle/bar?text='.$vehicle_detail->vin, true) ?>">
                        </th>
                    </tr>
                    <?php
                        $towwed = $towwed + floatval($vehicle_detail->towed_amount);
                        $storage = $storage + floatval($vehicle_detail->storage_amount);
                        $add_chg = $add_chg + floatval($vehicle_detail->additional_charges);
                        $titlefeetotal+=floatval($vehicle_detail->title_amount);
                        //$towwed = $towwed +$vehicle_detail->towed_amount;
                    }
                    ?>

                <tr><td class="ui-state-highlight" align="right" colspan="5"><b>Total:</b></td>
                    <td align="center" class="ui-state-active" width="6%"><?php echo $towwed; ?></td>
                    <td class="ui-state-active" align="center" width="7%"><?php echo $storage; ?></td>
                    <td class="ui-state-active" align="center" width="9%"><?php echo $add_chg; ?></td>
                      <td width="8%" class="ui-state-active" align="center"><?php echo $titlefeetotal; ?></td>
            <!--         <td width="8%" class="ui-state-active" align="center"><?php echo $arinastog; ?></td> -->
                  
                    <td width="6%"></td>
                </tr>
                <tr>
                    <td colspan='11'>
                        VEHICLES ARE BRACED AND BLOCKED.FUEL TANKS HAVE BEEN SECURELY CLOSED.THE KEYS ARE NOT IN THE IGNITION.BATERIES ARE SECURED AND FASTENED IN THE UPRIGHT POSITION AND PROTECTED AGAINST SHORT CIRCUITS. THE FUEL TANKS ARE EMPTY AND THE ENGINE STOPPED DUE TO LACK OF FUEL.THE VEHICLES HAVE BEEN LOADED INTO THE CONTAINER IN RANCHO DOMINGUEZ, CALIFORNIA.
                    <td>
                </tr>
            </tbody>
        </table>
        <hr class="line_under" />
        <table class="" width="100%">
            <tbody>
                <tr><td width="23%">Received in Good Order</td><td width="34%" class="line_under"></td><td width="10%">Date/Time</td><td width="33%" class="line_under"><?php //date('Y-m-d h:i:s a', time());?></td></tr>
                <tr><td>Drivers Signature</td><td class="line_under"></td><td>Date/Time</td><td class="line_under"><?php // date('Y-m-d h:i:s a', time());?></td></tr>
                <tr><td>Shippers Signature</td><td class="line_under"></td><td>Date/Time</td><td class="line_under"><?php //('Y-m-d h:i:s a', time());?></td></tr>
            </tbody>
        </table>
		<footer>
			<table width="100%">
				<tr>
					<td colspan='4'>
					<br />
					The liability of ECSAP GLOBAL Shipping, for any reason shall in no case exceed $0.50 cent per hundred pounds or $500.00 per shipment whichever is less.
						AFG Global Shipping will not be liable for consequential or incidental damages or loss of profits. Net 15 days, with a monthly finance charge of 1.5% on all balances over thirty days.
						AFG Global Shipping reserves the right to hold or lien cargo for nonpayment Payment is required within (15) days of presentation.
						Failure to pay billed charges may result in lien on future shipment, including cost of storage and appropriate security for the subsequent shipment(s) held pursuant to California Civil Code, Section 3051.5
						<br/>
						AFG Global Shipping is a freight forwarding company, and we are not liable for any charges if your container is stopped by the US Customs for random, routine procedural checks.
						<br />
						On our end, we will always make sure to have all the necessary paperwork attached when we ship your container and take the correct steps to meet all requirements.  However, due to US Customs policy, they can always stop a container for random inspections.  Although we will try our best to help you with anything we can, we are not responsible for this stop or any fees related to it because they are a completely separate entity from us.  You will be liable to US Customs and all charges pertaining to this stop will be covered by you and paid directly to them.
					</td>
                </tr>
			</table>
		</footer>
    </div>
</div>
</div>

