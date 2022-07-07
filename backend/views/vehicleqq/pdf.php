<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $model common\models\Vehicle */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vehicles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <!-- Modal content-->

      <div class="">
    
<div id="" class="">
  <div class="cond_here">
    <div class="row center" style="width: 100%">
    <div class="cond_logo lefti center"style="width: 30%; float:left;">
   
    <img src="<?= \yii\helpers\Url::to('@web/uploads/logo.jpg', true)?>" width="224" height="72" alt="ArianaW Logo">
    </div>
    <div class="lefti title center" style="width: 40%;float:left;text-align:center;padding-top:5px;"><h5>131 East Gardena<br> Boulevard Gardena, CA 90248<br>
 Tel: (310) 532-8557</h5></div>
  	
    <div class="lefti title" style="width: 30%;float:left;text-align:center;padding-top:5px;"><h4><b>Vehicle Condition Report</b></h4></div>
    </div>
    <div class="basic_info">
      
      <div class="part1" style="float: left;
	width: 50%;">
			<table width="100%" style="">
            <tbody><tr>
            <td width="18%" style="background-color: #d9fbfa;border: 1px solid #000; height: 18px;; "><b>Customer</b></td>
            <td width="82%" class="line_under" style="border: 1px solid #000; height: 18px;;" id="CUSTOMER NAME"><?= $model->customerUser->company_name;?></td>
            </tr>
            </tbody></table>
            
			<table width="100%" style=";">
            <tbody><tr>
            <td width="18%" style="background-color: #d9fbfa;border: 1px solid #000; padding: 0px; height: 39px;"><b>Address</b></td>
            <td width="72%" class="line_under" style="border: 1px solid #000; padding: 0px; height: 18px; height: 39px;" id="Address L1"><?= isset(\common\models\Lookup::$location[$model->location])?\common\models\Lookup::$location[$model->location]:$model->location; ?></td>
           
            </tr>
            </tbody></table>
            
<table width="100%" style="">
            <tbody><tr>
            <td width="18%" style="background-color: #d9fbfa;border: 1px solid #000; height: 18px;font-size:12px; "><b>Phone #</b></td>
            <td width="44%" class="line_under" style="border: 1px solid #000; height: 18px;;" id="Phone Number"><?= $model->customerUser->phone;?></td>
            <td width="14%" style="background-color: #d9fbfa;border: 1px solid #000; height: 18px;font-size:12px;"><b>Weight</b></td>
            <td width="24%" class="line_under" style="border: 1px solid #000; height: 18px;;" id="Weight"><?= $model->weight;?></td>  
            </tr>
        </tbody></table>
            
<table width="100%" style="">
            <tbody><tr>
            <td width="18%" style="background-color: #d9fbfa;border: 1px solid #000; height: 18px;; "><b>Lot #</b></td>
            <td width="44%" class="line_under" style="border: 1px solid #000; height: 18px;;" id="Lot Number"><?= $model->lot_number;?></td>
            <td width="14%" style="background-color: #d9fbfa;border: 1px solid #000; height: 18px;; "><b>Inv #</b></td>
            <td width="24%" class="line_under" style="border: 1px solid #000; height: 18px;;" id="Hat Number"><?= $model->hat_number;?></td>  
            </tr>
        </tbody></table>
            
            <table width="100%" style="">
            <tbody><tr>
            <td width="18%" style="background-color: #d9fbfa;border: 1px solid #000; height: 47px;;"><b>Destination</b></td>
            <td width="82%" class="line_under" style="border: 1px solid #000; height: 47px;" id="Destination"></td>
            </tr>
            </tbody></table>
            
