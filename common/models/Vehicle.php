<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use yii\db\Query;
use Yii;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * This is the model class for table "vehicle".
 *
 * @property int $id
 * @property string $hat_number
 * @property string $year
 * @property string $color
 * @property string $modelget_vehicle_report
 * @property string $make
 * @property string $keyNote
 * @property string $vin
 * @property string $weight
 * @property string $value
 * @property string $license_number
 * @property string $towed_from
 * @property string $lot_number
 * @property float $towed_amount
 * @property float $storage_amount
 * @property int $check_number
 * @property float $additional_charges
 * @property string $location
 * @property int $customer_user_id
 * @property int $towing_request_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property bool $is_deleted
 * @property Export[] $exports
 * @property Images[] $images
 * @property Customer $customerUser
 * @property TowingRequest $towingRequest
 * @property VehicleCondition[] $vehicleConditions
 * @property VehicleFeatures[] $vehicleFeatures
 * @property VehicleInput[] $vehicleInputs
 */
class Vehicle extends \yii\db\ActiveRecord
{
    public $request_dat;
    public $text;
    public $imageFile;
    public $imageurl;
    public $name;
    public $title_recieved;
    public $key_note;
    public $title_type;
    public $manifest_date;
    public $received_date;
    public $total_photos;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle';
    }

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::className(),
                'softDeleteAttributeValues' => [
                    'vehicle_is_deleted' => true,
                ],
                'replaceRegularDelete' => true,
            ],
        ];
    }

    public static function find()
    {
        return new VehicleQuery(get_called_class());
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
            $this->added_by_role = \common\models\Lookup::roleNameFromRole($roles);
            if (isset($this->vin[0])) {
                if ($this->vin[0] === 'I') {
                    if (strlen($this->vin) > 17) {
                        $this->vin = substr($this->vin, 1);
                    }
                }
            }

            return true;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['vin', 'required', 'message' => 'Please enter the vin.'],
            // ['lot_number', 'required', 'message' => 'Please enter lot number.'],
            //['license_number', 'required', 'message' => 'Please enter buyer number.'],
            // ['towed_from', 'required','when' => function($att) {
            ////  return $towing->towed == 1;
            // }, 'whenClient' => "function (attribute, value) {
            //     return $('#towed').val() == '1';
            // }",
            // 'message' => 'Please enter towed from.'],
            //  ['vehicle_type', 'required', 'message' => 'Please select vehicle type.'],
            //  ['year', 'required', 'message' => 'Please select vehicle year.'],
            //  ['make', 'required', 'message' => 'Please select vehicle make.'],
            //  ['model', 'required', 'message' => 'Please select vehicle model.'],
            ['vin', 'unique', 'message' => 'VIN Should be unique'],
            //['vin','validateVin'],
            ['lot_number', 'unique', 'message' => 'Lot Number Should be unique'],
            [['towed_amount', 'storage_amount', 'additional_charges', 'title_amount'], 'number'],
            [['customer_user_id', 'towing_request_id', 'created_by', 'updated_by'], 'integer'],
            [['customer_user_id', 'location'], 'required'],
            [['check_number', 'created_at', 'updated_at', 'pieces', 'status', 'request_dat', 'title_amount', 'keys', 'notes_status', 'text', 'imageFile', 'imageurl', 'added_by_role', 'title_recieved;'], 'safe'],
            [['vehicle_is_deleted', 'is_export'], 'boolean'],
            [['hat_number', 'year', 'color', 'model', 'make', 'vin', 'weight', 'value', 'license_number', 'towed_from', 'lot_number', 'location'], 'string', 'max' => 45],
            [['key_note'], 'string', 'max' => 250],
            // [['preparedby'], 'string', 'max' => 256],
            // [['lot_number'], 'string', 'min' => 8],
            [['customer_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_user_id' => 'user_id']],
            [['towing_request_id'], 'exist', 'skipOnError' => true, 'targetClass' => TowingRequest::className(), 'targetAttribute' => ['towing_request_id' => 'id']],
        ];
    }

    public function validateVin($attribute, $params)
    {
        $this->addError('vin', 'Vin already used');
    }

    public function TypeAheads()
    {
        $return = \Yii::$app->getDb()->createCommand('select ')->queryAll();
    }

    public function getUniqueColors()
    {
        $colors = [];

        //$return= \common\models\Vehicle::find()->select('color')->groupBy('color')->asArray()->all();
        $return = \Yii::$app->getDb()->createCommand('select color from vehicle group by color')->queryAll();
        foreach ($return as $color) {
            $colors[] = $color['color'];
        }
        if ($colors) {
            return $colors;
        } else {
            return ['WHITE'];
        }
    }

    public function afterSave($insert, $changeAttributes)
    {
        try {
            $user = \common\models\User::findOne(['id' => Yii::$app->user->id]);
            if ($insert) {
                $message = $user->username . ' has add vehicle with VIN ' . $this->vin;
                \Yii::$app->getDb()->createCommand('INSERT INTO `audit` (`user_id`, `datetime`, `logs`) VALUES (' . Yii::$app->user->id . ", CURRENT_TIMESTAMP, '$message');")->query();
            } else {
                $message = $user->username . ' has changed vehicle (' . $this->vin . ') ' . json_encode($changeAttributes);
                \Yii::$app->getDb()->createCommand('INSERT INTO `audit` (`user_id`, `datetime`, `logs`) VALUES (' . Yii::$app->user->id . ", CURRENT_TIMESTAMP, '$message');")->query();
            }
        } catch (\Exception $e) {
        }
    }

    public function getUniqueModel()
    {
        $model = [];

        //$return= \common\models\Vehicle::find()->select('model')->groupBy('model')->asArray()->all();
        $return = \Yii::$app->getDb()->createCommand('select model from vehicle group by model')->queryAll();
        foreach ($return as $m) {
            $model[] = $m['model'];
        }
        if ($model) {
            return $model;
        } else {
            return ['CAMRY'];
        }
    }

    public function getUniqueMake()
    {
        $make = [];

        //$return= \common\models\Vehicle::find()->select('make')->groupBy('make')->asArray()->all();
        $return = \Yii::$app->getDb()->createCommand('select make from vehicle group by make')->queryAll();
        foreach ($return as $m) {
            $make[] = $m['make'];
        }
        if ($make) {
            return $make;
        } else {
            return ['MERCEDES-BENZ'];
        }
    }

    public static function htmlVehicleTitles($i, &$model_vehicle, &$company_name, &$status, &$location, $pagebreak)
    {
        if ($i > -1) {
            $model_vehicle .= '</tbody></table><hr/>';
        }
        if ($pagebreak) {
            $model_vehicle .= '<pagebreak />';
        }
        $model_vehicle .= '
                <table class="ia table table-striped table-bordered" width=100%>
                <tbody>
                    <tr>
                        <th width=20% align=center id=pipi><b>Inventory</b></td>
                        <th><b>' . $company_name . '</b></td>
                        <th width=12% align=right><b>Sort Type:</b></td>
                        <th width=15%>' . $status . '</td>
                        <th width=15% align=center>
                            <b>Location
                            <b>
                        </th>
                        <th width=15%>' . $location . '</td>
                    </tr>
                </tbody>
                </table>';

        if(strtolower($status) == 'shipped') {
            $model_vehicle .= '<table width=100% class="ia table table-striped table-bordered" border=1 style="border:solid 1px;">
                <tbody>
                    <tr>
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
                    </tr>';
        } else {
            $model_vehicle .= '<table width=100% class="ia table table-striped table-bordered" border=1 style="border:solid 1px;">
                <tbody>
                    <tr>
                        <th>HAT NO</th>
                        <th>DATE RECEIVED</th>
                        <th>YEAR</th>
                        <th>MAKE</th>
                        <th>MODEL</th>
                        <th>COLOR</th>
                        <th>VIN</th>
                        <th>TITLE</th>
                        <th>TITLE TYPE</th>
                        <th>KEYS</th>
                        <th>AGE</th>
                        <th>STATUS</th>
                        <th>NOTE</th>
                    </tr>';
        }

        return $model_vehicle;
    }

    public static function report_inventory($id = null, $location = null, $status = null, $user = null, $include = null, $locationName = null)
    {
        $model_query = (new Query())
            ->select(['vehicle.status,vehicle.customer_user_id,Datediff(now(), towing_request.deliver_date) as agedays,vehicle.created_at,vehicle.hat_number,vehicle.year,vehicle.make,vehicle.model,vehicle.color,vehicle.vin,vehicle.towed_amount,towing_request.title_recieved_date,towing_request.title_recieved,towing_request.note,towing_request.deliver_date,towing_request.title_type,vehicle.keys', 'customer.company_name'])
            ->from('vehicle')
            ->innerJoin('towing_request', 'towing_request.id = vehicle.towing_request_id')
            ->innerJoin('customer', 'customer.user_id = vehicle.customer_user_id')
            ->where(['!=', 'vehicle_is_deleted', 1]);
        $user_id = Yii::$app->user->getId();
        $Role = Yii::$app->authManager->getRolesByUser($user_id);
        if (isset($Role['customer'])) {
            $model_query->andWhere(['=', 'vehicle.customer_user_id', $user_id]);
        }
        $l = 'All';
        if (Yii::$app->user->can('admin_LA') && !Yii::$app->user->can('super_admin')) {
            $model_query->andWhere(['=', 'vehicle.location', 1]);
            $l = 'LA';
        }
        if (Yii::$app->user->can('admin_GA') && !Yii::$app->user->can('super_admin')) {
            $model_query->andWhere(['=', 'vehicle.location', 2]);
            $l = 'GA';
        }
        if (Yii::$app->user->can('admin_NY') && !Yii::$app->user->can('super_admin')) {
            $model_query->andWhere(['=', 'vehicle.location', 3]);
            $l = 'NY';
        }
        if (Yii::$app->user->can('admin_TX') && !Yii::$app->user->can('super_admin')) {
            $model_query->andWhere(['=', 'vehicle.location', 4]);
            $l = 'TX';
        }
        if (Yii::$app->user->can('admin_TX2') && !Yii::$app->user->can('super_admin')) {
            $model_query->andWhere(['=', 'vehicle.location', 5]);
            $l = 'TX2';
        }
        if (Yii::$app->user->can('admin_NJ2') && !Yii::$app->user->can('super_admin')) {
            $model_query->andWhere(['=', 'vehicle.location', 6]);
            $l = 'NJ2';
        }
        if (Yii::$app->user->can('admin_CA') && !Yii::$app->user->can('super_admin')) {
            $model_query->andWhere(['=', 'vehicle.location', 7]);
            $l = 'CA';
        }
        if ($user) {
            $model_query->andWhere(['=', 'vehicle.customer_user_id', $user]);
        }
        if ($location) {
            $model_query->andWhere(['=', 'vehicle.location', $location]);
        }
        $ids = [];
        if ($include) {
            $ids[] = 3;
        }
        if ($id) {
            $ids[] = $id;
        }
        if ($ids) {
            $model_query->andWhere(['in', 'vehicle.status', $ids]);
        }
        $model_query->orderBy('customer.company_name');
        $on_hand_vehicles = $model_query->all();
        $model_vehicle = '';
        $customer_html_on_hand = '';
        $customer_html_on_the_way = '';
        $company = '';
        if ($locationName) {
            $l = $locationName;
        }
        if ($on_hand_vehicles) {
            $company = $on_hand_vehicles[0] ? $on_hand_vehicles[0]['customer_user_id'] : '';
            $company_name = $on_hand_vehicles[0] ? $on_hand_vehicles[0]['company_name'] : '';
            $location = isset(\common\models\Lookup::$location[$location]) ? \common\models\Lookup::$location[$location] : 'ALL';
            $model_vehicle = self::htmlVehicleTitles('-1', $model_vehicle, $company_name, $status, $l, false);

            foreach ($on_hand_vehicles as $key => $on_hand_vehicle) {
                $status = \common\models\Lookup::$status_picked[$on_hand_vehicle['status']];
                if ($company != $on_hand_vehicle['customer_user_id']) {
                    $model_vehicle = self::htmlVehicleTitles($key, $model_vehicle, $on_hand_vehicle['company_name'], $status, $l, true);
                    $company = $on_hand_vehicle['customer_user_id'];
                }

                if ($on_hand_vehicle['title_recieved']) {
                    $title = 'YES';
                } else {
                    $title = 'NO';
                }

                if ($on_hand_vehicle['keys'] == 1) {
                    $keys = 'YES';
                } else {
                    $keys = 'NO';
                }
                //$title = \common\models\Lookup::$yes_no[$on_hand_vehicle['title_recieved']];
                // $keys = \common\models\Lookup::$yes_no[$on_hand_vehicle['keys']];
                if ($on_hand_vehicle['agedays']) {
                    $days = $on_hand_vehicle['agedays'];
                } else {
                    $days = '0';
                }
                if (isset($on_hand_vehicle['title_type'])) {
                    $title_type = \common\models\Lookup::$title_type[$on_hand_vehicle['title_type']];
                } else {
                    $title_type = 'NO-TITLE';
                }

                $model_vehicle .=
                    '<tr align=center><td>' . $on_hand_vehicle['hat_number'] . '</td>
                    <td>' . $on_hand_vehicle['title_recieved_date'] . '</td>
                    <td>' . $on_hand_vehicle['year'] . '</td>
                    <td>' . $on_hand_vehicle['make'] . '</td>
                    <td>' . $on_hand_vehicle['model'] . '</td>
                    <td>' . $on_hand_vehicle['color'] . '</td>
                    <td>' . $on_hand_vehicle['vin'] . '</td>
                    <td>' . $title . '</td>
                    <td>' . $title_type . '</td>
                    <td>' . $keys . '</td>
                    <td>' . $days . '</td>
                    <td>' . \common\models\Lookup::$status_picked[$on_hand_vehicle['status']] . '</td>
                    <td>' . $on_hand_vehicle['note'] . '</td>
                    </tr>';
            }
            $model_vehicle .= '</tbody></table>';

            return $model_vehicle;
        } else {
            $model_vehicle .= 'nop';

            return $model_vehicle;
        }
    }

    public static function shippedReport($shipped_vehicle, $status, $locationName, $company = null)
    {
        $model_vehicle = '';
        $companyName = 'All';
        if (!empty($company)) {
            $companyName = $company->company_name;
        }
        if ($shipped_vehicle) {
            $model_vehicle .= '
                <table class="ia table table-striped table-bordered" width=100%>
                <tbody>
                    <tr>
                        <td width=20% align=center id=pipi><b>Inventory</b></td>
                        <td><b>' . $companyName . '</b></td>
                        <td width=12% align=right><b>Sort Type:</b></td>
                        <td width=15%>' . $status . '</td>
                        <td width=15% align=center>
                            <b>Location
                            <b>
                        </td>
                        <td width=15%>' . $locationName . '</td>
                    </tr>
                </tbody>
                </table>
                <table width=100% class="ia table table-striped table-bordered" border=1>';


            $model_vehicle .= self::shippedTableFormat($shipped_vehicle);

            return $model_vehicle;
        } else {
            $model_vehicle .= 'nop';

            return $model_vehicle;
        }
    }

    private static function shippedTableFormat($shipped_vehicle)
    {
        $content = '<tbody>
                    <tr>
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
                    </tr>';
        foreach ($shipped_vehicle as $shippedVehicle) {
            $keys = isset(\common\models\Lookup::$yes_no[$shippedVehicle['keys']]) ? \common\models\Lookup::$yes_no[$shippedVehicle['keys']] : 'NO';
            $date_current = $shippedVehicle['status'] == 3 ? $shippedVehicle['towing_request_date'] : $shippedVehicle['deliver_date'];
            $content .=
                '<tr><td align=center>' . $shippedVehicle['towing_request_date'] . '</td>
                    <td align=center>' . $date_current . '</td>
                    <td align=center>' . $shippedVehicle['year'] . '</td>
                    <td align=center>' . $shippedVehicle['make'] . '</td>
                    <td align=center>' . $shippedVehicle['model'] . '</td>
                    <td align=center>' . $shippedVehicle['vin'] . '</td>
                    <td align=center>' . $keys . '</td>
                    <td align=center>' . $shippedVehicle['lot_number'] . '</td>
                    <td align=center>' . $shippedVehicle['container_number'] . '</td>
                    <td align=center>' . $shippedVehicle['eta'] . '</td>
                    <td align=center>' . $shippedVehicle['note'] . '</td>
                    </tr>';
        }
        $content .= '</tbody></table>';

        return $content;
    }

    public static function report($shipped_vehicle, $status, $locationName)
    {
        $model_vehicle = '';
        if ($shipped_vehicle) {
            $model_vehicle .= '
                <table class="ia table table-striped table-bordered" width=100%>
                <tbody>
                    <tr>
                        <td width=20% align=center id=pipi><b>Inventory</b></td>
                        <td><b>All</b></td>
                        <td width=12% align=right><b>Sort Type:</b></td>
                        <td width=15%>' . $status . '</td>
                        <td width=15% align=center>
                            <b>Location
                            <b>
                        </td>
                        <td width=15%>' . $locationName . '</td>
                    </tr>
                </tbody>
                </table>
                <table width=100% class="ia table table-striped table-bordered" border=1>
                <tbody>
                    <tr>
                        <th>Hat Number</th>
                        <th>Date Received</th>
                        <th>Year</th>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Color</th>
                        <th>VIN</th>
                        <th>Title</th>
                        <th>Title Type</th>
                     
                        <th>Keys</th>
                        <th>Age</th>
                        <th>Note</th>
                    </tr>';
            foreach ($shipped_vehicle as $shipped_vehicle) {
                $title = $shipped_vehicle['title_recieved'] ? 'YES' : 'NO';
                $keys = isset(\common\models\Lookup::$yes_no[$shipped_vehicle['keys']]) ? \common\models\Lookup::$yes_no[$shipped_vehicle['keys']] : 'NO';

                if ($shipped_vehicle['deliver_date']) {
                    $current_date = date('Y-m-d');
                    $datediff = strtotime($current_date) - strtotime($shipped_vehicle['deliver_date']);
                    $days = floor($datediff / (60 * 60 * 24));
                } else {
                    $days = '0';
                }
                if (isset($shipped_vehicle['title_type'])) {
                    $title_type = \common\models\Lookup::$title_type[$shipped_vehicle['title_type']];
                } else {
                    $title_type = 'NO-TITLE';
                }
                $date_current = $shipped_vehicle['status'] == 3 ? $shipped_vehicle['towing_request_date'] : $shipped_vehicle['deliver_date'];
                $model_vehicle .=
                    '<tr><td align=center>' . $shipped_vehicle['hat_number'] . '</td>
                    <td align=center>' . $date_current . '</td>
                    <td align=center>' . $shipped_vehicle['year'] . '</td>
                    <td align=center>' . $shipped_vehicle['make'] . '</td>
                    <td align=center>' . $shipped_vehicle['model'] . '</td>
                    <td align=center>' . $shipped_vehicle['color'] . '</td>
                    <td align=center>' . $shipped_vehicle['vin'] . '</td>
                    <td align=center>' . $title . '</td>
                    <td align=center>' . $title_type . '</td>
                   
                    <td align=center>' . $keys . '</td>
                    <td align=center>' . $days . '</td>
                    <td align=center>' . $shipped_vehicle['note'] . '</td>
                    </tr>';
            }
            $model_vehicle .= '</tbody></table>';

            return $model_vehicle;
        } else {
            $model_vehicle .= 'nop';

            return $model_vehicle;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'total_photos' => 'TOTAL PHOTOS',
            'hat_number' => 'HAT',
            'received_date' => 'RECEIVED DATE',
            'year' => 'YEAR',
            'eta' => 'ETA',
            'color' => 'COLOR',
            // 'vehicle_type' => 'Vehicle Type',
            'model' => 'MODEL',
            'make' => 'MAKE',
            'vin' => 'VIN',
            'weight' => 'WEIGHT',
            'pieces' => 'PIECES',
            'status' => 'STATUS',
            'value' => 'VALUE',
            'license_number' => 'BUYER NO',
            'towed_from' => 'TOWED FROM',
            'lot_number' => 'LOT NO',
            'towed_amount' => 'TOWED AMOUNT',
            'storage_amount' => 'STORAGE AMOUNT',
            'check_number' => 'CHECK NO',
            'additional_charges' => 'ADD. CHGS',
            'location' => 'LOCATION',
            'customer_user_id' => 'CUSTOMER NAME',
            'towing_request_id' => 'TOWING REQUEST ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'text' => 'VEHICLE NOTE',
            'is_export' => 'EXPORTED',
            'keys' => 'KEYS',
            'loc' => 'LOC',
            'age' => 'AGE',
            'key_note' => 'KEY NOTE',
            'title_recieved' => 'TITLE',
            'container_number' => 'CONTAINER NO',
            'bill_of_lading' => 'BILL OF LADING',
            'title_amount' => 'TITLE AMOUNT',
            'tow_req_date' => 'TOW REQ DATE',
            'manifest_date' => 'MANIFEST DATE',
            //  'preparedby' => 'Prepared By',
        ];
    }

    public function extraFields()
    {
        return [
            'images',
            'customerUser',
            'vehicleConditions',
            'vehicleFeatures',
            'towingRequest',
        ];
        parent::extraFields();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExports()
    {
        return $this->hasMany(Export::className(), ['vehicle_id' => 'id']);
    }

    public function getVehicleExport()
    {
        return $this->hasOne(VehicleExport::className(), ['vehicle_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Images::className(), ['vehicle_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerUser()
    {
        return $this->hasOne(Customer::className(), ['user_id' => 'customer_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTowingRequest()
    {
        return $this->hasOne(TowingRequest::className(), ['id' => 'towing_request_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleConditions()
    {
        return $this->hasMany(VehicleCondition::className(), ['vehicle_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleFeatures()
    {
        return $this->hasMany(VehicleFeatures::className(), ['vehicle_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleInputs()
    {
        return $this->hasMany(VehicleInput::className(), ['vehicle_id' => 'id']);
    }

    public static function all_vehicle_report()
    {
        $all_vehicle = array();
        // $all_vehicle['all'] = Vehicle::find()->count();
        $all_vehicle['all'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle['on_hand'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle['manifest'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '2'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle['picked_up'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '5'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle['car_on_way'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '3'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle['shipped'] = (new Query())
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->leftJoin('vehicle_export as ve', 've.vehicle_id = vehicle.id')
            ->leftJoin('export as ex', 'ex.id = ve.export_id')
            ->where(['=', 'vehicle.status', '4'])
            ->where(['!=', 'vehicle_is_deleted', 1])
            ->andWhere('ve.vehicle_export_is_deleted != 1')
            ->andWhere(['>', 'ex.eta', date("Y-m-d")])
            ->count();
        $all_vehicle['on_hand_with_towed'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere(['=', 'towing_request.towed', '0'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle['on_hand_with_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere(['=', 'towing_request.title_recieved', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle['on_hand_with_out_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle['on_hand_with_out_towed'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();

        $all_vehicle['arrived'] = (new Query())
            ->from('vehicle')
            ->innerJoin('towing_request', 'vehicle.towing_request_id = towing_request.id')
            ->leftJoin('vehicle_export as ve', 've.vehicle_id = vehicle.id')
            ->leftJoin('export as ex', 'ex.id = ve.export_id')
            ->where(['=', 'vehicle.status', '4'])
            ->where(['!=', 'vehicle_is_deleted', 1])
            ->andWhere('ve.vehicle_export_is_deleted != 1')
            ->andWhere(['<=', 'ex.eta', date("Y-m-d")])
            ->count();

        $all_vehicle['towed'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'towing_request.towed', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle['not_towed'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.towed is null or towing_request.towed=0')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle['with_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'towing_request.title_recieved', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle['with_out_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle['towed_with_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'towing_request.title_recieved', '1'])
            ->andWhere(['=', 'towing_request.towed', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle['towed_with_out_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['=', 'towing_request.towed', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();

        $all_vehicle['exportable'] = (new Query())
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_recieved = 1')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();

        $all_vehicle['pending'] = (new Query())
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_recieved = 2')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();

        $all_vehicle['bos'] = (new Query())
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_recieved = 3')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();

        $all_vehicle['lien'] = (new Query())
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_recieved = 4')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();

        $all_vehicle['mv907'] = (new Query())
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_recieved = 5')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();

        $all_vehicle['rejected'] = (new Query())
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_recieved = 6')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();

        return $all_vehicle;
    }

    public static function sub_vehicle_location_report_customer($location, $user_id)
    {
        $all_vehicle = array();
        // $all_vehicle['all'] = Vehicle::find()->count();
        $all_vehicle['all'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['in', 'vehicle.location', ['1', '2', '3', '4']])
            ->count();
        $all_vehicle['on_hand'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['in', 'vehicle.location', ['1', '2', '3', '4']])
            ->count();
        $all_vehicle['manifest'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '2'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['in', 'vehicle.location', ['1', '2', '3', '4']])
            ->count();
        $all_vehicle['picked_up'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '5'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['in', 'vehicle.location', ['1', '2', '3', '4']])
            ->count();
        $all_vehicle['car_on_way'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '3'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['in', 'vehicle.location', ['1', '2', '3', '4']])
            ->count();
        $all_vehicle['shipped'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->leftJoin('vehicle_export as ve', 've.vehicle_id = vehicle.id')
            ->leftJoin('export as ex', 'ex.id = ve.export_id')
            ->where(['=', 'vehicle.status', '4'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['in', 'vehicle.location', ['1', '2', '3', '4']])
            ->andWhere('ve.vehicle_export_is_deleted != 1')
            ->andWhere(['>', 'ex.eta', date("Y-m-d")])
            ->count();

$all_vehicle['arrived'] = (new Query())
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->leftJoin('vehicle_export as ve', 've.vehicle_id = vehicle.id')
            ->leftJoin('export as ex', 'ex.id = ve.export_id')

            // ->where(['=', 'vehicle.status', '4'])

            ->where(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['<', 'ex.eta', date("Y-m-d")])
            ->andWhere('ve.vehicle_export_is_deleted != 1')
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->count();



        $all_vehicle['on_hand_with_towed'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere(['=', 'towing_request.towed', '0'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['in', 'vehicle.location', ['1', '2', '3', '4']])
            ->count();
        $all_vehicle['on_hand_with_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere(['=', 'towing_request.title_recieved', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['in', 'vehicle.location', ['1', '2', '3', '4']])
            ->count();
        $all_vehicle['on_hand_with_out_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['in', 'vehicle.location', ['1', '2', '3', '4']])
            ->count();
        $all_vehicle['on_hand_with_out_towed'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['in', 'vehicle.location', ['1', '2', '3', '4']])
            ->count();
        $all_vehicle['towed'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'towing_request.towed', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['in', 'vehicle.location', ['1', '2', '3', '4']])
            ->count();
        $all_vehicle['not_towed'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.towed is null or towing_request.towed=0')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['in', 'vehicle.location', ['1', '2', '3', '4']])
            ->count();
        $all_vehicle['with_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'towing_request.title_recieved', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['in', 'vehicle.location', ['1', '2', '3', '4']])
            ->count();
        $all_vehicle['with_out_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['in', 'vehicle.location', ['1', '2', '3', '4']])
            ->count();
        $all_vehicle['towed_with_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'towing_request.title_recieved', '1'])
            ->andWhere(['=', 'towing_request.towed', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['in', 'vehicle.location', ['1', '2', '3', '4']])
            ->count();
        $all_vehicle['towed_with_out_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['=', 'towing_request.towed', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['in', 'vehicle.location', ['1', '2', '3', '4']])
            ->count();

        return $all_vehicle;
    }


    public static function all_vehicle_report_customer($user_id)
    {
        $all_vehicle = array();
        // $all_vehicle['all'] = Vehicle::find()->count();
        $all_vehicle['all'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->count();
        $all_vehicle['on_hand'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->count();
        $all_vehicle['manifest'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '2'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->count();
        $all_vehicle['picked_up'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '5'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->count();
        $all_vehicle['car_on_way'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '3'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->groupBy('vehicle.id')
            ->count();

        $all_vehicle['shipped'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->leftJoin('vehicle_export as ve', 've.vehicle_id = vehicle.id')
            ->leftJoin('export as ex', 'ex.id = ve.export_id')
            ->where(['=', 'vehicle.status', '4'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere('ve.vehicle_export_is_deleted != 1')
            ->andWhere(['>', 'ex.eta', date("Y-m-d")])
            ->groupBy('vehicle.id')
            ->count();

            $all_vehicle['arrived'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->leftJoin('vehicle_export as ve', 've.vehicle_id = vehicle.id')
            ->leftJoin('export as ex', 'ex.id = ve.export_id')

            // ->where(['=', 'vehicle.status', '4'])

            ->where(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['<', 'ex.eta', date("Y-m-d")])
            ->andWhere('ve.vehicle_export_is_deleted != 1')
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->groupBy('vehicle.id')
            ->count();


        $all_vehicle['on_hand_with_towed'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere(['=', 'towing_request.towed', '0'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->groupBy('vehicle.id')
            ->count();
        $all_vehicle['on_hand_with_title'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere(['=', 'towing_request.title_recieved', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->groupBy('vehicle.id')
            ->count();
        $all_vehicle['on_hand_with_out_title'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->groupBy('vehicle.id')
            ->count();
        $all_vehicle['on_hand_with_out_towed'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->groupBy('vehicle.id')
            ->count();
        $all_vehicle['towed'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'towing_request.towed', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->groupBy('vehicle.id')
            ->count();
        $all_vehicle['not_towed'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.towed is null or towing_request.towed=0')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->groupBy('vehicle.id')
            ->count();
        $all_vehicle['with_title'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'towing_request.title_recieved', '1'])
            ->andWhere(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->groupBy('vehicle.id')
            ->count();
        $all_vehicle['with_out_title'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.status', '1'])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->groupBy('vehicle.id')
            ->count();
        $all_vehicle['towed_with_title'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'towing_request.title_recieved', '1'])
            ->andWhere(['=', 'towing_request.towed', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->groupBy('vehicle.id')
            ->count();
        $all_vehicle['towed_with_out_title'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['=', 'towing_request.towed', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->groupBy('vehicle.id')
            ->count();

        $all_vehicle['exportable'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_type = 1')
            ->andWhere(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->groupBy('vehicle.id')
            ->count();

        $all_vehicle['pending'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_type = 2')
            ->andWhere(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->groupBy('vehicle.id')
            ->count();

        $all_vehicle['bos'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_type = 3')
            ->andWhere(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->groupBy('vehicle.id')
            ->count();

        $all_vehicle['lien'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_type = 4')
            ->andWhere(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->groupBy('vehicle.id')
            ->count();

        $all_vehicle['mv907'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_type = 5')
            ->andWhere(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->groupBy('vehicle.id')
            ->count();

        $all_vehicle['rejected'] = (new Query())
            ->select('vehicle.id')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_type = 6')
            ->andWhere(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->groupBy('vehicle.id')
            ->count();

        return $all_vehicle;
    }

    public static function inventoryReport($id = null, $location = null, $status = null, $user = null, $include = null)
    {
        $model_query = (new Query())
            ->select(['vehicle.customer_user_id,vehicle.status,customer.legacy_customer_id, vehicle.container_number,
        customer.customer_name,customer.company_name,vehicle.lot_number,Datediff(now(),
        towing_request.deliver_date) as agedays,Datediff(now(),
        towing_request.towing_request_date) as reqdays,vehicle.created_at,
        vehicle.hat_number,vehicle.year,vehicle.make,vehicle.model,
        vehicle.color,vehicle.vin,vehicle.towed_amount,
        towing_request.title_recieved_date,towing_request.title_recieved,
        towing_request.note,towing_request.deliver_date,towing_request.title_type,
        vehicle.keys,towing_request.towing_request_date', 'export.eta'])
            ->from('towing_request')
            ->innerJoin('vehicle', 'towing_request.id = vehicle.towing_request_id')
            ->innerJoin('customer', 'customer.user_id = vehicle.customer_user_id')
            ->leftJoin('vehicle_export', 'vehicle_export.vehicle_id = vehicle.id')
            ->leftJoin('export', 'vehicle_export.export_id = export.id')
            ->where(['!=', 'vehicle_is_deleted', 1]);
        $user_id = Yii::$app->user->getId();
        $Role = Yii::$app->authManager->getRolesByUser($user_id);
        if (isset($Role['customer'])) {
            $model_query->andWhere(['=', 'vehicle.customer_user_id', $user_id]);
        }
        if ($user) {
            $model_query->andWhere(['=', 'vehicle.customer_user_id', $user]);
        }
        if ($location) {
            $model_query->andWhere(['=', 'vehicle.location', $location]);
        }
        $ids = [];
        if ($id) {
            $ids[] = $id;
        }
        $include = Yii::$app->request->post('include');
        if (empty($include)) {
            $include = Yii::$app->request->get('include');
        }
        if ($include == 'true' || $include == 1) {
            $ids[] = 3;
        }
        if ($ids) {
            $model_query->andWhere(['in', 'vehicle.status', $ids]);
        }
        $model_query->orderBy('customer.company_name,deliver_date,towing_request_date');

        return $model_query->all();
    }

    public static function vehicleStatusList($id = null, $location = null, $status = null, $user = null)
    {
        $model_query = (new Query())
            ->select(['vehicle.status,customer.legacy_customer_id,customer.customer_name,vehicle.lot_number, vehicle.container_number,
            Datediff(now(), towing_request.deliver_date) as agedays,towing_request.towing_request_date,
            Datediff(now(), towing_request.towing_request_date) as reqdays,
            vehicle.created_at,vehicle.hat_number,vehicle.year,
            vehicle.make,vehicle.model,vehicle.color,vehicle.vin,vehicle.towed_amount,
            towing_request.title_recieved_date,towing_request.title_recieved,towing_request.note,
            towing_request.deliver_date,towing_request.title_type,vehicle.keys', 'export.eta'])
            ->from('towing_request')
            ->innerJoin('vehicle', 'towing_request.id = vehicle.towing_request_id')
            ->leftJoin('vehicle_export', 'vehicle_export.vehicle_id = vehicle.id')
            ->leftJoin('export', 'vehicle_export.export_id = export.id')
            ->innerJoin('customer', 'customer.user_id = vehicle.customer_user_id')
            ->where(['!=', 'vehicle_is_deleted', 1]);
        $user_id = Yii::$app->user->getId();
        $Role = Yii::$app->authManager->getRolesByUser($user_id);
        if (isset($Role['customer'])) {
            $model_query->andWhere(['=', 'vehicle.customer_user_id', $user_id]);
        }
        if ($user) {
            $model_query->andWhere(['=', 'vehicle.customer_user_id', $user]);
        }
        if ($location) {
            $model_query->andWhere(['=', 'vehicle.location', $location]);
        }
        $ids = [];
        if ($id) {
            $ids[] = $id;
        }
        $include = Yii::$app->request->post('include');
        if (empty($include)) {
            $include = Yii::$app->request->get('include');
        }
        if ($include == 'true' || $include == 1) {
            $ids[] = 3;
        }
        if (!empty($ids)) {
//            $model_query->andWhere(['in', 'vehicle.status', $ids]);
            if ($id == '4' && $status == 'Shipped') {
                $model_query->andWhere(['=', 'vehicle.status', 4]);
                $model_query->andWhere(['<', 'export.export_date', date("Y-m-d")])
                    ->andWhere(['>', 'export.eta', date("Y-m-d")]);
            } else {
                if ($id == '6' && $status == 'arrived') {
                    $model_query->andWhere(['=', 'vehicle.status', 4]);
                    $model_query->andWhere(['<=', 'export.eta', date("Y-m-d")]);
                } else {
                    $model_query->andWhere(['in', 'vehicle.status', $ids]);
                }
            }
        }
        
        $model_query->groupBy('vehicle.id');

        $model_query->orderBy('agedays desc');

        return $model_query->all();
    }

    public static function all_vehicle_location_report_customer($location, $user_id)
    {
        $all_vehicle = array();
        // $all_vehicle['all'] = Vehicle::find()->count();
        $all_vehicle['all'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();
        $all_vehicle['on_hand'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();
        $all_vehicle['manifest'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '2'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();
        $all_vehicle['picked_up'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '5'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();
        $all_vehicle['car_on_way'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '3'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();
        $all_vehicle['shipped'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->leftJoin('vehicle_export as ve', 've.vehicle_id = vehicle.id')
            ->leftJoin('export as ex', 'ex.id = ve.export_id')
            ->where(['=', 'vehicle.status', '4'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->andWhere(['>', 'ex.eta', date("Y-m-d")])
            ->andWhere('ve.vehicle_export_is_deleted != 1')
            ->count();

            $all_vehicle['arrived'] = (new Query())
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->leftJoin('vehicle_export as ve', 've.vehicle_id = vehicle.id')
            ->leftJoin('export as ex', 'ex.id = ve.export_id')
            ->where(['=', 'vehicle.status', '4'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['<', 'ex.eta', date("Y-m-d")])
            ->andWhere('ve.vehicle_export_is_deleted != 1')
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();


        $all_vehicle['on_hand_with_towed'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere(['=', 'towing_request.towed', '0'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();

        $all_vehicle['on_hand_with_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere(['=', 'towing_request.title_recieved', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();
        $all_vehicle['on_hand_with_out_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();
        $all_vehicle['on_hand_with_out_towed'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();
        $all_vehicle['towed'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'towing_request.towed', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();
        $all_vehicle['not_towed'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.towed is null or towing_request.towed=0')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();
        $all_vehicle['with_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'towing_request.title_recieved', '1'])
            ->andWhere(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();
        $all_vehicle['with_out_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();
        $all_vehicle['towed_with_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'towing_request.title_recieved', '1'])
            ->andWhere(['=', 'towing_request.towed', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();
        $all_vehicle['towed_with_out_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['=', 'towing_request.towed', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();

        $all_vehicle['exportable'] = (new Query())
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_type = 1')
            ->andWhere(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();

        $all_vehicle['pending'] = (new Query())
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_type = 2')
            ->andWhere(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();

        $all_vehicle['bos'] = (new Query())
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_type = 3')
            ->andWhere(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();

        $all_vehicle['lien'] = (new Query())
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_type = 4')
            ->andWhere(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();

        $all_vehicle['mv907'] = (new Query())
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_type = 5')
            ->andWhere(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();

        $all_vehicle['rejected'] = (new Query())
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_type = 6')
            ->andWhere(['=', 'vehicle.status', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['=', 'vehicle.customer_user_id', $user_id])
            ->andWhere(['=', 'vehicle.location', $location])
            ->count();

        return $all_vehicle;
    }

    public static function all_vehicle_location_report($location)
    {
        $all_vehicle_location = array();
        $all_vehicle_location['all'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->andWhere(['=', 'vehicle.location', $location])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle_location['on_hand'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere(['=', 'vehicle.location', $location])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        /*
        $all_vehicle_location['manifest'] =(new Query())
        //->select('*')
        ->from('towing_request')
        ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
        ->where(['!=', 'vehicle.status', '4'])
        ->andWhere(['=', 'vehicle.is_export', '1'])
        ->andWhere(['=', 'vehicle.location', $location])
        ->andWhere(['!=','vehicle_is_deleted',1])
        ->count();
        */
        $all_vehicle_location['manifest'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '2'])
            ->andWhere(['=', 'vehicle.location', $location])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle_location['picked_up'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '5'])
            ->andWhere(['=', 'vehicle.location', $location])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle_location['car_on_way'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '3'])
            ->andWhere(['=', 'vehicle.location', $location])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle_location['shipped'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->leftJoin('vehicle_export as ve', 've.vehicle_id = vehicle.id')
            ->leftJoin('export as ex', 'ex.id = ve.export_id')
            ->where(['=', 'vehicle.status', '4'])
            ->andWhere(['=', 'vehicle.location', $location])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->andWhere(['>', 'ex.eta', date("Y-m-d")])
            ->andWhere('ve.vehicle_export_is_deleted != 1')
            ->count();
        $all_vehicle_location['on_hand_with_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere(['=', 'vehicle.location', $location])
            ->andWhere(['=', 'towing_request.title_recieved', '1'])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle_location['on_hand_with_out_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere(['=', 'vehicle.location', $location])
            ->andWhere('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle_location['on_hand_with_towed'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'vehicle.status', '1'])
            ->andWhere(['=', 'vehicle.location', $location])
            ->andWhere('towing_request.towed is null or towing_request.towed=0')
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle_location['towed'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'towing_request.towed', '1'])
            ->andWhere(['=', 'vehicle.location', $location])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle_location['not_towed'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.towed is null or towing_request.towed=0')
            ->andWhere(['=', 'vehicle.location', $location])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle_location['with_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'towing_request.title_recieved', '1'])
            ->andWhere(['=', 'vehicle.location', $location])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle_location['with_out_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['=', 'vehicle.location', $location])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle_location['towed_with_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'towing_request.towed', '1'])
            ->andWhere(['=', 'towing_request.title_recieved', '1'])
            ->andWhere(['=', 'vehicle.location', $location])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();
        $all_vehicle_location['towed_with_out_title'] = (new Query())
            //->select('*')
            ->from('towing_request')
            ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
            ->where(['=', 'towing_request.towed', '1'])
            ->andWhere('towing_request.title_recieved is null or towing_request.title_recieved=0')
            ->andWhere(['=', 'vehicle.location', $location])
            ->andWhere(['!=', 'vehicle_is_deleted', 1])
            ->count();

        $all_vehicle_location['arrived'] =

            (new Query())
                ->from('towing_request')
                ->innerJoin('vehicle', 'vehicle.towing_request_id = towing_request.id')
                ->leftJoin('vehicle_export as ve', 've.vehicle_id = vehicle.id')
                ->leftJoin('export as ex', 'ex.id = ve.export_id')
                ->where(['!=', 'vehicle_is_deleted', 1])
                ->andWhere(['<=', 'ex.eta', date("Y-m-d")])
                ->andWhere(['=', 'vehicle.location', $location])
                ->andWhere('ve.vehicle_export_is_deleted != 1')
                ->count();




        return $all_vehicle_location;
    }

    public static function getVin()
    {
        $data = Vehicle::find()->all();
        $value = (count($data) == 0) ? ['' => ''] : \yii\helpers\ArrayHelper::map($data, 'vin', 'vin'); //id = your ID model, name = your caption
        return $value;
    }

    public static function get_vehicle_report($location=null,$user_id=null,$type = 1)
    {
        $all_vehicle = array();
        $all_vehicle["all"]                     = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["on_hand"]                 = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where(array("=", "vehicle.status", "1"))->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["manifest"]                = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where(array("=", "vehicle.status", "2"))->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["picked_up"]               = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where(array("=", "vehicle.status", "5"))->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["car_on_way"]              = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where(array("=", "vehicle.status", "3"))->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["new_purchase"]            = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where(array("=", "vehicle.status", "6"))->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["shipped"]                 = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where(array("=", "vehicle.status", "4"))->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["on_hand_with_towed"]      = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where(array("=", "vehicle.status", "1"))->andWhere(array("=", "towing_request.towed", "0"))->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["on_hand_with_title"]      = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where(array("=", "vehicle.status", "1"))->andWhere(array("=", "towing_request.title_recieved", "1"))->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["on_hand_with_out_title"]  = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where(array("=", "vehicle.status", "1"))->andWhere("towing_request.title_recieved is null or towing_request.title_recieved=0")->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["on_hand_with_out_towed"]  = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where(array("=", "vehicle.status", "1"))->andWhere("towing_request.title_recieved is null or towing_request.title_recieved=0")->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["towed"]                   = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where(array("=", "towing_request.towed", "1"))->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["not_towed"]               = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where("towing_request.towed is null or towing_request.towed=0")->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["with_title"]              = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where(array("=", "towing_request.title_recieved", "1"))->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["with_out_title"]          = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where("towing_request.title_recieved is null or towing_request.title_recieved=0")->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["towed_with_title"]        = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where(array("=", "towing_request.title_recieved", "1"))->andWhere(array("=", "towing_request.towed", "1"))->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["towed_with_out_title"]    = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where("towing_request.title_recieved is null or towing_request.title_recieved=0")->andWhere(array("=", "towing_request.towed", "1"))->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["arrived"]                 = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where(array("=", "vehicle.status", "10"))->andWhere(array("!=", "vehicle_is_deleted", 1));

        $all_vehicle["towed_by_galaxy"]         = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["towed_by_customer"]       = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->andWhere(array("!=", "vehicle_is_deleted", 1));

        $all_vehicle["is_requested"]            = (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where(array("=", "vehicle.status", "11"))->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["all_container"]           = (new \yii\db\Query())->from("export")->where(array('customer_user_id'=>$user_id))->andWhere(array("!=", "export_is_deleted", 1));

        //$all_vehicle['car_on_way_iran'] 		= (new \yii\db\Query())->from("towing_request")->innerJoin("vehicle", "vehicle.towing_request_id = towing_request.id")->where(array("=", "vehicle.status", "3"))->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle['car_on_way_iran'] 		= (new \yii\db\Query())->from("vehicle")->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["cars_arrived_iran"]       = (new \yii\db\Query())->from("vehicle")->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["cars_onway_final_destinations"]       = (new \yii\db\Query())->from("vehicle")->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["cars_arrived_final_destinations"]     = (new \yii\db\Query())->from("vehicle")->andWhere(array("!=", "vehicle_is_deleted", 1));

        $all_vehicle["car_dispatched"]          = (new \yii\db\Query())->from("vehicle")->where(array("=", "vehicle.status", "12"))->andWhere(array("!=", "vehicle_is_deleted", 1));
        $all_vehicle["car_loaded"]              = (new \yii\db\Query())->from("vehicle")->where(array("=", "vehicle.status", "15"))->andWhere(array("!=", "vehicle_is_deleted", 1));

        if($location)
        {
            $all_vehicle["all"]                     = $all_vehicle["all"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["on_hand"]                 = $all_vehicle["on_hand"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["manifest"]                = $all_vehicle["manifest"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["picked_up"]               = $all_vehicle["picked_up"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["car_on_way"]              = $all_vehicle["car_on_way"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["new_purchase"]            = $all_vehicle["new_purchase"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["shipped"]                 = $all_vehicle["shipped"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["on_hand_with_towed"]      = $all_vehicle["on_hand_with_towed"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["on_hand_with_title"]      = $all_vehicle["on_hand_with_title"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["on_hand_with_out_title"]  = $all_vehicle["on_hand_with_out_title"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["on_hand_with_out_towed"]  = $all_vehicle["on_hand_with_out_towed"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["towed"]                   = $all_vehicle["towed"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["not_towed"]               = $all_vehicle["not_towed"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["with_title"]              = $all_vehicle["with_title"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["with_out_title"]          = $all_vehicle["with_out_title"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["towed_with_title"]        = $all_vehicle["towed_with_title"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["towed_with_out_title"]    = $all_vehicle["towed_with_out_title"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["arrived"]                 = $all_vehicle["arrived"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["towed_by_galaxy"]         = $all_vehicle["towed_by_galaxy"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["towed_by_customer"]       = $all_vehicle["towed_by_customer"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["is_requested"]		    = $all_vehicle["is_requested"]->andWhere(array("=", "vehicle.location", $location));

            $all_vehicle["car_dispatched"]		    = $all_vehicle["car_dispatched"]->andWhere(array("=", "vehicle.location", $location));
            $all_vehicle["car_loaded"]		        = $all_vehicle["car_loaded"]->andWhere(array("=", "vehicle.location", $location));

            //$all_vehicle["car_on_way_iran"]  		= $all_vehicle["car_on_way_iran"]->andWhere(array("=", "vehicle.location", $location));
            //$all_vehicle["cars_arrived_iran"]       = $all_vehicle["cars_arrived_iran"]->andWhere(array("=", "vehicle.location", $location));


        }

        if($user_id)
        {
            $all_vehicle["all"]                     = $all_vehicle["all"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["on_hand"]                 = $all_vehicle["on_hand"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["manifest"]                = $all_vehicle["manifest"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["picked_up"]               = $all_vehicle["picked_up"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["car_on_way"]              = $all_vehicle["car_on_way"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["new_purchase"]            = $all_vehicle["new_purchase"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["shipped"]                 = $all_vehicle["shipped"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["on_hand_with_towed"]      = $all_vehicle["on_hand_with_towed"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["on_hand_with_title"]      = $all_vehicle["on_hand_with_title"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["on_hand_with_out_title"]  = $all_vehicle["on_hand_with_out_title"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["on_hand_with_out_towed"]  = $all_vehicle["on_hand_with_out_towed"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["towed"]                   = $all_vehicle["towed"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["not_towed"]               = $all_vehicle["not_towed"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["with_title"]              = $all_vehicle["with_title"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["with_out_title"]          = $all_vehicle["with_out_title"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["towed_with_title"]        = $all_vehicle["towed_with_title"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["towed_with_out_title"]    = $all_vehicle["towed_with_out_title"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["arrived"]                 = $all_vehicle["arrived"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["towed_by_galaxy"]         = $all_vehicle["towed_by_galaxy"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["towed_by_customer"]       = $all_vehicle["towed_by_customer"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["is_requested"]            = $all_vehicle["is_requested"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["car_dispatched"]		    = $all_vehicle["car_dispatched"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            $all_vehicle["car_loaded"]		        = $all_vehicle["car_loaded"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));


            // $all_vehicle["car_on_way_iran"]  		= $all_vehicle["car_on_way_iran"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
            //$all_vehicle["cars_arrived_iran"]       = $all_vehicle["cars_arrived_iran"]->andWhere(array("=", "vehicle.customer_user_id", $user_id));
        }

        $all_vehicle["all"]                     = $all_vehicle["all"]->count();
        $all_vehicle["on_hand"]                 = $all_vehicle["on_hand"]->count();
        $all_vehicle["manifest"]                = $all_vehicle["manifest"]->count();
        $all_vehicle["picked_up"]               = $all_vehicle["picked_up"]->count();
        $all_vehicle["car_on_way"]              = $all_vehicle["car_on_way"]->count();
        $all_vehicle["new_purchase"]            = $all_vehicle["new_purchase"]->count();
        $all_vehicle["shipped"]                 = $all_vehicle["shipped"]->count();
        $all_vehicle["on_hand_with_towed"]      = $all_vehicle["on_hand_with_towed"]->count();
        $all_vehicle["on_hand_with_title"]      = $all_vehicle["on_hand_with_title"]->count();
        $all_vehicle["on_hand_with_out_title"]  = $all_vehicle["on_hand_with_out_title"]->count();
        $all_vehicle["on_hand_with_out_towed"]  = $all_vehicle["on_hand_with_out_towed"]->count();
        $all_vehicle["towed"]                   = $all_vehicle["towed"]->count();
        $all_vehicle["not_towed"]               = $all_vehicle["not_towed"]->count();
        $all_vehicle["with_title"]              = $all_vehicle["with_title"]->count();
        $all_vehicle["with_out_title"]          = $all_vehicle["with_out_title"]->count();
        $all_vehicle["towed_with_title"]        = $all_vehicle["towed_with_title"]->count();
        $all_vehicle["towed_with_out_title"]    = $all_vehicle["towed_with_out_title"]->count();
        $all_vehicle["arrived"]                 = $all_vehicle["arrived"]->count();
        $all_vehicle["towed_by_galaxy"]         = $all_vehicle["towed_by_galaxy"]->count();
        $all_vehicle["towed_by_customer"]       = $all_vehicle["towed_by_customer"]->count();
        $all_vehicle["all_container"]			= $all_vehicle["all_container"]->count();

        $all_vehicle["is_requested"]            = $all_vehicle["is_requested"]->count();
        $all_vehicle["car_dispatched"]		    = $all_vehicle["car_dispatched"]->count();
        $all_vehicle["car_loaded"]		        = $all_vehicle["car_loaded"]->count();

        $all_vehicle["car_on_way_iran"]         = $all_vehicle["car_on_way_iran"]->count();
        $all_vehicle["cars_arrived_iran"]		= $all_vehicle["cars_arrived_iran"]->count();
        $all_vehicle["cars_onway_final_destinations"] 	= $all_vehicle["cars_onway_final_destinations"]->count();
        $all_vehicle["cars_arrived_final_destinations"] = $all_vehicle["cars_arrived_final_destinations"]->count();

        return $all_vehicle;
    }
}
