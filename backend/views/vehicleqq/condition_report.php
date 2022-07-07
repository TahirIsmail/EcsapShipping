<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use kartik\file\FileInput;
use yii2assets\printthis\PrintThis;
$roles =   Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
?>

<?php
echo PrintThis::widget([
    'htmlOptions' => [
        'id' => 'conditionreport',
        'btnClass' => 'btn btn-primary',
        'btnId' => 'btnPrintThisdock',
        'btnText' => 'Print',
        'btnIcon' => 'fa fa-print'

    ],
    'options' => [
        'debug' => false,
        'importCSS' => true,
        'importStyle' => false,
        'loadCSS' => "path/to/my.css",
        'scale'=>90,
        'pageTitle' => "",
        'removeInline' => false,
        'printDelay' => 200,
        'header' => null,
        'formValues' => true,
    ]
]);
?>
<?php
if(!isset($roles['customer'])){
    echo Html::a('<i class="fa fa-envelope"></i> Email', ['/vehicle/mpdf', 'id' => $model->id,'mail'=>true], [
        'class' => 'btn btn-primary',
        'target' => '_blank',
        'data-toggle' => 'tooltip',
        'title' => 'Will send the mail to customer'
    ]);
}
?>
<?php
echo Html::a('<i class="fa fa-file-pdf-o"></i> Open as Pdf', ['/vehicle/mpdf', 'id' => $model->id], [
    'class' => 'btn btn-primary',
    'target' => '_blank',
    'data-toggle' => 'tooltip',
    'title' => 'Will open the generated PDF file in a new window'
]);
?>
<div id="conditionreport" class="condition_reports">
    <div class="cond_here">
        <div class="row">
      <div class="col-md-12">
        <div class="cond_logo lefti">
            <img src="<?= \yii\helpers\Url::to('@web/uploads/logo.jpg', true) ?>" width="224" height="72" class="print-logo" alt="ArianaW Logo">
        </div>

        <div class="lefti title">Vehicle Condition Report</div>
        </div>
            </div>
        <div class="basic_info">
 <div class="row">
      <div class="col-md-6">
            <div class="part1">
                <table width="100%">
                    <tbody><tr>
                            <td width="18%"><b>Customer</b></td>
                            <td width="82%" class="line_under" id="CUSTOMER NAME"><?= $model->customerUser->company_name; ?></td>
                        </tr>
                    </tbody></table>

                <table width="100%">
                    <tbody><tr>
                            <td width="18%"><b>Address</b></td>
                            <td width="72%" class="line_under" id="Address L1"><?= isset(\common\models\Lookup::$location[$model->location])?\common\models\Lookup::$location[$model->location]:$model->location; ?></td>

                        </tr>
                    </tbody></table>

                <table width="100%">
                    <tbody><tr>
                            <td width="18%"><b>Phone #</b></td>
                            <td width="44%" class="line_under" id="Phone Number"><?= $model->customerUser->phone; ?></td>
                            <td width="14%"><b>Weight</b></td>
                            <td width="24%" class="line_under" id="Weight"><?= $model->weight; ?></td>  
                        </tr>
                    </tbody></table>

                <table width="100%">
                    <tbody><tr>
                            <td width="18%"><b>Lot #</b></td>
                            <td width="44%" class="line_under" id="Lot Number"><?= $model->lot_number; ?></td>
                            <td width="14%"><b>Inv #</b></td>
                            <td width="24%" class="line_under" id="Hat Number"><?= $model->hat_number; ?></td>  
                        </tr>
                    </tbody></table>

                <table width="100%">
                    <tbody><tr>
                            <td width="18%"><b>Destination</b></td>
                            <td width="82%" class="line_under" id="Destination"></td>
                        </tr>
                    </tbody></table>

                               <table width="100%">
                    <tbody>
                    <tr>
                            <td width="6%"><b>Condition</b></td>
                            <td width="24%" class="line_under" id="Condition"><?php if ($model->towingRequest->condition == '1') {
                                echo 'Operable';
                            } else {
                                echo 'Non Operable';
                            } ?></td>
                                                        <td width="6%"><b>Damaged</b></td>
                                                        <td width="24%" class="line_under" id="Damages"><?php if ($model->towingRequest->damaged == '1') {
                                echo 'Yes';
                            } else {
                                echo 'No';
                            }; ?></td>  
                        </tr>
                    </tbody></table>

       
            </div>
           </div>
           
                <div class="col-md-6">
            <div class="part2">
                <table width="100%">
                    <tbody><tr>
                            <td width="18%"><b>Year</b></td>
                            <td width="38%" class="line_under" id="Year"><?= $model->year; ?></td>
                            <td width="11%"><b>Color</b></td>
                            <td width="33%" class="line_under" id="Color"><?= $model->color; ?></td>  
                        </tr>
                    </tbody></table>

                <table width="100%">
                    <tbody><tr>
                            <td width="18%"><b>Model</b></td>
                            <td width="38%" class="line_under" id="Model"><?= $model->model; ?></td>
                            <td width="11%"><b>Make</b></td>
                            <td width="33%" class="line_under" id="Make"><?= $model->make; ?></td>  
                        </tr>
                    </tbody></table>

                <table width="100%">
                    <tbody><tr>
                            <td width="18%"><b>VIN</b></td>
                            <td width="82%" class="line_under" id="VIN"><?= $model->vin; ?></td>
                        </tr>
                    </tbody></table>

                <table width="100%">
                    <tbody><tr>
                            <td width="18%"><b>License#</b></td>
                            <td width="82%" class="line_under" id="License Number"><?= $model->license_number; ?></td>
                        </tr>
                    </tbody></table>

                <table width="100%">
                    <tbody><tr>
                            <td width="30%"><b>Towed From</b></td>
                            <td width="70%" class="line_under" id="Towed From"><?= $model->towed_from; ?></td>
                        </tr>
                    </tbody></table>

                <table width="100%">
                    <tbody><tr>
                            <td width="30%"><b>Tow Amount</b></td>
                            <td width="31%" class="line_under" id="Tow Amount"><?= $model->towed_amount; ?></td>
                            <td width="20%"><b>Storage Amount</b></td>
                            <td width="14%" class="line_under" id="Storage"><?= $model->storage_amount; ?></td>  
                        </tr>
                    </tbody></table>
            </div>
                    </div>
                    <div class="col-md-6">

                    <table width="100%">
                    <tbody><tr>
                            <td width="6%"><b>Towed </b></td><td width="12%" class="line_under" id="Damages"><?php if ($model->towingRequest->towed == '1') {
    echo 'Yes';
} else {
    echo 'No';
}; ?></td>  
                            <td width="21%"><b>Title Provided</b></td><td width="11%" class="line_under" id="Damages"><?php if ($model->towingRequest->title_recieved == '1') {
    echo 'Yes';
} else {
    echo 'No';
}; ?></td>  
                            <td width="6%"><b>Pictures</b></td><td width="24%" class="line_under" id="Damages"><?php if ($model->towingRequest->pictures == '1') {
    echo 'Yes';
} else {
    echo 'No';
}; ?></td>  
                        </tr>
                    </tbody></table>
     </div>
