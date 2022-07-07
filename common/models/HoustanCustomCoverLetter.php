<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "houstan_custom_cover_letter".
 *
 * @property int $export_id
 * @property string $vehicle_location
 * @property string $exporter_id
 * @property string $exporter_type_issuer
 * @property string $transportation_value
 * @property string $exporter_dob
 * @property string $ultimate_consignee_dob
 * @property string $consignee
 * @property string $notify_party
 * @property string $menifest_consignee
 *
 * @property Export $export
 */
class HoustanCustomCoverLetter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'houstan_custom_cover_letter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // ['vehicle_location', 'required', 'message' => 'Please enter the Vehicle Location.'],             
           // ['consignee','required'],
            ['notify_party', 'required', 'message' => 'Please enter the notify party.'],
            ['consignee', 'required', 'message' => 'Please enter the consignee.'],
            [['export_id'], 'integer'],
            [['vehicle_location', 'exporter_id', 'exporter_type_issuer', 'transportation_value', 'exporter_dob', 'ultimate_consignee_dob'], 'string', 'max' => 45],
            [['consignee', 'notify_party', 'menifest_consignee'], 'string', 'max' => 450],
            [['export_id'], 'unique'],
            [['export_id'], 'exist', 'skipOnError' => true, 'targetClass' => Export::className(), 'targetAttribute' => ['export_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'export_id' => 'EXPORT ID',
            'vehicle_location' => 'VEHICLE LOCATION',
            'exporter_id' => 'EXPORTER ID',
            'exporter_type_issuer' => 'EXPORTER TYPE ISSUER',
            'transportation_value' => 'TRANSPORTATION VALUE',
            'exporter_dob' => 'EXPORTER DOB',
            'ultimate_consignee_dob' => 'ULTIMATE CONSIGNEE DOB',
            'consignee' => 'CONSIGNEE',
            'notify_party' => 'NOTIFY PARTY',
            'menifest_consignee' => 'MENIFEST CONSIGNEE',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExport()
    {
        return $this->hasOne(Export::className(), ['id' => 'export_id']);
    }
}
