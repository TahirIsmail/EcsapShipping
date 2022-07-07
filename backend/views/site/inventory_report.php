<?php
use yii\grid\GridView;
use yii\helpers\Html;
use \common\models\Lookup;
if(empty($data)){
    echo "No-Record";
    exit();
}
?>
<?php 
if($location){
    $locationName = Lookup::$location[$location];
}else{
    $locationName = 'ALL';
}
?>

<?php
    $data_html = [];
    $customers = [];
    $th = "<tr><th>HAT NO</th><th>DATE RECEIVED</th><th>YEAR</th><th>MAKE</th><th>MODEL</th><th>COLOR</th><th>VIN</th><th>TITLE</th><th>TYPE</th><th>KEYS</th><th>AGE</th><th>LOT NO</th><th>NOTE</th></tr>";
    $th_on_the_way = "<tr><th>TOWING REQ</th><th>YEAR</th><th>MAKE</th><th>MODEL</th><th>COLOR</th><th>VIN</th><th>TITLE</th><th>TYPE</th><th>KEYS</th><th>AGE (SINCE TOW REQ)</th><th>LOT NO</th><th>NOTE</th></tr>";
    for($i=0;$i<sizeof($data);$i++){
        $title = $data[$i]['title_recieved'] ? 'YES' : 'NO';
        if(isset($customers[$data[$i]['customer_user_id']]['data'][$data[$i]['status']])){
            $customers[$data[$i]['customer_user_id']]['heading'] = $data[$i]['company_name']."<br/>CUSTOMER:".$data[$i]['customer_name']." <br/>CUSTOMER ID:".$data[$i]['legacy_customer_id'];
            $customers[$data[$i]['customer_user_id']]['heading_on_the_way'] = $data[$i]['company_name']."<br/>CUSTOMER:".$data[$i]['customer_name']." <br/>CUSTOMER ID:".$data[$i]['legacy_customer_id'];
            if($data[$i]['status']==1){
                $customers[$data[$i]['customer_user_id']]['data'][$data[$i]['status']] .= "<tr><td>".$data[$i]['hat_number']."</td><td>".$data[$i]['deliver_date']."</td><td>".$data[$i]['year']."</td><td>".$data[$i]['make']."</td><td>".$data[$i]['model']."</td><td>".$data[$i]['color']."</td><td>".$data[$i]['vin']."</td><td>".$data[$i]['title_recieved'] ? 'YES' : 'NO'."</td><td>".Lookup::$title_type[$data[$i]['title_type']]."</td><td>".Lookup::$yes_no[$data[$i]['keys']]."</td><td>".$data[$i]['agedays']."</td><td>".$data[$i]['lot_number']."</td><td>".$data[$i]['note']."</td></tr>";
            }else{
                $customers[$data[$i]['customer_user_id']]['data'][$data[$i]['status']] .= "<tr><td>".$data[$i]['towing_request_date']."</td><td>".$data[$i]['year']."</td><td>".$data[$i]['make']."</td><td>".$data[$i]['model']."</td><td>".$data[$i]['color']."</td><td>".$data[$i]['vin']."</td><td>".$data[$i]['title_recieved'] ? 'YES' : 'NO'."</td><td>".Lookup::$title_type[$data[$i]['title_type']]."</td><td>".Lookup::$yes_no[$data[$i]['keys']]."</td><td>".$data[$i]['reqdays']."</td><td>".$data[$i]['lot_number']."</td><td>".$data[$i]['note']."</td></tr>";
            }

        }else{
            $customers[$data[$i]['customer_user_id']]['heading'] = $data[$i]['company_name']."<br/>CUSTOMER:".$data[$i]['customer_name']." <br/>CUSTOMER ID:".$data[$i]['legacy_customer_id'];
            $customers[$data[$i]['customer_user_id']]['heading_on_the_way'] = $data[$i]['company_name']."<br/>CUSTOMER:".$data[$i]['customer_name']." <br/>CUSTOMER ID:".$data[$i]['legacy_customer_id'];
            if($data[$i]['status']==1){
                $customers[$data[$i]['customer_user_id']]['data'][$data[$i]['status']] = "<tr><td>".$data[$i]['hat_number']."</td><td>".$data[$i]['deliver_date']."</td><td>".$data[$i]['year']."</td><td>".$data[$i]['make']."</td><td>".$data[$i]['model']."</td><td>".$data[$i]['color']."</td><td>".$data[$i]['vin']."</td><td>".$data[$i]['title_recieved'] ? 'YES' : 'NO'."</td><td>".Lookup::$title_type[$data[$i]['title_type']]."</td><td>".Lookup::$yes_no[$data[$i]['keys']]."</td><td>".$data[$i]['agedays']."</td><td>".$data[$i]['lot_number']."</td><td>".$data[$i]['note']."</td></tr>";
            }else{
                $customers[$data[$i]['customer_user_id']]['data'][$data[$i]['status']] = "<tr><td>".$data[$i]['towing_request_date']."</td><td>".$data[$i]['year']."</td><td>".$data[$i]['make']."</td><td>".$data[$i]['model']."</td><td>".$data[$i]['color']."</td><td>".$data[$i]['vin']."</td><td>". $title ."</td><td>".Lookup::$title_type[$data[$i]['title_type']]."</td><td>".Lookup::$yes_no[$data[$i]['keys']]."</td><td>".$data[$i]['reqdays']."</td><td>".$data[$i]['lot_number']."</td><td>".$data[$i]['note']."</td></tr>";
            }
        }
    }
    $count = 0;
    foreach($customers as $c){
        echo $count==0? "":"<pagebreak />";
        $count=2;
        if(isset($c['data'][1])){
            echo "<b>";
            echo $c['heading'];
            echo "</b>";
            echo "<b> Location:</b><span>".$locationName."</span>";
            echo "<b> Status:</b><span> On Hand</span>";
            echo "<table class='table' border=1>";
            echo $th;
            echo $c['data'][1];
            echo "</table>";
        }
        if(isset($c['data'][3])){
            echo "<b>";
            echo $c['heading_on_the_way'];
            echo "</b>";
            echo "<b> Location:</b><span>".$locationName."</span>";
            echo "<b> Status:</b><span> On The Way</span>";
            echo "<table class='table' border=1>";
            echo $th_on_the_way;
            echo $c['data'][3];
            echo "</table>";
        }
        if(isset($c['data'][2])){
            echo "<b>";
            echo $c['heading_on_the_way'];
            echo "</b>";
            echo "<b> Location:</b><span>".$locationName."</span>";
            echo "<b> Status:</b><span> Manifest</span>";
            echo "<table class='table' border=1>";
            echo $th_on_the_way;
            echo $c['data'][2];
            echo "</table>";
        }

    }
    //echo "<br/>"."<span>".count($customers).":".$i."</span>";
?>