</div>
            <div class="checklist">
                <table width="100%">
                    <thead>
                        <tr>
                            <th class="biga">CHECK OPTIONS INCLUDED IN VEHICLE</th>
                        </tr>
                    </thead>
                </table>

                <table width="100%">
      <tbody>
   
      <tr>
      <?php 
      $i = 0;
      $features =   \common\models\Features::find()->all();        
      
      //$features = Yii::$app->db->createCommand('SELECT * FROM features f left join vehicle_features vf on vf.features_id=f.id where  vf.vehicle_id ='.$model->id.';')->queryAll();
      foreach($features as $features) { 
        $featuredata = \common\models\VehicleFeatures::find()->where(['=','vehicle_id',$model->id])->andWhere(['=','features_id',$features->id])->andWhere(['=','value',1])->one();
        $checked = false; 
  if($featuredata){
        $checked = true; 
     }
     if($i !== 6 )
     {?>
     <?php
      if($checked == true){?>
      <td><input disabled="true" name="Keys" <?php  if($checked == true){ echo "checked='checked'";} ?> type="checkbox"><?php echo $features['name']; ?></td>
      <?php }else{?>
        <td><input disabled="true" name="Keys" <?php  if($checked == true){ echo "checked='checked'";} ?> type="checkbox"><?php echo $features['name']; ?></td>

      <?php } ?>
<?php
     }else{
    ?>
    </tr>
    <tr>
   <?php    if($checked == true){?>
         
      <td><input disabled="true" name="Keys" <?php  if($checked == true){ echo "checked='checked'";} ?> type="checkbox"><?php echo $features['name']; ?></td>
      <?php }else{?>
        <td><input disabled="true" name="Keys" <?php  if($checked == true){ echo "checked='checked'";} ?> type="checkbox"><?php echo $features['name']; ?></td>
      <?php } ?>
      <?php
     }
    $i++;
}
?>
      </tr>
  
      
      </tbody>
      </table>

            </div>
            <div class="condition">
                <table width="100%">
                    <thead>
                        <tr>
                            <th class="biga">CONDITION OF VEHICLE</th>
                        </tr>
                        <tr>
                            <th class="biga1">Indicate any damage to the vehicle in the space provided using your own words or the following legend. If None write None</th>
                        </tr>
                    </thead>
                </table>

                <table id="Sik" width="100%">
                    <tbody>
                        <tr>
                            <td>H - Hairline Scratch</td>
                            <td>PT - Pitted</td>
                            <td>T - Torn</td>
                            <td>B - Bent</td>
                            <td>GC - Glass Cracked</td>
                            <td>M - Missing</td>
                        </tr>
                        <tr>
                            <td>SM - Smashed</td>
                            <td>R - Rusty</td>
                            <td>CR - Creased</td>
                            <td>S - Scratched</td>
                            <td>ST - Stained</td>
                            <td>BR - Broken</td>
                            <td>D - Dented</td>
                        </tr>
                    </tbody>
                </table>


            </div>
