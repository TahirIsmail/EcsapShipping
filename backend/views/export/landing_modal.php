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
		'id' => 'btnlanding',
		'btnClass' => 'btn btn-primary',
		'btnId' => 'btnPrintThislanding',
		'btnText' => 'Print',
		'btnIcon' => 'fa fa-print'
	],
	'options' => [
		'debug' => false,
		'importCSS' => true,
		'importStyle' => false,
		'loadCSS' => "/assets_b/css/print_bl.css",
		'pageTitle' => "",
		'removeInline' => false,
		'printDelay' => 2000,
		'header' => null,
		'formValues' => true,
	]
]);
?>
				
						<?php
						if(\common\models\Lookup::isAdmin()){
							echo Html::a('<i class="fa fa-envelope"></i> Email', ['/export/landingpdf', 'id' => $model->id,'mail' => true], [
								'class' => 'btn btn-primary',
								'target' => '_blank',
								'data-toggle' => 'tooltip',
								'title' => 'Will send the mail to customer'
							]);
						}
						
						?>
				
                <?php
                echo Html::a('<i class="fa fa-file-pdf-o"></i> Open as Pdf', ['/export/landingpdf', 'id' => $model->id], [
                    'class' => 'btn btn-primary',
                    'target' => '_blank',
                    'data-toggle' => 'tooltip',
                    'title' => 'Will open the generated PDF file in a new window'
                ]);

        $vehicle_data = $model->vehicleExports;

        $customer_detail = \common\models\Customer::find()->where(['user_id' => $model->customer_user_id])->one();
        $vehicle_weight = 0;
        foreach ($vehicle_data as $data) {
            $vehicle_detail = \common\models\Vehicle::find()->where(['id' => $data->vehicle_id])->one();

            $vehicle_weight = $vehicle_weight + $vehicle_detail->weight;
        }
        ?>
  <div id="btnlanding" class="condition_reports">

                            <div class="bola">

                                <table class="" width="100%">
                                    <tbody><tr><td width="73%" id="lopa"><b><?php if(empty($model->broker_name)){ ?>AFG Global MARITIME <?php }else{ echo $model->broker_name;} ?></b><?php if(!empty($model->oti_number)){ ?><p>OTI License #:<?= $model->oti_number; ?> </p><?php } ?></td><td width="27%"><b>BILL OF LADING</b></td></tr>
                                    </tbody></table>

                                <div class="shipa">
                                    <table  width="100%">
                                    <thead><tr><td><b>SHIPPER / EXPORTER</b></td></tr></thead>

                        <tbody>

                            <tr><td contenteditable="true">  <?php echo $customer_detail->company_name . '&nbsp;' . $customer_detail->address_line_1;?></td></tr>
                            <tr><td contenteditable="true"><?php echo $customer_detail->state .'&nbsp;'.$customer_detail->city . '&nbsp;' . $customer_detail->zip_code; ?> </td></tr>
                            <tr><td contenteditable="true"> TEL: <?php echo $customer_detail->phone; ?></td></tr>
                        </tbody>
                    </table>


                                </div>
                                <div class="shipa1">
                                    <div class="kiki">
                                        <div class="pipi1">
                                            <table width="100%">
                                                <tbody><tr><td><b>BOOKING #</b></td></tr>
                                                    <tr><td contenteditable="true"><?= $model->booking_number; ?></td></tr>	
                                                </tbody></table>

                                        </div>
                                        <div class="pipi2">
                                            <table width="100%">
                                                <tbody><tr><td><b>REFERENCE #</b></td></tr>
                                                    <tr><td contenteditable="true"><?= $model->ar_number; ?></td></tr>	
                                                </tbody></table>
                                        </div>
                                    </div>
                                    <div class="kiki">
                                        <div class="pipi1">
                                            <table width="100%">
                                                <tbody><tr>
                                                        <td><b>PLACE OF RECEIPT</b></td></tr>
                                                    <tr><td contenteditable="true"><?= $model->port_of_loading; ?></td></tr>	
                                                </tbody></table>

                                        </div>
                                        <div class="pipi2">
                                            <table width="100%">
                                                <tbody><tr>
                                                        <td><b>PORT OF LOADING</b></td></tr>
                                                    <tr><td contenteditable="true"><?= $model->port_of_loading; ?></td></tr>	
                                                </tbody></table>
                                        </div>
                                    </div>

                                    <div class="pipi12">
                                        <table width="100%">
                                            <tbody><tr><td width="50%"><b>PORT OF DISCHARGE:</b></td>
                                            <td width="50%" contenteditable="true"><?= $model->port_of_discharge; ?></td></tr>
                                            </tbody></table>

                                    </div>

                                </div>

                                <div class="shipa221">
                                    <table width="100%">
                                        <thead><tr><td><b>CONSIGNEE</b></td></tr></thead>
                                        <tbody>
                                            <tr><td contenteditable="true"><?php
                                                    if($model->houstanCustomCoverLetter->consignee){
                                                    $id_consignee = $model->houstanCustomCoverLetter->consignee;
                                                    
                                                    $data_consignee = \common\models\Consignee::find()->where(['id' => $id_consignee])->one();
                                                    if($data_consignee){
                                                    
                                                    echo $data_consignee->consignee_name
                                                    ?>
                                                </td></tr>
                                            <tr><td contenteditable="true"><?= $data_consignee->consignee_address_1 ;?> </td></tr>
                                            <tr><td contenteditable="true"> TEL: <?= $data_consignee->phone ?>  </td></tr>
                                            <tr>
                                                    <?php } } ?>
                                            </tr>
                                        </tbody>

                                    </table>

                                </div>


                                <div class="shipa1234">
                                    <div class="kiki">
                                        <div class="pipi1">
                                            <table width="100%">
                                                <tbody><tr>
                                                        <td><b>PIER</b></td></tr>
                                                    <tr><td contenteditable="true"><?= $model->terminal ?></td></tr>	
                                                </tbody></table>

                                        </div>
                                        <div class="pipi2">
                                            <table width="100%">
                                                <tbody><tr>
                                                        <td><b>VESSEL</b></td></tr>
                                                    <tr><td contenteditable="true"><?= $model->vessel ?></td></tr>	
                                                </tbody></table>
                                        </div>
                                    </div>
                                    <div class="kiki">
                                        <div class="pipi1">
                                            <table width="100%">
                                                <tbody><tr>
                                                        <td><b>LOADING PIER / TERMINAL</b></td></tr>
                                                    <tr><td contenteditable="true"><?= $model->terminal ?></td></tr>	
                                                </tbody></table>

                                        </div>
                                        <div class="pipi2">
                                            <table width="100%">
                                                <tbody><tr>
                                                        <td><b>VOYAGE NO.</b></td></tr>
                                                    <tr><td contenteditable="true"><?= $model->voyage ?></td></tr>	
                                                </tbody></table>
                                        </div>
                                    </div>

                                </div>
                                <div class="shipa221">
                                    <table width="100%">
                                        <thead><tr><td><b>NOTIFY</b></td></tr></thead>
                                        <tbody>
                                        <tr><td contenteditable="true"><?php
                                        if($model->houstanCustomCoverLetter->notify_party){
                                                $id_consignee = $model->houstanCustomCoverLetter->notify_party;
                                                $data_consignee = \common\models\Consignee::find()->where(['id' => $id_consignee])->one();
                                                if($data_consignee){
                                                echo $data_consignee->consignee_name
                                                ?>
                                            </td></tr>
                                        <tr><td contenteditable="true"><?= $data_consignee->consignee_address_1; ?> </td></tr>
                                        <tr><td contenteditable="true"> TEL: <?= $data_consignee->phone; ?>  </td></tr>
                                        <tr>
                                        <?php } }?>
                                        </tr>
                                    </tbody>

                                    </table>

                                </div>


                                <div class="shipa1234">
                                    <table id="KIAM" width="100%">
                                        <tbody><tr><td><b>FOR RELEASE OF CARGO PLEASE CONTACT:</b></td></tr>
                                            <tr>
                                                <td height="49"></td>
                                            </tr>
                                        </tbody></table>
                                    <table id="siam" width="100%">
                                        <tbody><tr><td width="12%"><b>ETA/</b></td>
                                        <td width="88%" contenteditable="true"> <?= $model->eta ?></td></tr>
                                        </tbody></table>
                                </div>

                                <div class="shipa2212">
                                    <div class="simi">
                                        <table width="100%">
                                            <tbody><tr><td><b>CONTAINER #</b></td></tr>
                                                <tr><td contenteditable="true"><?= $model->container_number ?></td></tr>
                                            </tbody></table>

                                    </div>
                                    <div class="simi">
                                        <table width="100%">
                                            <tbody><tr>
                                                    <td><b>CONTAINER TYPE</b></td></tr>
                                                <tr><td contenteditable="true" style="font-size:13px;"><?php if($model->container_type){ echo isset(\common\models\Lookup::$container_type[$model->container_type])?\common\models\Lookup::$container_type[$model->container_type]:$model->container_type;} ?></td></tr>
                                            </tbody></table>

                                    </div>
                                    <div class="simi1">
                                        <table width="100%">
                                            <tbody><tr><td><b>SEAL #</b></td></tr>
                                                <tr><td contenteditable="true"><?= $model->seal_number ?></td></tr>
                                            </tbody></table>
                                    </div>
                                </div>


                                <div class="shipa12342">
                                    <table id="KIAM" width="100%">
                                        <tbody><tr><td contenteditable="true"><b>SPECIAL INSTRUCTIONS:</b></td></tr>
                                            <tr>
                                                <td contenteditable="true">

                                                    <?= $model->special_instruction; ?>
                                                </td>
                                            </tr>
                                        </tbody></table>

                                </div>
                                <div class="desc">
                                    <table width="100%">
                                        <tbody>
                                        <tr>
                                                <th width="72%" colspan="4"><b>SHIPPERS DESCRIPTIONS OF GOODS</b><br><?php echo count($vehicle_data) ?> UNITS USED VEHICLE</th>
                                                <th width="12%"><b>WEIGHT</b></th>
                                                <th width="16%" contenteditable="true"><b>CUBE <br>55 M3</b></th>
                                        </tr>
                                          <?php
                                         
                                                 foreach ($vehicle_data as $data) {
                                      
                                        $vehicle_detail = \common\models\Vehicle::find()->where(['id' => $data->vehicle_id])->one();
                                       
                                       ?>

                                        <tr class="">
                                            <td align="center" width="15%" contenteditable="true"><?php echo $vehicle_detail->year; ?></td>
                                            <td align="" width="15%" contenteditable="true"><?php echo $vehicle_detail->make; ?></td>
                                            <td align="" width="20%" contenteditable="true"><?php echo $vehicle_detail->model; ?>/<?php echo $vehicle_detail->color; ?></td>
                                            <td align="" width="30%" contenteditable="true"><?php echo $vehicle_detail->vin; ?></td>
                                            <td width="12%" contenteditable="true"><?php echo round($vehicle_detail->weight * 0.45359237); ?>kg</td>
                                            <td width="16%"></td>
                                            </tr>
                                    <?php } ?>
                                            
                                        </tbody></table>
                                </div>

                                <div class="carsi">
                                    <table class="" width="100%">
                                        <tbody><tr><th width="72%"> <b></b></th><th width="12%" contenteditable="true"><?= round($vehicle_weight * 0.45359237); ?>kg</th><th width="16%"><?php ?></th></tr>
                                        </tbody>
                                        </table>
                                </div>

                                <div class="addtls">
                                    <table width="100%">

                                        <tbody><tr><td><b>*** NON HAZ MAT</b></td><td><b>OCEAN FREIGHT PRE-PAID</b></td><td><b>TOTAL WEIGHT KG</b></td></tr>
                                            <tr><td><b>*** SEND TELEX RELEASE</b></td><td><b>ITN#</b><?= $model->itn ?></td><td><?= round( $vehicle_weight * 0.45359237); ?></td></tr>
                                            <tr>
                                            <td colspan="3">
                                                    <p>These Comodities, technology or software were exported from the United States in the acordance with the export administrative regulations. Diversion contrary to the U.S. law prohibited.</p>
                                                </td>
                                            </tr>
                                        </tbody></table>


                                </div>

                                <table class="bottom-text" width="100%">
                                    <tbody><tr><td>
                                                <p style="text-align:justify">HEREBY CERTIFY HAVING RECEIVED THE ABOVE DESCRIBED SHIPMENT IN OUTWARDLY GOOD CONDITION FROM THE SHIPPER SHOWN IN SECTION "EXPORTER", FOR FORWARDING TO THE ULTIMATE CONSIGNEE SHOWN IN THE SECTION "CONSIGNEE" ABOVE. IN WITNESS WHEREOF, THE ____________ NONNEGOTIABLE FCR'S HAVE BEEN SIGNED, AND IF ONE (1) IS ACCOMPLISHED BY DELIVERY OF GOODS, ISSUANCE OF A DELIVERY ORDER OR BY SOME OTHER MEANS, THE OTHERS SHALL BE AVOIDED IF REQUIRED BY THE FREIGHT FORWARDER, ONE (1) ORIGINAL FCR MUST BE SURRENDERED, DULY ENDORSED IN EXCHANGE FOR THE GOODS OR DELIVERY ORDER.</p>
                                            </td></tr>
                                    </tbody></table>

                                <table class="" width="100%">
                                    <tbody>
                                        <tr>
                                                <td colspan=4>
                                                <span style="display:block;margin-top:5px;">ECSAP Global Shipping is a freight forwarding company, and we are not liable for any charges if your container is stopped by the US Customs for random, routine procedural checks.
                                                </span><span style="display:block;margin-top:5px; text-align:justify;">
                                                On our end, we will always make sure to have all the necessary paperwork attached when we ship your container and take the correct steps to meet all requirements.  However, due to US Customs policy, they can always stop a container for random inspections.  Although we will try our best to help you with anything we can, we are not responsible for this stop or any fees related to it because they are a completely separate entity from us.  You will be liable to US Customs and all charges pertaining to this stop will be covered by you and paid directly to them.
                                                </span>
                                                </td>
                                            </tr>
										
                                        <tr>
											
                                            <td width="12%"><b>AUTHORIZED</b></td><td width="42%" class="line_under" contenteditable="true">
                                            
                                            </td>
                                            <td width="11%"><b>DATED AT:</b></td><td class="line_under" width="35%" contenteditable="true"><?php // $model->eta ?></td>
                                        </tr>
                                        
                                    </tbody></table>
                            </div>
							<div>
							</br>
								<!--a class="btn btn-primary open-pdf" href="#" title="Will open the Terms & Conditions PDF file in a new window" target="_blank" ><i class="status-button fa fa-file-pdf-o"></i> TERMS & CONDITIONS</a-->
								
								<a class="btn btn-primary open-pdf" href="<?=Yii::$app->getUrlManager()->getBaseUrl(); ?>/export/termsconditions" title="Will open the Terms & Conditions PDF file in a new window" target="_blank" ><i class="status-button fa fa-file-pdf-o"></i> TERMS & CONDITIONS</a>
								
							</br>
							</br>
							<div style="float: left; width: 50%;">

							<p style="text-align:justify; width: 98%; font-size:8px;">
							1. (Definition) In this Bill of Lading, the term "Carrier" means the ocean common carrier transporting the goods including AFG Global Maritime Inc. and/or its agent. The word "Merchant" includes the shipper, consignor, consignee, owner and receiver of the goods an the holder of this Bill of Lading; the word "goods" means the cargo described on the face of this Bill of Lading and, if the cargo is packed into container(s) supplied or furnished by or on behalf of the Merchant, includes the container(s) as well; the word "vessel" includes vessel, ship, craft, lighter or other means of transport which is or shall be substituted, in whole or part, for the vessel named on the hereof.
							</p>
							<p style="text-align:justify; width: 98%;  font-size:8px;">
							2. (Clause Paramount) As far as this Bill of Lading covers the carriage of the goods by water, this Bill of Lading shall have effect subject to the provisions of the U.S. Carriage of Goods by Sea Act, 1936 ("COGSA"), unless it is adjudged that any other legislation of a nature similar to the international Convention for the Unification of Certain Rules relating to Bills of Lading signed at Brussels on August 25, 1924 compulsorily apples to this Bill of Lading, in which case it shall have effect subject to the provisions of such legislation, and the said Act or legislation (hereinafter called the Hague rules Legislation) shall be deemed to be incorporated herein. If any provision of this Bill of Lading is held to be repugnant to any extent to the Hague Rule Legislation or any other laws, statutes or regulations applicable to the contract evidenced by this Bill of Lading, such provision shall be null and void to such be mull void to such extent but no further.
							</p>
							<p style="text-align:justify; width: 98%;  font-size:8px;">
							3. (Sub Contracting) The Carrier shall be entitled to sub-contract on any terms the whole or any part of the handling, storage or carriage of the goods and any and all duties whatsoever undertaken by the Carrier in relation to the goods. The Merchant shall indemnify the Carrier against any claims which may be made upon the Carrier by any servant, agent or sub-contractor of the Carrier in relation to the claim against any such person made by the Merchant. Without prejudice to the foregoing, every such servant, agent and sub-contractor shall have the benefit of all provisions herein for the benefit of the Carrier as if such provisions were expressly for their benefit; and in entering into this contract the Carrier, to the extent of those provisions, does so not only on his own behalf but also as agent and trustee for such servant, agents and sub-contractors.
							</p>
							<p style="text-align:justify; width: 98%;  font-size:8px;">
							4. (Route of Transport) (1) The goods may, at the Carrier''s absolute discretion, be carried by the vessel and/or any other means of transport by water, land or air and by any route whatsoever, whether or not such route is the direct, advertised or customary route. (2) The vessel shall have liberty to call and/or stay at any port(s) or place(s) in or out of the direct, advertised or customary route, once or more often and in any order backwards or forwards, and/or omit calling at any port(s) or place(s) whether scheduled or not. (3) The vessel shall have liberty to adjust compasses, go on drydock or ways, or to repair yards, shift berths, take fuel or stores, remain in port, sail with or without pilots, two or be towed, and save or attempt to save life or property. (4) Any action taken by the Carrier under this Article shall be deemed to be included within the contractual carriage and such action or delay resulting therefrom shall not be deemed to be a deviation. Should the Carrier be held liable in respect of such action, the Carrier shall be entitled to the full benefit of all privileges, rights and immunities contained in the Bill of Lading.
							</p>
							<p style="text-align:justify; width: 98%;  font-size:8px;">
							5. (Responsibility) (1) The Carrier shall be responsible for loss of or damage to the goods occurring between the time when the goods are received by the Carrier at the place of receipt or port of loading and the time of delivery by the Carrier at the port of discharge or place of delivery. (2) The Carrier shall, however, be relieved of responsibility for any loss or damage arising or resulting form: (a) the wrongful act or neglect of the Merchant or any persons acting on behalf of the Merchant; (b) compliance with the instructions of the Merchant or any persons acting on behalf of the Merchant or the person entitled to give them; (c) the lack of, or insufficiency of, or the defective condition of packing of the goods; (d) handling, loading, stowage or unloading of the goods by the Merchant or any persons acting on behalf of the Merchant; (e) inherent defect, quality or vice of the goods; (f) insufficiency or inadequacy or marks or numbers on the goods, coverings, cases, or containers; (g) strikes or lockouts or stoppage or restraint of labour from whatever cause, whether partial or general; (h) latent defect in any vessel, vehicle, conveyance, container, cargo carrying equipment or other plant or equipment, terminal store or premises whatsoever, not discoverable by due diligence; (i) any cause or event which the Carrier could not, avoid and consequence whereof the Carrier could not prevent by the exercise of reasonable diligence. (3) In case it is established by the Merchant that loss of or damage to the goods occurred during the period prescribed in paragraph (1) hereof, the Carrier shall subject to the provisions of this Bill of Lading be responsible for such loss or damage to the extent following but no further; (i) with respect to loss or damage occurring during the period of carriage by sea or inland waterways, to the extent prescribed by the applicable Hague Rules Legislation as provided for in Article 2 hereof; (ii) with respect to loss or damage occurring during the period of carriage by rail at interior point(s) in Europe and U.S.S.R., to the extent provided for in international Convention concerning The Carriage of Goods by Rail (CIM) made at Berne on October 25, 1952; (iii) with respect to loss or damage occurring during the period of carriage by road at interior point(s) in Europe and U.S.S.R., to the extent provided for in Convention on the Contract for international Carriage of Goods by Road (CMR) made at Geneva on May 19, 1956; (iv) with respect to loss or damage occurring during the handling, storage or carriage by road in Korea to the extent stipulated in the Harbour Transportation Contracts, General Conditions of Warehouse Deposit Contracts and/or Agreement on Forwarding by Motor Truck filed with the Minister of Transport of Korea by the Carrier; (v) save as covered by preceding (i), (ii), (iii) & (iv) with respect to loss or damage occurring during the handling, storage or carriage of the goods by a sub-contractor or agent of the Carrier, to the extent to which such sub-contractor or agent would have been responsible to the Merchant if he had made a direct and separate contract with the Merchant in respect of such handling, storage or carriage, the terms and conditions of the said direct and separate contract can be obtained at the Carrier’s office upon request of the Merchant. (4) In case it cannot be proved where the loss or damage occurred, the loss or damage shall be deemed to have occurred in the course of carriage by sea and the Carrier shall be responsible to the extent prescribed by the applicable Hague Rules Legislation. (5) Notwithstanding Article 5, (3) hereof, the Carrier does not undertake that the goods shall arrived at the port of discharge or place of delivery at any particular time or in time to meet any particular market or use and the Carrier shall not be responsible for any direct or indirect loss or damage which is caused through delay. (6) With respect to inland transportation in the U.S.A., the Carrier''s responsibility is to procure such transportation and incidental services by carriers authorized by the competent governmental agencies to engage in such carriage and to guarantee the performance thereof by such carriers pursuant to the terms and provisions of their contracts and tariffs.
							</p>
							<p style="text-align:justify; width: 98%;  font-size:8px;">
							6. (Liberties) (1) In any situation whatsoever, whether or not exiting or anticipated before commencement of or during the transport, which in the judgement of the Carrier (including for the purpose of this Article any person charged with the transport or safekeeping of the goods), (i)has give or is likely to give rise to danger injury, loss, delay or disadvantage of whatsoever nature to the vessel, a vehicle, the Carrier, any person, the goods or any property; or (ii) has rendered or is likely to render it in any way unsafe, impracticable or unlawful or against the interest of the Carrier or the Merchant to commence or continue the transport or to discharge the goods at the port of discharge or to deliver the goods at the place of delivery by the route and in the manner originally intended by the Carrier, the Carrier (a) at any time shall be entitled to unpack the container(s) or otherwise dispose of the goods in such way as the Carrier may deem advisable at the risk and expense of the Merchant; and/or (b) before the goods are loaded on the vessel, a vehicle or other means of transport at the place of receipt or port of loading shall be entitled to cancel the contract of carriage without compensation and to require the Merchant to take delivery of them and upon his failure to do so, to warehouse or place them anywhere at the risk and expense of the Merchant; and/or (c) if the goods are at a place awaiting transshipment, shall be entitled to terminate the transport there and to store them at any place selected by the Carrier at the risk and expense of the Merchant, and/or (d) if the goods are loaded on the vessel, or other means of transport whether or not approaching, entering or attempting to enter the port of discharge or to reach the place of delivery or attempting or commencing to discharge, shall be entitled to discharge the goods or any part thereof at any port or place selected by the Carrier or to carry them back to the port of loading or place of receipt and there discharge them. Any action under (c) or (d) above shall constitute complete and final delivery and full performance of this contract, and the Carrier thereafter be freed form any responsibility hereunder. (2) The situations referred to in the preceding paragraph shall include, but shall not be limited to, those caused by the existence or apprehension of war declared or undeclared, hostilities, warlike or belligerent acts or operations, riots, civil commotions or other disturbances; closure of, obstacle in or danger to any canal; blockade of port of place or interdict or prohibition of or restriction commerce or trading; quarantine, sanitary or other similar regulations or restrictions; strikes, lockouts or other labour troubles whether partial or general and whether or not involving employees of the Carrier or his sub-contractors; congestion of port, wharf, sea terminal or any other place; shortage, absence or obstacles of labour or facilities for loading, discharge, delivery or other handling of the goods; epidemics or diseases; bad weather, shallow water, ice, londslide or other obstacle in navigation or haulage. (3) The Carrier shall have liberty to comply with any orders or directions as to loading, departure, arrival, routes, ports of call, stoppages, discharge, destination, delivery or otherwise howsoever given by the government of any nation or of any department or agency thereof or by any person acting or purporting to act with the authority of such government or of any department or agency thereof, or by any committee or person having, under the terms of any war risk insurance on the vessel, the right to give such orders or directions, and if by reason of, and in compliance with, any such orders or directions, any if reason of, and in compliance with, any such orders or directions anything is done or is not done, the same shall not be deemed a deviation, and the Carrier shall not be liable for any loss of or damage to or expense with respect to the goods whatsoever, arising from compliance with any such orders or directions.
							</p>
							<p style="text-align:justify; width: 98%;  font-size:8px;">	
							7. (Unknown Clause) Any reference on the face hereof to marks, numbers, description, quality, quantity, gauge, weight, measure, nature, kind, value and any other particulars of the goods is as furnished by the Merchant, and the Carrier shall not be responsible for the accuracy thereof. The Merchant warrants to the Carrier that the particulars furnished by him are correct and shall indemnify the Carrier against all loss, damage, expenses, liability, penalties and fines arising or resulting from inaccuracy thereof.
							</p>
							<p style="text-align:justify; width: 98%;  font-size:8px;">
							8. (Use of Container) Where the goods receipt of which is acknowledged on the face of this Bill of Lading are not already packed into container(s) at the time of receipt, the Carrier shall be at liberty to pack and carry them in any type of container(s).
							</p>
							<p style="text-align:justify; width: 98%;  font-size:8px;">
							9. (Container Packed by Merchant) If the cargo received by the Carriers is container(s) into which contents have been packed by or on behalf of the Merchant, (1) this Bill of Lading is prima facie evidence of the receipt only of the number of container(s) as shown on the face hereof; and the order and condition of the contents and any particular thereof (including marks and numbers, number and kind of packages or pieces, description, quality, quantity, gauge, weight, measures, nature, kind and value) are unknown to the Carrier, who accepts no responsibility in respect thereof, and (2) the Merchant warrants that the stowage of the contents of container(s) and their closing and sealing are safe and proper and also warrants that the container(s) and contents thereof are suitable for handling and carriage in accordance with the terms hereof including Article 11; in the event of the Merchant''s breach of said warranties, the Carrier shall not be responsible for loss of or damage to or in connection with the goods resulting from said breach and the Merchant shall not be liable for loss of or damage to another property, or for personal injury or the consequences o any other accidents or events whatsoever and shall indemnify the Carrier against any kind of loss or liability suffered or incurred by the Carrier on account of the said accidents or events, and (3) the Merchant shall inspect the container(s) when the same are furnished by or on behalf of the Carrier, and they shall be deemed to have been accepted by the Merchant as being in sound and suitable condition for the purpose of the transport contracted herein, unless he gives notice to the contrary in writing to the Carrier, and (4) if the container(s) are delivered by the Carrier with seals intact, such delivery shall be deemed as full ad complete performance of the Carrier''s obligation hereunder and the Carrier shall not be liable for any loss of or damage to the contents of the container(s), and (5) the Carrier shall be at liberty to open the container(s) and to inspect the contents of the container(s) without notice to the Merchant at such time and place as the Carrier may deem necessary and all expenses incurred therefrom shall be borne by the Merchant; in case the seals of container(s) are broken by the customs or other authorities for inspection of the contents of the said container(s), the Carrier shall not be liable for any loss, damage, expense or any other consequences arising or resulting therefrom. 
							</p>
							<p style="text-align:justify; width: 98%;  font-size:8px;">
							10. (Dangerous Goods, Contraband) (1) The Carrier undertakes to carry the goods of an explosives, inflammable, radioactive, corrosive, damaging, noxious, hazardous, poisonous, injurious or dangerous nature only upon the Carrier''s acceptance of a prior written application by the Merchant for the carriage of such goods. Such application must accurately state the nature, name, label and classification of the goods as well as the method of rendering them innocuous, with the full names and addresses of the shipper and the consignee.  (2) The Merchant shall undertake that the nature of the goods referred to in the preceding paragraph is distinctly and permanently marketed and manifested on the outside of the package(s) and container(s) and shall also undertake to submit the documents or certificates required by any applicable statutes or regulations or by the Carrier. 
							</p>
							</div>
							<div style="float: right; width: 50%;"></div>
							<p style="text-align:justify;  font-size:8px;">(3) Whenever the goods are discovered to have been received by the Carrier without complying with the paragraph (1) or (2) above or the goods are found to be contraband or prohibited by any laws or regulations of the port of loading, discharge or call or any place or waters during the transport, the Carrier shall be entitled to have such goods tendered innocuous, thrown overboard or discharged or otherwise disposed of at the Carrier''s discretion without compensation and the Merchant shall be liable for and indemnify the Carrier against any kind of loss, damage or liability including loss of freight, and any expenses directly or indirectly arising out of or resulting from such goods. (4) The Carrier may exercise or enjoy the right or benefit conferred upon the Carrier under the preceding paragraph whenever it is apprehended that the goods received in compliance with paragraphs (1) and (2) above become dangerous to the Carrier, vessel, cargo, persons and/or other property.  (5) The Carrier has the right to inspect the contents of the packages(s) or container(s) at any time and anywhere without the Merchant''s agreement but only at the risk and expense of the Merchant</p>
							<p style="text-align:justify; font-size:8px;">
							11. (Deck Cargo) (1) The Carrier has the right to carry the goods in container(s) under deck or on deck. (2) When the goods are carried on deck, the Carrier shall not be required to specially note, mark or stamp any statement of "on deck stowage" on the face hereof, any customs to the contrary notwithstanding, and the goods so carried shall be subject to the applicable Hague Rules Legislation as provided for in Article 2 hereof, and shall be deemed to be carried under deckfor all purposes including general average.
							</p>
							<p style="text-align:justify; font-size:8px;">
							12. (Valuable Goods) The Carrier shall not be liable to any extent for any loss of or damage to or in connection with platinum, gold, silver, jewellry, precious stones, precious metals, radiosiotopes, precious chemicals, bullion, specie,currency, negotiable instruments, securities, writings, documents, pictures, embroideries, works of art, curios, heirlooms, collection of every nature or any other valuable goods whatsoever including goods having particular value only for the Merchant, unless the true nature and value of the goods have been declared in writing by the Merchant before receipt of the goods by the Carrier, and the same is inserted in this Bill of Lading and ad valorem freight has been prepaid thereon.
							</p>
							<p style="text-align:justify; font-size:8px;">
							13. (Heavy Lift) (1) the weight of a single piece or package exceeding 2,240 lbs, gross must be declared by the Merchant in writing before receipt by the Carrier and must be marked clearly and durably on the outside of the piece or package in letters and figures not less than two inches high. (2) In case of the Merchant''s failure in his obligations under the preceding paragraph, the Carrier shall not be responsible for any loss of or damage to or in connection with the goods, and at the same time the Merchant shall be liable for or damage to any property or for personal injury arising as a result of the Merchant''s said failure and shall indemnify the Carrier against any kind of loss or liability suffered or incurred by the Carrier as a result of such failure.
							</p>
							<p style="text-align:justify; font-size:8px;">
							14. (Delivery by Marks) (1) The Carrier shall not be liable for failure of or delay in delivery in accordance with marks unless such marks shall have been clearly and durably stamped or marked upon the goods, packages(s) and container(s) by the Merchant before the Merchant before they are received by the Carrier in letters and numbers not less than two inches high, together with names of the port of discharge and place of delivery. (2) In no circumstances shall the Carrier be responsible for delivery in accordance with other than leading marks. (3) The Merchant warrants to the Carrier that the marks on the goods, package(s) and container(s) correspond to the marks shown on this Bill of Lading and also in all respects comply with all laws and regulations in force at the port of discharge or place of delivery, and shall indemnify the Carrier against all loss, damage, expenses, penalties and fines arising or resulting from incorrectness or incompleteness thereof. (4) Goods which cannot be identified as to marks and numbers, cargo sweepings, liquid residue and any unclaimed goods not otherwise accounted for shall be allocated for the purpose of completing delivery to the various consignees of good of like character, in proportion to any apparent shortage, loss of weight or damage, and such goods or parts thereof shall be accepted as full and complete delivery.
							</p>
							<p style="text-align:justify; font-size:8px;">
							15. (Delivery) (1) The Carrier shall have the right to deliver the goods at any time from or at the vessel''s side, craft,custom-house, warehouse, wharf, quay or any other place or point designated by the Carrier within the geographical range of the port of discharge or placeof delivery shown on the face hereof. (2) In any case the Carrier''s responsibility shall cease when the goods have been delivered to the Merchant, his agents or servants, inland carriers or any other persons entitled to receive the goods at the delivering place designated by the Carrier (3) If the goods are delivered to or taken into the custody of customs or other government officials, such action shall constitute complete and final discharge of the Carrier''s obligation hereunder. (4) In case the cargo received by the Carrier is container(s) into which contents have been packed by or on behalf of the Merchant, the Carrier shall only be responsible for delivery of the total number of container(s) shown on the face hereof, and shall not be required to unpack the container(s) and deliver the contents thereof in accordance with brands, marks, numbers, sizes or types of packages or pieces. (5) If the goods are unclaimed during a reasonable time, or whenever in the Carrier''s opinion, the goods will become deteriorated, decayed or worthless, the Carrier may, at his discretion and subject to his lien and without any responsibility attaching to him, sell, abandon or otherwise dispose of such goods solely at the risk and expenses of the Merchant.
							</p>
							<p style="text-align:justify; font-size:8px;">
							16. (Transhipment and Forwarding) (1) Whether arranged beforehand or not, the Carrier shall be at liberty without notice to carry the goods wholly or partly by the named or any other vessel(s), craft or other means of transport by water, land or air. The Carrier may under any circumstances whatsoever discharge the goods or any part thereof at any port or place for transhipment and store the same afloat or ashore and then forward the same by any means of transport. (2) In case the goods herein specified cannot be found at the port of discharge or place of delivery or if they be miscarried, they, when found, may be forwarded to their intented port of discharge or place of delivery at the Carrier''s expense but the Carrier shall not be liable for any loss, damage, delay or depreciation arising from such forwarding.
							</p>
							<p style="text-align:justify; font-size:8px;">
							17. (Fire) The Carrier shall not be liable for any loss or damage wheresoever and whensoever occurring by reason of any fire whatsoever, including that occurring before loading on or after discharge from the vessel, unless such fire shall have been caused by the actual fault or privity of the Carrier.
							</p>
							<p style="text-align:justify; font-size:8px;">
							18. (Freight and Charges) (1) Freight may be calculated on the basis of the particulars of the goods furnished by the Merchant who shall be deemed to have guaranteed to the Carrier the accuracy of the contents, weight, measure or value as furnished by him, at the time of receipt of the goods by the Carrier, but the Carrier may, for the purpose of ascertaining the actual particulars, at any time, open the container(s) and/or package(s) and examine contents, weight, measure and value of the goods at the risk and expense of the Merchant. In case of incorrect declaration of the contents, weight, measure or value of the goods, the Merchant shall be liable for and bound to pay to the Carrier, (a) the balance of freight between the freight charged and that which would have been due had the correct details been given, plus (b) as and by way of liquidated and ascertained damages, a sum equal to the correct freight. (2) Full freight to the port of discharge or place of delivery named herein shall be considered as completely earned on receipt of the goods by the Carrier, whether the freight be stated as or intended to be prepaid, or to be collectible at destination. The Carrier shall be entitled to all freight and other charges due hereunder, whether actually paid or not, and to receive and retain them irrevocably under any circumstances whatsoever, whether the goods be lost or not, Full freight shall be paid on damaged or unsound goods. (3) The payment of freight and/or charges shall be made in full and in cash without any offset, counterclaim or deduction. (4) Freight and all other charges shall be paid in the currency named in this Bill of Lading, or at the Carrier''s option, in other currency subject to the regulations of the freight conference concerned or custom at the place of payment. (5) All dues, taxes and charges or other expenses in connection with the goods shall be paid by the Merchant. (6) The Merchant shall reimburse the Carrier in proportion to the amount of freight for any costs for deviation or delay or any other increase of costs of whatever nature caused by way, warlike operations, epidemics, strikes, government directions or force majeure. (7) The shipper, consignee, owner of the goods and holder of this Bill of Lading shall be jointly and severally liable to the Carrier for the payment of all freight and charges and for the performance of the obligation of each of them hereunder.
							</p>
							<p style="text-align:justify; font-size:8px;">
							19. (Line) The Carrier shall have a lien on the goods, which shall survive delivery, for all freight, charges, expenses and any other sums whatsoever payable by or chargeable to or for the account of the Merchant under this Bill of Lading and under any contract preliminary hereto and for the cost of receiving such freight, charges, expenses, etc, and may enforce this lien by public or private sale and without notice. 
							</p>
							<p style="text-align:justify; font-size:8px;">
							20. (Notice of Claim and Time for Suit) (1) Unless notice of loss or damage and the general nature of such loss or damage be given in writing to the Carrier at the port of discharge or place of delivery before or at the time of delivery of the goods or, if the loss or damage be not apparent, within 3 days after delivery, the goods shall be deemed to have been delivered as described in this Bill of Lading. (2) In any event the Carrier shall be discharged from all liability in respect of non-delivery, misdelivery, delay, loss or damage unless suit is brought within three month after delivery of the goods or the date when the goods should have been delivered.
							</p>
							<p style="text-align:justify; font-size:8px;">
							21. (Limitation of Liability) (1) All claims for which the Carrier may be liable shall be adjusted and settled on the basis of the Merchant''s net invoice cost, plus freight and insurance premium, if paid. In no event shall the Carrier be liable for any loss of possible profit or any consequential loss. (2) As far as the loss of or damage to or in connection with the goods occurred during the part of carriage to which the Hague Rules Legislation shall apply, (i) the Carrier shall not be liable for loss or damage in an amount exceeding five hundreed dollars in U.S. currency (US$500) per package or unit, unless the value of the goods higher than this amount has been declared in written by the Merchant before receipt of the goods and inserted in this Bill of Lading together with nature thereof and extra freight has been paid as required. If the actual value of the goods per package or unit exceeds such declared value, the value shall nevertheless be deemed to be the declared value and the Carrier''s liability, if any, shall not exceed the declared value. Any partial loss or damage shall be adjusted pro rate on the base of such declared value. In case the declared value is markedly higher than the actual value, the Carrier shall in no event be liable to pay any compensation, and (ii) where the cargo has been either packed into container(s) or unitized into similar articles(s) of transport by or on behalf of the Merchant, it is expressly agreed that the number of such container(s) or similar article(s) of transport shown on the face hereof shall be considered as the number of the package(s) or unit(s) for the purpose of the application of the limitation of liability provided for herein.
							</p>
							<p style="text-align:justify; font-size:8px;">
							22. (General Average) (1) General average shall be adjusted, stated and settled at Seoul or any other port or place at the Carrier''s option according to the York-Antwerp Rules, 1950 and as to matters not provided for by these Rules, according to the laws and usages of the port or place of adjustment, and in the currency selected by the Carrier. The general average statement shall be prepared by the adjusters appointed by the Carrier. Average agreement or bond and such cash deposit as the Carrier may deem sufficient to cover the estimated contribution of the goods, and any salvage and special charges thereon, and any other additional securities as the Carrier may requires shall be furnishe by the Merchant to the Carrier before delviery of the goods. (2) In the event of accident, danger, damage or disaster, before or after commencement of the voyage resulting from any cause whatsoever, whether due to negligence or not, for which or for the consequence of which the Carrier is not responsible by statue, contract or otherwise, the goods and the Merchant shall jointly and severally contribute with the Carrier in general average to the payment of any sacrifices, loss or expenses of a general average nature that may be made or incurred and shall pay salvage and special charges incurred in respect of the goods.
							</p>
							<p style="text-align:justify; font-size:8px;">
							23. (Both to Blame Collision) If the vessel comes into collision with another ship as a result of the negligence of the other ship, and any act, neglect or default of the master, mariner, pilot or the servants of the owner of the vessel in the navigation or in the management of the vessel, the Merchant shall indemnify the Carrier against all loss or liability which might be incurred directly or indirectly to the other or non-carrying ship or her owners in so far as such loss or liability represents loss of or damage to this goods or any claim whatsoever of the Merchant paid or payable by the other or non-carrying ship or her owners to the Merchant and self-off, recouped or recovered by the other or non-carrying ship or her owners to the Merchant and self-off, recouped or recovered by the other or non-carrying ship or her owners as part of their claim against the carrying vessel or the owner thereof. The foregoing provisions shall also apply where the owners, operators or house in charge of any ship or ships or objects other than, or in addition to, the colliding ships or objects are at fault in respect of a collision or contact.
							</p>
							<p style="text-align:justify; font-size:8px;">
							24. (Governing Law and Jurisdiction) The contract evidenced by or contained in this Bill of Lading shall be governed by U.S.A. law except as may be otherwise provided herein, and any action thereunder shall be brought before the Civil Court of Los Angeles U.S.A. however the Carrier may bring such action to another jurisdiction.
							</p>
							</div>
                        </div>
						
						