<table width="100%" style="margin-top: 1px;margin-bottom:5px;">
            <tbody><tr>
            <td width="18%" style="background-color: #d9fbfa;border: 1px solid #000; height: 45px;font-size: 15px;"><b>Condition</b></td>
            <td width="44%" class="line_under" style="border: 1px solid #000; height: 45px;" id="Condition"><?php if($model->towingRequest->condition== '1'){echo 'Operable';}else{echo 'Non Operable';}?></td>
            <td width="20%" style="background-color: #d9fbfa;border: 1px solid #000; height: 45px; "><b>Damaged</b></td>
            <td width="24%" class="line_under" style="border: 1px solid #000; height: 45px;" id="Damages"><?php if($model->towingRequest->damaged== '1'){echo 'Yes';}else{echo 'No';};?></td>  
            </tr>
        </tbody></table>
          

      </div>
      
      
      
      
      
      <div class="part2" style="float: left;
	width: 50%;
	margin-left: 1%;">
<table width="100%" style="">
            <tbody><tr>
            <td width="18%" style="background-color: #d9fbfa;border: 1px solid #000; height: 18px;; "><b>Year</b></td>
            <td width="38%" class="line_under" style="border: 1px solid #000; height: 18px;;" id="Year"><?= $model->year;?></td>
            <td width="11%" style="background-color: #d9fbfa;border: 1px solid #000; height: 18px;;"><b>Color</b></td>
            <td width="33%" class="line_under" style="border: 1px solid #000; height: 18px;;" id="Color"><?= $model->color;?></td>  
            </tr>
        </tbody></table>
            
            <table width="100%" style="">
            <tbody><tr>
            <td width="18%" style="background-color: #d9fbfa;border: 1px solid #000; height: 39px; "><b>Model</b></td>
            <td width="38%" class="line_under" style="border: 1px solid #000; height: 18px;" id="Model"><?= $model->model;?></td>
            <td width="11%" style="background-color: #d9fbfa;border: 1px solid #000; height: 39px;"><b>Make</b></td>
            <td width="33%" class="line_under" style="border: 1px solid #000; height: 18px;" id="Make"><?= $model->make;?></td>  
            </tr>
            </tbody></table>
            
            <table width="100%" style=";">
            <tbody><tr>
            <td width="18%" style="background-color: #d9fbfa;border: 1px solid #000; height: 18px;;"><b>VIN</b></td>
            <td width="82%" class="line_under" style="border: 1px solid #000; height: 18px;;" id="VIN"><?= $model->vin;?></td>
            </tr>
            </tbody></table>
            
            <table width="100%" style="">
            <tbody><tr>
            <td width="18%" style="background-color: #d9fbfa;border: 1px solid #000; height: 18px;;"><b>License#</b></td>
            <td width="82%" class="line_under" style="border: 1px solid #000; height: 18px;;" id="License Number"><?= $model->license_number;?></td>
            </tr>
            </tbody></table>
            
<table width="100%" style="">
            <tbody><tr>
            <td width="35%" style="background-color: #d9fbfa;border: 1px solid #000; height: 18px;font-size:13px;"><b>Towed From</b></td>
            <td width="65%" class="line_under" style="border: 1px solid #000; height: 18px;;" id="Towed From"><?= $model->towed_from;?></td>
            </tr>
        </tbody></table>
            
