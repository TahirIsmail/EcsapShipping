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
          <th>Tow Date</th>
          <th>Date Received</th>
          <th>Year</th>
          <th>Make</th>
          <th>Model</th>
          <th>VIN</th>
          <th>Keys</th>
          <th>Lot No</th>
          <th>Container No</th>
          <th>ETA</th>
          <th>Note</th>
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

    $keys = isset(\common\models\Lookup::$yes_no[$models['keys']]) ? \common\models\Lookup::$yes_no[$models['keys']] : 'NO';
    $status_car =  isset(\common\models\Lookup::$status_picked[$models['status']])?\common\models\Lookup::$status_picked[$models['status']]:'EMPTY';
  ?>

<tr>
<td align="center" style="border: 1px solid #000;"><?php echo $models['towing_request_date']?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $models['status']!=3?$models['deliver_date']:$models['towing_request_date']; ?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $models['year'];?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $models['make'];?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $models['model'];?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $models['vin'];?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $keys; ?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $models['lot_number'];?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $models['container_number'];?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $models['eta'];?></td>
<td align="center" style="border: 1px solid #000;"><?php echo $models['note'];?></td>
</tr>
<?php }?>
</tbody>
</table>
