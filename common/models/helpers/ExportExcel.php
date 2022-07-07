<?php 
namespace common\models\helpers;
use Yii;
class ExportExcel extends \yii\base\Model {
    public $total_photos;
    public $loading_date;
    public $export_date;
    public $eta;
    public $status;
    public $booking_number;
    public $container_number;
    public $ar_number;
    public $created_at;
    public $port_of_loading;
    public $port_of_discharge;
    public $customer_name;
    public $legacy_customer_id;
    public $terminal;
    public $vessel;
    public $container_type;
}
?>