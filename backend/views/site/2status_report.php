<table class="ia table table-striped table-bordered" width="100%">
        <tbody><tr>
        <td width="20%" align="center" id="pipi">
        <b>Inventory</b></td>
        <?php if(isset($company_name->company_name)) { ?>
        <td width="35%"><b><?php echo $company_name->company_name; ?></b></td>
        <?php  } ?>
        <td width="12%" align="right"><b>Sort Type:</b></td>
        <td width="15%"><?= $status; ?></td>
        <?php 
          if($location){
            $locationName = \common\models\Lookup::$location[$location];
        }else{
            $locationName = 'ALL';
            
        }
        ?>
        <td width="12%" align="right"><b>Location:</b></td>
        <td width="15%"><?= $locationName; ?></td>
        <td width="27%" align="center"><?php
       
        // $models['created_at'];?></td>
        </tr>
</tbody></table>
<table width="100%" class="ia table table-striped table-bordered" style="border-collapse: collapse;" >
      <tbody><tr> 
      <th style="">HAT NO</th>
      <th style="">DATE RECEIVED</th>
      <th style="">YEAR</th>
      <th style="">MAKE</th>
      <th style="">MODEL</th>
      <th style="">COLOR</th>
      <th style="">VIN</th>
      <th style="">TITLE</th>
      <th style="">TYPE</th>
      <th style="">KEYS</th>
      <th style="">AGE</th>
      <th>LOT NO</th>
      <th style="">STATUS</th>
      <th style="">NOTE</th>
</tr>
<?php foreach($model as $models){
    if($models['status']==3){
        //continue;
    }
        if($models['title_type']){
            $title_type = \common\models\Lookup::$title_type[$models['title_type']];
        }else{
            $title_type   = 'NO TITLE';
        }
    //$keys =  \common\models\Lookup::$yes_no[$models['keys']];
        $status_car =  isset(\common\models\Lookup::$status_picked[$models['status']])?\common\models\Lookup::$status_picked[$models['status']]:'EMPTY';
      ?>

<tr>
<td align="center" style="border: 1px solid #000;"><?php echo $models['hat_number']?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $models['status']!=3?$models['deliver_date']:$models['towing_request_date']; ?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $models['year'];?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $models['make'];?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $models['model'];?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $models['color'];?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $models['vin'];?></td>
<td align="center" style="border: 1px solid #000;"><?php echo isset(\common\models\Lookup::$yes_no[$models['title_recieved']])?\common\models\Lookup::$yes_no[$models['title_recieved']]:$models['title_recieved'];?></td>

<td align="center" style="border: 1px solid #000;"><?php echo $title_type  ;?></td>
<td align="center" style="border: 1px solid #000;"></td>

<td align="center" style="border: 1px solid #000;"><?php echo $models['agedays'];?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $models['lot_number'];?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $status_car;?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $models['note'];?></td>
</tr>
<?php }?>
</tbody>
</table>
