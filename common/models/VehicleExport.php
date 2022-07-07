<?php

namespace common\models;

use yii2tech\ar\softdelete\SoftDeleteBehavior;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "vehicle_export".
 *
 * @property int $id
 * @property int $vehicle_id
 * @property int $export_id
 * @property int $customer_user_id
 * @property double $custom_duty
 * @property double $clearance
 * @property double $towing
 * @property double $shipping
 * @property double $storage
 * @property double $local
 * @property double $others
 * @property double $additional
 * @property double $vat
 * @property string $remarks
 *
 * @property Customer $customerUser
 * @property Export $export
 * @property Vehicle $vehicle
 */
class VehicleExport extends \yii\db\ActiveRecord
{
    public $eta;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vehicle_export';
    }
    public function getEta(){
        return $this->eta;
    }
    public function setEta($eta){
        $this->eta = $this->export->eta;
    }
    public function behaviors()
    {
        return [

            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::className(),
                'softDeleteAttributeValues' => [
                    'vehicle_export_is_deleted' => true,
                ],
                'replaceRegularDelete' => true,
            ],
        ];
    }
    public static function find()
    {
        return new VehicleExportQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vehicle_id', 'export_id', 'customer_user_id'], 'required'],
            [['vehicle_id', 'export_id', 'customer_user_id'], 'integer'],
            [['vehicle_export_is_deleted'], 'boolean'],
            [['custom_duty', 'clearance', 'towing', 'shipping', 'storage', 'local', 'others', 'additional', 'vat', 'title', 'discount', 'exchange_rate', 'ocean_charges'], 'number'],
            [['remarks'], 'string', 'max' => 250],
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'notes_status'], 'safe'],
            [['customer_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_user_id' => 'user_id']],
            [['export_id'], 'exist', 'skipOnError' => true, 'targetClass' => Export::className(), 'targetAttribute' => ['export_id' => 'id']],
            [['vehicle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehicle::className(), 'targetAttribute' => ['vehicle_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'vehicle_id' => Yii::t('app', 'VEHICLE ID'),
            'export_id' => Yii::t('app', 'EXPORT ID'),
            'customer_user_id' => Yii::t('app', 'CUSTOMER USER ID'),
            'custom_duty' => Yii::t('app', 'CUSTOM DUTY'),
            'clearance' => Yii::t('app', 'CLEARANCE'),
            'towing' => Yii::t('app', 'TOWING'),
            'shipping' => Yii::t('app', 'SHIPPING'),
            'storage' => Yii::t('app', 'STORAGE'),
            'local' => Yii::t('app', 'LOCAL'),
            'others' => Yii::t('app', 'OTHERS'),
            'additional' => Yii::t('app', 'ADDITIONAL'),
            'vat' => Yii::t('app', 'VAT'),
            'remarks' => Yii::t('app', 'REMARKS'),
            'status' => Yii::t('app', 'STATUS'),
            'eta'=>'ETA'
        ];
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
    public function getExport()
    {
        return $this->hasOne(Export::className(), ['id' => 'export_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicle()
    {
        return $this->hasOne(Vehicle::className(), ['id' => 'vehicle_id']);
    }
    public static function invoice_export_data($invoice_data)
    {

        $invoice_data_vehicle = json_decode($invoice_data->invoice_info);

        foreach ($invoice_data_vehicle->invoice_info as $vehicle_detail) {
            $vehicle_export_id = VehicleExport::find()->where(['=', 'export_id', $invoice_data->export_id])->andWhere(['=', 'vehicle_id', $vehicle_detail->vehicle_id])->one();

            $update_vehicle_export = Yii::$app->db->createCommand()
                ->update('vehicle_export', ['towing' => $vehicle_detail->towing,
                    // 'shipping' => $vehicle_detail->shipping,
                    'exchange_rate' => $vehicle_detail->exchange_rate,
                    'storage' => $vehicle_detail->storage,
                    'local' => $vehicle_detail->local,
                    'title' => $vehicle_detail->title,
                    'others' => $vehicle_detail->others,
                    // 'custom_duty' => $vehicle_detail->custom_duty,
                    // 'clearance' => $vehicle_detail->clearance,
                    'additional' => $vehicle_detail->additional,
                    'vat' => $vehicle_detail->vat,
                    'remarks' => $vehicle_detail->remarks,

                ], 'id ="' . $vehicle_export_id->id . '"')
                ->execute();

        }
    }
    public static function vehcile_export_data($export_data)
    {
        $export_data_vehicle = json_decode($export_data->vehicle_info);

        foreach ($export_data_vehicle->vehicle_info as $vehicle_detail) {

            $vehicle_export = new VehicleExport();
            $vehicle_export->isNewRecord = true;
            $vehicle_export->id = null;

            $vehicle_details = \common\models\Vehicle::find()->where(['vin' => $vehicle_detail->Vin])->one();
            $vehicle_export->customer_user_id = $vehicle_details->customer_user_id;
            $vehicle_export->vehicle_id = $vehicle_details->id;
            $vehicle_export->export_id = $export_data->id;
            $vehicle_export->save();
//            if ($export_data->container_number && $export_data->loading_date && $export_data->export_date && $export_data->eta) {
            if (!empty($export_data->export_date)) {
                $update_exported_vehicle = Yii::$app->db->createCommand()
                    ->update('vehicle', ['is_export' => '1',
                        'container_number' => $export_data->container_number,
                        'status' => '4',
                        'updated_at'=>date('Y-m-d h:i:s'),
                    ], 'id ="' . $vehicle_details->id . '"')
                    ->execute();
            } else {
                $update_exported_vehicle = Yii::$app->db->createCommand()
                    ->update('vehicle', ['is_export' => '1',
                        'status' => '2',
                        'updated_at'=>date('Y-m-d h:i:s'),
                    ], 'id ="' . $vehicle_details->id . '"')
                    ->execute();
            }

        }

    }
    public static function all_export($user_id)
    {
        $all_export = Yii::$app->db->createCommand('select DISTINCT export_id from vehicle_export where customer_user_id = ' . $user_id . ' group by export_id,customer_user_id')->queryAll();
        return count($all_export);
    }
}