<table width="100%" style="">
            <tbody><tr>
            <td width="35%" style="background-color: #d9fbfa;border: 1px solid #000; height: 23px;font-size: 12px; "><b>Towed Amount</b></td>
            <td width="14%" class="line_under" style="border: 1px solid #000; height: 23px;;" id="Tow Amount"><?= $model->towed_amount;?></td>
            <td width="35%" style="background-color: #d9fbfa;border: 1px solid #000;  height: 23px;font-size: 12px;;"><b>Storage Amount</b></td>
            <td width="14%" style="background-color: #d9fbfa;border: 1px solid #000;  height: 23px;;" class="line_under" style="border: 1px solid #000;" id="Storage"><?= $model->storage_amount;?></td>  
            </tr>
        </tbody></table>
        <table width="100%" style="">
            <tbody><tr>
            <td width="18%" style="background-color: #d9fbfa;border: 1px solid #000; height: 18px;; "><b>Towed </b></td><td width="12%" class="line_under" style="border: 1px solid #000;" id="Damages"><?php if($model->towingRequest->towed== '1'){echo 'Yes';}else{echo 'No';};?></td>  
            <td width="21%" style="background-color: #d9fbfa;border: 1px solid #000; height: 18px;; "><b>Title Provided</b></td><td width="11%" class="line_under" style="border: 1px solid #000;" id="Damages"><?php if($model->towingRequest->title_recieved== '1'){echo 'Yes';}else{echo 'No';};?></td>  
            <td width="14%" style="background-color: #d9fbfa;border: 1px solid #000; height: 18px;; "><b>Pictures</b></td><td width="24%" class="line_under" style="border: 1px solid #000;" id="Damages"><?php if($model->towingRequest->pictures== '1'){echo 'Yes';}else{echo 'No';};?></td>  
            </tr>
        </tbody></table>
      </div>
      <div class="checklist">
      <table width="100%" style="">
      <thead>
      <tr>
      <th class="biga" align="center" style="border: 1px solid #000;" >CHECK OPTIONS INCLUDED IN VEHICLE</th>
      </tr>
      </thead>
      </table>
      
      <table width="100%" style="">
      <tbody>
   
      <tr>
      <?php 
      $i = 0;
    //  $features = Yii::$app->db->createCommand('SELECT * FROM features f left join vehicle_features vf on vf.features_id=f.id where  vf.vehicle_id ='.$model->id.';')->queryAll();
    $features =   \common\models\Features::find()->all();        
    foreach($features as $features) { 
      $featuredata = \common\models\VehicleFeatures::find()->where(['=','vehicle_id',$model->id])->andWhere(['=','features_id',$features->id])->andWhere(['=','value',1])->one();
      
        $checked = false; 
  if($featuredata){
        $checked = true; 
     }
     if($i %5 != 0)
     {
         ?>
          <?php  if($checked == true){?>
        <td style="border: 1px solid #000;"><img src="<?= \yii\helpers\Url::to('@web/uploads/checked.png', true) ?>" height="20">										
<input disabled="true"  name="Keys"  type="checkbox"><?php echo $features['name']; ?></td>
     <?php }else{?>
      
      <td style="border: 1px solid #000;"><img src="<?= \yii\helpers\Url::to('@web/uploads/unchecked.png', true) ?>" height="20">		
      <input disabled="true" name="Keys"  type="checkbox"><?php echo $features['name']; ?></td>

<?php
     }
     }else{
    ?>
       </tr>
     <tr>
     <?php  if($checked == true){?>
        <td style="border: 1px solid #000;"><img src="<?= \yii\helpers\Url::to('@web/uploads/checked.png', true) ?>" height="20">										
<input disabled="true" name="Keys"  type="checkbox"><?php echo $features['name']; ?></td>
     <?php }else{?>
      
      <td style="border: 1px solid #000;"><img src="<?= \yii\helpers\Url::to('@web/uploads/unchecked.png', true) ?>" height="20">		
      <input disabled="true" name="Keys"  type="checkbox"><?php echo $features['name']; ?></td>

      <?php
     }
     }
    $i++;
}
?>
      </tr>
  
      
      </tbody>
      </table>
      
      </div>
   	  <div class="condition">
      	<table width="100%" style="">
          <thead>
          <tr>
          <th class="biga" style="border: 1px solid #000; text-align: center;">CONDITION OF VEHICLE</th>
          </tr>
          <tr>
          <th class="biga1" style="border: 1px solid #000;">Indicate any damage to the vehicle using the following legend.</th>
          </tr>
          </thead>
        </table>
      	
      <table id="Sik" width="100%">
      <tbody>
      <tr>
      <td style="background-color: #d9fbfa;border: 1px solid #000;width:5%">H</td>
      <td style="border: 1px solid #000;width:19%">Hairline Scratch</td>
      <td style="background-color: #d9fbfa;border: 1px solid #000;width:5%">PT</td>
      <td style="border: 1px solid #000;width:19%"> Pitted</td>
      <td style="background-color: #d9fbfa;border: 1px solid #000;width:5%">T</td>
      
      <td style="border: 1px solid #000;width:19%">Torn</td>
      <td style="background-color: #d9fbfa;border: 1px solid #000;width:5%">B</td>
      <td style="border: 1px solid #000;width:19%">Bent</td>
    
      </tr>
      <tr>
  
      <td style="background-color: #d9fbfa;border: 1px solid #000;">GC</td>
      <td style="border: 1px solid #000;">Glass Cracked</td>
      <td style="background-color: #d9fbfa;border: 1px solid #000;">M</td>
      <td style="border: 1px solid #000;">Missing</td>
      <td style="background-color: #d9fbfa;border: 1px solid #000;">SM</td>
      <td style="border: 1px solid #000;">Smashed</td>
      <td style="background-color: #d9fbfa;border: 1px solid #000;">R</td>
      <td style="border: 1px solid #000;">Rusty</td>
      </tr>
      <tr>
      <td style="background-color: #d9fbfa;border: 1px solid #000;">CR</td>
      <td style="border: 1px solid #000;">Creased</td>
      <td style="background-color: #d9fbfa;border: 1px solid #000;">S</td>
      <td style="border: 1px solid #000;">Scratched</td>
      <td style="background-color: #d9fbfa;border: 1px solid #000;">ST</td>
      <td style="border: 1px solid #000;">Stained</td>
      <td style="background-color: #d9fbfa;border: 1px solid #000;">BR</td>
      <td style="border: 1px solid #000;">Broken</td>
      
      </tr>
      <tr><td style="background-color: #d9fbfa;border: 1px solid #000;">D</td>
      <td style="border: 1px solid #000;">Dented</td></tr>
      </tbody>
      </table>
        
        
      </div>
      <?php
      $features = Yii::$app->db->createCommand('SELECT * FROM `condition` f left join vehicle_condition vf on vf.condition_id=f.id where  vf.vehicle_id ='.$model->id.';')->queryAll();
       
       ?>
      <div class="picas1">
          <table style="border: solid 1px #000;">
              <tr>
                  <td style="">
      <span class="lefti" style="display:inline-block;"><img src="<?= \yii\helpers\Url::to('@web/uploads/Car - Front.jpg', true) ?>" height="120"></span>										
