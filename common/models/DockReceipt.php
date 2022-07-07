<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dock_receipt".
 *
 * @property int $export_id
 * @property string $awb_number
 * @property string $export_reference
 * @property string $forwarding_agent
 * @property string $domestic_routing_insctructions
 * @property string $pre_carriage_by
 * @property string $place_of_receipt_by_pre_carrier
 * @property string $exporting_carrier
 * @property string $final_destination
 * @property string $loading_terminal
 * @property string $container_type
 * @property string $number_of_packages
 * @property string $by
 * @property string $date
 * @property string $auto_recieving_date
 * @property string $auto_cut_off
 * @property string $vessel_cut_off
 * @property string $sale_date
 *
 * @property Export $export
 */
class DockReceipt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dock_receipt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // ['awb_number', 'required', 'message' => 'Please enter the B/L or AWB Number: .'],             
            [['export_id'], 'integer'],
            [['forwarding_agent', 'domestic_routing_insctructions'], 'string'],
            [['date', 'auto_recieving_date', 'sale_date'], 'safe'],
            [['awb_number', 'place_of_receipt_by_pre_carrier', 'container_type', 'number_of_packages', 'auto_cut_off'], 'string', 'max' => 45],
            [['export_reference', 'exporting_carrier', 'final_destination', 'loading_terminal', 'by'], 'string', 'max' => 200],
            [['pre_carriage_by', 'vessel_cut_off'], 'string', 'max' => 450],
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
            'export_id' => 'Export ID',
            'awb_number' => 'B/L or AWB Number:',
            'export_reference' => 'Export Reference',
            'forwarding_agent' => 'Forwarding Agent',
            'domestic_routing_insctructions' => 'Domestic Routing Instructions',
            'pre_carriage_by' => 'Pre Carriage By',
            'place_of_receipt_by_pre_carrier' => 'Place Of Receipt By Pre Carrier',
            'exporting_carrier' => 'Exporting Carrier',
            'final_destination' => 'Final Destination',
            'loading_terminal' => 'Loading Terminal',
            'container_type' => 'Container Type',
            'number_of_packages' => 'Number Of Packages',
            'by' => 'By',
            'date' => 'Date',
            'auto_recieving_date' => 'Auto Recieving Date',
            'auto_cut_off' => 'Auto Cut Off',
            'vessel_cut_off' => 'Vessel Cut Off',
            'sale_date' => 'Sale Date',
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