<?php
$features = Yii::$app->db->createCommand('SELECT * FROM `condition` f left join vehicle_condition vf on vf.condition_id=f.id where  vf.vehicle_id =' . $model->id . '  ;')->queryAll();
if($features){
?>
            <div class="row">
                <div class="col-md-6">
            <div class="picas1">
                <span class="lefti"><img src="<?= \yii\helpers\Url::to('@web/uploads/Car - Front.jpg', true) ?>" ></span>										
                <span class="lefti" id="piss">
                    <?php if(isset($features[0]['value'])){ ?>
                    <div class="line_under"> <table><tbody><tr><td>1</td><td align="center" id="1"><?php echo $features[0]['value']; ?></td></tr></tbody></table></div>
                    <?php } if(isset($features[1]['value'])){ ?>
                    <div class="line_under"> <table><tbody><tr><td>2</td><td align="center" id="2"><?php echo $features[1]['value']; ?></td></tr></tbody></table></div>
                    <?php } if(isset($features[2]['value'])){ ?>
                    <div class="line_under"> <table><tbody><tr><td>3</td><td align="center" id="3"><?php echo $features[2]['value']; ?></td></tr></tbody></table></div>
                    <?php } if(isset($features[3]['value'])){ ?>
                    <div class="line_under"> <table><tbody><tr><td>4</td><td align="center" id="4"><?php echo $features[3]['value']; ?></td></tr></tbody></table></div>
                    <?php } if(isset($features[4]['value'])){ ?>
                    <div class="line_under"> <table><tbody><tr><td>5</td><td align="center" id="5"><?php echo $features[4]['value']; ?></td></tr></tbody></table></div>
                    <?php } ?>
                </span>
            </div>
                    </div>
 <div class="col-md-6">
            <div class="picas2">
                <span class="lefti"><img src="<?= \yii\helpers\Url::to('@web/uploads/Car - Back.jpg', true) ?>" ></span>										
                <span class="lefti" id="piss2">
                <?php if(isset($features[5]['value'])){ ?>
                    <div class="line_under"><table><tbody><tr>
                                    <td>6</td><td align="center" id="6"><?php echo $features[5]['value']; ?></td></tr></tbody></table></div>
                    <?php } if(isset($features[6]['value'])){ ?>
                    <div class="line_under"> <table><tbody><tr>
                                    <td>7</td><td align="center" id="7"><?php echo $features[6]['value']; ?></td></tr></tbody></table></div>
                    <?php } if(isset($features[7]['value'])){ ?>
                    <div class="line_under"> <table><tbody><tr>
                                    <td>8</td><td align="center" id="8"><?php echo $features[7]['value']; ?></td></tr></tbody></table></div>
                    <?php } if(isset($features[8]['value'])){ ?>
                    <div class="line_under"> <table><tbody><tr>
                                    <td>9</td><td align="center" id="9"><?php echo $features[8]['value']; ?></td></tr></tbody></table></div>
                    <?php } if(isset($features[9]['value'])){ ?>
                    <div class="line_under"> <table><tbody><tr><td>10</td><td align="center" id="10"><?php echo $features[9]['value']; ?></td></tr></tbody></table></div>
                    <?php } ?>
                </span>
            </div>
 </div>
                 </div>
               <div class="row">
                <div class="col-md-6">
            <div class="picas3">
                <div class="">
                    <img src="<?= \yii\helpers\Url::to('@web/uploads/driver.jpg', true) ?>" width="384" height="141"></div>
                <div id="yoba"> 
                    <table width="100%">
                        <tbody><tr>
                                <?php if(isset($features[10]['value'])){ ?>
                                <td width="6%">11</td><td class="line_right" align="center" width="28%"><?php echo $features[10]['value']; ?></td>
                                <?php } if(isset($features[11]['value'])){ ?>
                                <td width="6%">12</td><td class="line_right" align="center" width="27%"><?php echo $features[11]['value']; ?></td>
                                <?php } if(isset($features[12]['value'])){ ?>
                                <td width="6%">13</td><td align="center" width="27%"><?php echo $features[12]['value']; ?></td>
                                <?php } ?>
                            </tr>
                        </tbody></table>
                </div>

                <div id="yoba">
                    <table width="100%">
                        <tbody><tr>
                                <?php if(isset($features[13]['value'])){ ?>
                                <td width="6%">14</td><td align="center" class="line_right" width="28%"><?php echo $features[13]['value']; ?></td>
                                <?php } if(isset($features[14]['value'])){ ?>
                                <td width="6%">15</td><td align="center" class="line_right" width="27%"><?php echo $features[14]['value']; ?></td>
                                <?php } if(isset($features[15]['value'])){ ?>
                                <td width="6%">16</td><td align="center" width="27%"><?php echo $features[15]['value']; ?></td>
                                <?php }?>
                            </tr>
                        </tbody></table>
                </div>

            </div>
</div>
                                   <div class="col-md-6">

                                   <div class="picas3">
                <div class="">
                    <img src="<?= \yii\helpers\Url::to('@web/uploads/Passenger.jpg', true) ?>" width="384" height="141"></div>
                <div id="yoba"> 
                <table width="100%">
                <tbody><tr>
                        <?php if(isset($features[16]['value'])){ ?>
                        <td width="6%">17</td><td align="center" class="line_right" width="28%"><?php echo $features[16]['value']; ?></td>
                        <?php } if(isset($features[17]['value'])){ ?>
                        <td width="6%">18</td><td align="center" class="line_right" width="27%"><?php echo $features[17]['value']; ?></td>
                        <?php } if(isset($features[18]['value'])){ ?>
                        <td width="6%">19</td><td align="center" width="27%"><?php echo $features[18]['value']; ?></td>
                        <?php } ?>
                    </tr>
                </tbody></table>
                </div>

                <div id="yoba">
                <table width="100%">
                <tbody><tr>
                        <?php if(isset($features[19]['value'])){ ?>
                        <td width="6%">20</td><td align="center" class="line_right" width="28%"><?php echo $features[19]['value']; ?></td>
                        <?php } if(isset($features[20]['value'])){ ?>
                        <td width="6%">21</td><td align="center" class="line_right" width="27%"><?php echo $features[20]['value']; ?></td>
                        <?php } if(isset($features[21]['value'])){ ?>
                        <td width="6%">&nbsp;</td><td width="27%"></td>
                        <?php } ?>
                    </tr>
                </tbody></table>
                </div>

            </div>



        
                                       </div>
               </div>
<?php } ?>
            <div class="papugay">
                <table width="100%">
                    <tbody><tr><td><b>1.</b> Liability-Shipper (customer) must have door-to-door insurance while goods are in warehouse and during transit. Ariana Worldwide will not
                                assume any responsibility for uninsured or underinsured shipment(s).</td></tr>

                        <tr><td><b>2.</b> Rates for individual cars are based on consolidation; company is not responsible for exact shipping dates. Company is not responsible for delays
                                in shipping schedules and/or transit time or custom charges and delays..</td></tr>
                    </tbody></table>

            </div>

            <div class="dimen"><table width="100%">
                    <tbody><tr>
                            <td>
                                <b>DIMENSIONS: </b>
                                The above is an accurate representation of the condition of the vehicle at the time of loading. NOTICE: The OWNER'S or AUTHORIZED AGENT'S
                                Signature of the origin is also to the following RELEASE: this will authorize CARRIER to drive my vehicle either at origin destination between point
                                (s) of loading/unloading and the point(s) of pick-up/delivery.
                            </td>
                        </tr>
                    </tbody></table>

            </div>

            <div class="sign"><table width="100%">
                    <tbody><tr>
                            <td>
                                This above Vehicle has been delivered in the condition described.
                            </td>
                        </tr>
                    </tbody></table></div>

            <div class="sign"><table>
                    <tbody><tr>
                            <td class="leni line_under">&nbsp;
                            <?php //echo 'JMKC EXPRESS';?>
                            </td>
                            <td class="leni1 line_under">
                            <?php //$model->towingRequest->deliver_date;?>
                              </td>
                        </tr>
                        <tr><td align="center" class="leni ">
                                <b>Completed By</b>
                            </td>
                            <td align="center" class="leni1 ">
                                <b>Date</b>
                            </td>
                        </tr>


                    </tbody></table></div>
        </div>


    </div>




    <div class="customer_part">
        <!-- <div class="lefti">
            <img src="../uploads/Logo.png" width="224" height="72" alt="ArianaW Logo">
            </div> -->
        <div class="row">
        <div class="pics">
<?php $images = $model->images;
foreach ($images as $images) {
    ?>
                <div class="col-md-4"><img width="230px" height="230px" src="../uploads/<?php echo $images->name; ?>"></div>
    <?php
}
?>


</div>
        </div>

    </div>

</div>