</td>
<td style="width:200px;">
      <span class="lefti" style=" width:300px;">
      <div class="line_under" style=""> <table style="border: solid 1px #000;width:100%;"><tbody><tr><td width="12%" style="background-color: #d9fbfa;border: 1px solid #000; ">01</td><td align="center" id="1"><?php echo isset($features[0]['value'])?$features[0]['value']:"-"; ?></td></tr></tbody></table></div>
      <div class="line_under" style=""> <table style="border: solid 1px #000;width:100%;"><tbody><tr><td width="12%" style="background-color: #d9fbfa;border: 1px solid #000; ">02</td><td align="center" id="2"><?php echo isset($features[1]['value'])?$features[1]['value']:"-"; ?></td></tr></tbody></table></div>
      <div class="line_under" style=""> <table style="border: solid 1px #000;width:100%;"><tbody><tr><td width="12%" style="background-color: #d9fbfa;border: 1px solid #000; ">03</td><td align="center" id="3"><?php echo isset($features[2]['value'])?$features[2]['value']:"-"; ?></td></tr></tbody></table></div>
      <div class="line_under" style=""> <table style="border: solid 1px #000;width:100%;"><tbody><tr><td width="12%" style="background-color: #d9fbfa;border: 1px solid #000; ">04</td><td align="center" id="4"><?php echo isset($features[3]['value'])?$features[3]['value']:"-"; ?></td></tr></tbody></table></div>
      <div class="line_under" style=""> <table style="border: solid 1px #000;width:100%;"><tbody><tr><td width="12%" style="background-color: #d9fbfa;border: 1px solid #000; ">05</td><td align="center" id="5"><?php echo isset($features[4]['value'])?$features[4]['value']:"-"; ?></td></tr></tbody></table></div>
