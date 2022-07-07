<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use Yii;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * This is the model class for table "export".
 *
 * @property int                      $id
 * @property string                   $export_date
 * @property string                   $loading_date
 * @property string                   $manifest_date
 * @property string                   $broker_name
 * @property string                   $booking_number
 * @property string                   $eta
 * @property string                   $ar_number
 * @property string                   $xtn_number
 * @property string                   $seal_number
 * @property string                   $container_number
 * @property string                   $cutt_off
 * @property string                   $vessel
 * @property string                   $voyage
 * @property string                   $terminal
 * @property string                   $streamship_line
 * @property string                   $destination
 * @property string                   $itn
 * @property string                   $contact_details
 * @property string                   $special_instruction
 * @property string                   $container_type
 * @property string                   $port_of_loading
 * @property string                   $port_of_discharge
 * @property string                   $bol_note
 * @property bool                     $is_deleted
 * @property int                      $created_by
 * @property int                      $updated_by
 * @property string                   $created_at
 * @property string                   $updated_at
 * @property DockReceipt              $dockReceipt
 * @property ExportImages[]           $exportImages
 * @property HoustanCustomCoverLetter $houstanCustomCoverLetter
 * @property VehicleExport[]          $vehicleExports
 */
class Export extends \yii\db\ActiveRecord
{
    public $vehicle_info;
    public $vin_search;
    public $imageFiles;
    public $text;
    public $imageFile;
    public $imageurl;

    // status for export to iran
    const CARONTHEWAYIRAN = 1;
    const CARSARRIVEDIRAN = 2;
    const ONWAYFINALDESTINATIONS = 3;
    const ARRIVEDFINALDESINTANTIONS = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'export';
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
                    'export_is_deleted' => true,
                ],
                'replaceRegularDelete' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['customer_user_id', 'required', 'message' => 'Please enter the CUSTOMER NAME.'],
