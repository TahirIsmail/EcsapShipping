<?php

use yii\grid\GridView;
use yii\helpers\Html;
use \common\models\Lookup;

if (empty($data)) {
    echo "No-Record";
    exit();
}
?>
<?php
if ($location) {
    $locationName = Lookup::$location[$location];
} else {
    $locationName = 'ALL';
}
?>

<?php
$data_html = [];
$customers = [];
$th = "<tr>
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
</tr>";
for ($i = 0; $i < sizeof($data); $i++) {
    $title = $data[$i]['title_recieved'] ? 'YES' : 'NO';
    $keys = isset(\common\models\Lookup::$yes_no[$data[$i]['keys']]) ? \common\models\Lookup::$yes_no[$data[$i]['keys']] : 'NO';
//    if (isset($customers[$data[$i]['customer_user_id']]['data'][$data[$i]['status']])) {
        $customers[$data[$i]['customer_user_id']]['heading'] = $data[$i]['company_name'] . "<br/>CUSTOMER:" . $data[$i]['customer_name'] . " <br/>CUSTOMER ID:" . $data[$i]['legacy_customer_id'];
        $customers[$data[$i]['customer_user_id']]['data'][$data[$i]['status']] .= "<tr><td>" . $data[$i]['towing_request_date'] . "</td><td>" . $data[$i]['deliver_date'] . "</td><td>" . $data[$i]['year'] . "</td><td>" . $data[$i]['make'] . "</td><td>" . $data[$i]['model'] . "</td><td>" . $data[$i]['vin'] . "</td><td>" . $keys . "</td><td>" . $data[$i]['lot_number'] . "</td><td>" . $data[$i]['container_number'] . "</td><td>" . $data[$i]['eta'] . "</td><td>". $data[$i]['note'] . "</td></tr>";
//    } else {
//        $customers[$data[$i]['customer_user_id']]['heading'] = $data[$i]['company_name'] . "<br/>CUSTOMER:" . $data[$i]['customer_name'] . " <br/>CUSTOMER ID:" . $data[$i]['legacy_customer_id'];
//        $customers[$data[$i]['customer_user_id']]['data'][$data[$i]['status']] = "<tr><td>" . $data[$i]['towing_request_date'] . "</td><td>" . $data[$i]['deliver_date'] . "</td><td>" . $data[$i]['year'] . "</td><td>" . $data[$i]['make'] . "</td><td>" . $data[$i]['model'] . "</td><td>" . $data[$i]['vin'] . "</td><td>" . $keys . "</td><td>" . $data[$i]['lot_number'] . "</td><td>" . $data[$i]['container_number'] . "</td><td>" . $data[$i]['eta'] . "</td><td>" . $data[$i]['note'] . "</td></tr>";
//    }
}
$count = 0;
foreach ($customers as $c) {
    echo $count == 0 ? "" : "<pagebreak />";
    $count = 2;
    if (isset($c['data'][4])) {
        echo "<b>";
        echo $c['heading'];
        echo "</b>";
        echo "<b> Location:</b><span>" . $locationName . "</span>";
        echo "<b> Status:</b><span> Shipped</span>";
        echo "<table class='table' border=1>";
        echo $th;
        echo $c['data'][4];
        echo "</table>";
    }

}
//echo "<br/>"."<span>".count($customers).":".$i."</span>";
?>