</span>
</td>  
<td>
<span class="lefti"><img src="<?= \yii\helpers\Url::to('@web/uploads/Car - Back.jpg', true) ?>" height="120"></span>										
</td> 
<td style="width:200px">    
<span class="lefti"  id="piss2"  >
      <div class="line_under" style=""><table style="border: solid 1px #000;width:100%;"><tbody><tr>
      <td width="12%" style="background-color: #d9fbfa;border: 1px solid #000; ">06</td><td align="center" id="6"><?php echo isset($features[5]['value'])?$features[5]['value']:"-"; ?></td></tr></tbody></table></div>
      <div class="line_under" style=""> <table style="border: solid 1px #000;width:100%;"><tbody><tr>
      <td width="12%" style="background-color: #d9fbfa;border: 1px solid #000; ">07</td><td align="center" id="7"><?php echo isset($features[6]['value'])?$features[6]['value']:"-"; ?></td></tr></tbody></table></div>
      <div class="line_under" style=""> <table style="border: solid 1px #000;width:100%;"><tbody><tr>
      <td width="12%" style="background-color: #d9fbfa;border: 1px solid #000; ">08</td><td align="center" id="8"><?php echo isset($features[7]['value'])?$features[7]['value']:"-"; ?></td></tr></tbody></table></div>
      <div class="line_under" style=""> <table style="border: solid 1px #000;width:100%;"><tbody><tr>
      <td width="12%" style="background-color: #d9fbfa;border: 1px solid #000; ">09</td><td align="center" id="9"><?php echo isset($features[8]['value'])?$features[8]['value']:"-"; ?></td></tr></tbody></table></div>
      <div class="line_under" style=""> <table style="border: solid 1px #000;width:100%;"><tbody><tr><td width="12%" style="background-color: #d9fbfa;border: 1px solid #000; ">10</td><td align="center" id="10"><?php echo isset($features[9]['value'])?$features[9]['value']:"-"; ?></td></tr></tbody></table></div>
      </span>
</td>
</tr>
</table>
    </div>
    
      <div class="picas3" style="width:100%;" >
     
          <table style="border: solid 1px #000;">
              <tr>
                  <td>
        <div class="lefti" >
        <img src="<?= \yii\helpers\Url::to('@web/uploads/driver.jpg', true) ?>" width="350px" height="141"></div>
</td>
<td>
        <div class="lefti" ><img src="<?= \yii\helpers\Url::to('@web/uploads/Passenger.jpg', true) ?>" width="350px" height="141"></div>
</td>
</tr>
<tr>
    <td>
        
<div id="yoba"> 
   		  <table width="100%" style="border: solid 1px #000;width:100%;">
            <tbody>
                <tr style="border: solid 1px #000;width:100%;">
            <td width="6%" style="background-color: #d9fbfa;border: 1px solid #000; ">11</td><td class="line_right" align="center" width="28%"><?php echo isset($features[10]['value'])?$features[10]['value']:"-"; ?></td>
            <td width="6%" style="background-color: #d9fbfa;border: 1px solid #000; ">12</td><td class="line_right" align="center" width="27%"><?php echo isset($features[11]['value'])?$features[11]['value']:"-"; ?></td>
            <td width="6%" style="background-color: #d9fbfa;border: 1px solid #000; ">13</td><td align="center" width="27%"><?php echo isset($features[12]['value'])?$features[12]['value']:"-"; ?></td>
            </tr>
          </tbody></table>
      </div>
</td>
<td>
        <div id="yoba"> 
   		  <table width="100%" style="border: solid 1px #000;width:100%;">
            <tbody>
                <tr>
            <td width="6%" style="background-color: #d9fbfa;border: 1px solid #000;">17</td><td align="center" class="line_right" width="28%"><?php echo isset($features[16]['value'])?$features[16]['value']:"-"; ?></td>
            <td width="6%" style="background-color: #d9fbfa;border: 1px solid #000;">18</td><td align="center" class="line_right" width="27%"><?php echo isset($features[17]['value'])?$features[17]['value']:"-"; ?></td>
            <td width="6%" style="background-color: #d9fbfa;border: 1px solid #000;">19</td><td align="center" width="27%"><?php echo isset($features[18]['value'])?$features[18]['value']:"-"; ?></td>
            </tr>
          </tbody></table>
      </div>