//            ['booking_number', 'required', 'message' => 'Please enter the booking number.'],
           // ['export_date', 'required', 'message' => 'Please enter the export date.'],
           ['loading_date', 'required', 'message' => 'Please enter the loading date.'],
           ['container_number', 'required', 'message' => 'Please enter the container number.'],
            ['ar_number', 'required', 'message' => 'Please enter the ar number.'],
            ['cutt_off', 'required', 'message' => 'Please enter the cutt off date.'],
            ['vessel', 'required', 'message' => 'Please enter the vessel.'],
            ['terminal', 'required', 'message' => 'Please enter the terminal.'],
            ['streamship_line', 'required', 'message' => 'Please enter the streamship_line.'],
            ['destination', 'required', 'message' => 'Please enter the destination.'],
            ['container_type', 'required', 'message' => 'Please enter the container type.'],
            ['port_of_loading', 'required', 'message' => 'Please enter the port_of_loading.'],
            ['port_of_discharge', 'required', 'message' => 'Please enter the port_of_discharge.'],
            [['manifest_date','export_date', 'vehicle_info', 'imageFiles', 'vin_search;', 'loading_date', 'export_invoice', 'created_at', 'updated_at', 'text', 'imageFile', 'imageurl', 'added_by_role'], 'safe'],
         //   [['export_invoice'], 'file', 'skipOnEmpty' =>  !$this->isNewRecord, 'extensions' => 'png, jpg,pdf'],
            [['contact_details', 'special_instruction'], 'string'],
            [['export_is_deleted'], 'boolean'],

            [['created_by', 'updated_by', 'notes_status'], 'integer'],
            [['broker_name', 'xtn_number', 'oti_number'], 'string', 'max' => 450],
            ['ar_number', 'unique', 'message' => 'AR Number should be unique'],
            [['booking_number', 'eta', 'ar_number', 'seal_number', 'container_number', 'cutt_off', 'vessel', 'voyage', 'terminal', 'destination', 'container_type', 'bol_note'], 'string', 'max' => 45],
            [['streamship_line', 'port_of_loading', 'port_of_discharge', 'itn'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'export_date' => 'EXPORT DATE',
            'loading_date' => 'LOADING DATE',
            'manifest_date' => 'MANIFEST DATE',
            'broker_name' => 'BROKER NAME',
            'booking_number' => 'BOOKING NO',
            'eta' => 'ETA',
            'ar_number' => 'AR NO',
            'xtn_number' => 'XTN NO',
            'seal_number' => 'SEAL NO',
            'container_number' => 'CONTAINER NO',
            'cutt_off' => 'CUT OFF',
            'vessel' => 'VESSEL',
            'voyage' => 'VOYAGE',
            'terminal' => 'TERMINAL',
            'streamship_line' => 'STREAMSHIP LINE',
            'destination' => 'DESTINATION',
            'itn' => 'ITN',
            'imageFiles' => 'UPLOAD INVOICE',
            'contact_details' => 'CONTACT DETAILS',
            'special_instruction' => 'SPECIAL INSTRUCTION',
            'container_type' => 'CONTAINER TYPE',
            'port_of_loading' => 'PORT OF LOADING',
            'port_of_discharge' => 'PORT OF DISCHARGE',
            'bol_note' => 'BOL NOTE',
            'is_deleted' => 'IS DELEATED',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'export_invoice' => 'EXPORT INVOICE',
            'customer_user_id' => 'CUSTOMER',
            'customer_name' => 'CUSTOMER',
        ];
    }

    public function extraFields()
    {
        return [
                'exportImages',
                'customerUser',
                ];
        parent::extraFields();
    }

    public function afterSave($insert, $changeAttributes)
    {
        try {
            $user = \common\models\User::findOne(['id' => Yii::$app->user->id]);
            if ($insert) {
                $message = $user->username.' has add CONTAINER with AR NUMBER '.$this->ar_number;
                \Yii::$app->getDb()->createCommand('INSERT INTO `audit` (`user_id`, `datetime`, `logs`) VALUES ('.Yii::$app->user->id.", CURRENT_TIMESTAMP, '$message');")->query();
            } else {
                $message = $user->username.' has changed CONTAINER ('.$this->ar_number.') '.json_encode($changeAttributes);
                \Yii::$app->getDb()->createCommand('INSERT INTO `audit` (`user_id`, `datetime`, `logs`) VALUES ('.Yii::$app->user->id.", CURRENT_TIMESTAMP, '$message');")->query();
            }
        } catch (\Exception $e) {
        }
    }

    public static function find()
    {
        return new ExportQuery(get_called_class());
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
            $this->added_by_role = \common\models\Lookup::roleNameFromRole($roles);
            //$this->legacy_customer_id = "";
            return true;
        }
    }

    public function getDockReceipt()
    {
        return $this->hasOne(DockReceipt::className(), ['export_id' => 'id']);
    }

    /* @return \yii\db\ActiveQuery
    */
    public function getExportImages()
    {
        return $this->hasMany(ExportImages::className(), ['export_id' => 'id']);
    }

    public function getCustomerUser()
    {
        return $this->hasOne(Customer::className(), ['user_id' => 'customer_user_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'customer_user_id']);
    }

    public function getNotes()
    {
        return $this->hasMany(Note::className(), ['export_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHoustanCustomCoverLetter()
    {
        return $this->hasOne(HoustanCustomCoverLetter::className(), ['export_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleExports()
    {
        return $this->hasMany(VehicleExport::className(), ['export_id' => 'id'])->andWhere('vehicle_export_is_deleted != 1')->orderBy(['vehicle_id' => SORT_DESC]);
    }

    public static function getExports()
    {
        $data = Export::find()->all();
        $value = (count($data) == 0) ? ['' => ''] : \yii\helpers\ArrayHelper::map($data, 'id', 'ar_number'); //id = your ID model, name = your caption
        return $value;
    }
}