</td>
</tr>
      <tr>
          <td>
      <div id="yoba" >
      <table width="100%" style="border: solid 1px #000;width:100%;">
      <tbody><tr>
      <td width="6%" style="background-color: #d9fbfa;border: 1px solid #000;">14</td><td align="center" class="line_right" width="28%"><?php echo isset($features[13]['value'])?$features[13]['value']:"-"; ?></td>
      <td width="6%" style="background-color: #d9fbfa;border: 1px solid #000;">15</td><td align="center" class="line_right" width="27%"><?php echo isset($features[14]['value'])?$features[14]['value']:"-"; ?></td>
      <td width="6%" style="background-color: #d9fbfa;border: 1px solid #000;">16</td><td align="center" width="27%"><?php echo isset($features[15]['value'])?$features[15]['value']:"-"; ?></td>
      </tr>
      </tbody></table>
      </div>
</td>
<td>
      <div id="yoba">
      <table width="100%" style="border: solid 1px #000;width:100%;">
      <tbody><tr>
      <td width="6%" style="background-color: #d9fbfa;border: 1px solid #000;">20</td><td align="center" class="line_right" width="28%"><?php echo isset($features[19]['value'])?$features[19]['value']:"-"; ?></td>
      <td width="6%" style="background-color: #d9fbfa;border: 1px solid #000;">21</td><td align="center" class="line_right" width="27%"><?php echo isset($features[20]['value'])?$features[20]['value']:"-"; ?></td>
      <td width="6%" style="">&nbsp;</td><td width="27%"></td>
      </tr>
      </tbody></table>
      </div>
<td>
</tr>
</table>
</td>
  </div>
   	  <div class="papugay">
        <table width="100%" style="border: 1px solid #000;">
        <tbody><tr><td style="font-size: 12px;"><b>1.</b> Liability-Shipper (customer) must have door-to-door insurance while goods are in warehouse and during transit. Ariana Worldwide will not
assume any responsibility for uninsured or underinsured shipment(s)..</td></tr>

		<tr><td style="font-size: 12px;"><b>2.</b> Rates for individual cars are based on consolidation; company is not responsible for exact shipping dates. Company is not responsible for delays
in shipping schedules and/or transit time or custom charges and delays..</td></tr>
        </tbody></table>
        
        </div>
        
      <div class="dimen"><table width="100%" style="">
      <tbody><tr>
      <td style="font-size: 12px;">
      <b>DIMENSIONS: </b>
The above is an accurate representation of the condition of the vehicle at the time of loading. NOTICE: The OWNER'S or AUTHORIZED AGENT'S
Signature of the origin is also to the following RELEASE: this will authorize CARRIER to drive my vehicle either at origin destination between point
(s) of loading/unloading and the point(s) of pick-up/delivery.
      </td>
      </tr>
      </tbody></table>
      
      </div>
    
      <div class="sign"><table width="100%" style="">
      <tbody><tr>
      <td style="font-size: 12px;">
      <b>This above Vehicle has been deliverd in the condition described.</b>
      </td>
      </tr>
      </tbody></table></div>
      <table width="100%" style="">
            <tbody><tr>
            <td width="18%" style="background-color: #d9fbfa;border: 1px solid #000;font-size: 12px;"><b>Completed By</b></td>
            <td width="44%" class="line_under" style="border: 1px solid #000;font-size: 12px;" id="Phone Number"><?= $model->customerUser->company_name;?></td>
            <td width="14%" style="background-color: #d9fbfa;border: 1px solid #000;font-size: 12px;"><b>Date</b></td>
            <td width="24%" class="line_under" style="border: 1px solid #000;font-size: 12px;" id="Weight"><?= $model->towingRequest->deliver_date;?></td>  
            </tr>
        </tbody></table>
      
    </div>
      
      
  </div>




<div class="customer_part">

    <div class="pics">
    <?php $images = $model->images;
    foreach($images as $images){ ?>
<div class="pica" style="width: 50%;float: left;;"><img width="" src="<?= \yii\helpers\Url::to('@web/uploads/'.$images->name, true);?>"></div>
<?php
    }
    ?>
     
      

     </div>
  
</div>

</div>



