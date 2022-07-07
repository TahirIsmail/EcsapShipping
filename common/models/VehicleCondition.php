<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vehicle_condition".
 *
 * @property int $id
 * @property string $value
 * @property int $vehicle_id
 * @property int $condition_id
 *
 * @property Vehicle $vehicle
 * @property Condition $condition
 */
class VehicleCondition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vehicle_condition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          //  [['id', 'vehicle_id', 'condition_id'], 'required'],
            [['id', 'vehicle_id', 'condition_id'], 'integer'],
            [['value'], 'string', 'max' => 45],
            [['id'], 'unique'],
            [['vehicle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehicle::className(), 'targetAttribute' => ['vehicle_id' => 'id']],
            [['condition_id'], 'exist', 'skipOnError' => true, 'targetClass' => Condition::className(), 'targetAttribute' => ['condition_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'vehicle_id' => 'Vehicle ID',
            'condition_id' => 'Condition ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicle()
    {
        return $this->hasOne(Vehicle::className(), ['id' => 'vehicle_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCondition()
    {
        return $this->hasOne(Condition::className(), ['id' => 'condition_id']);
    }
    public static function inert_vehicle_condition($model,$all_condition){
        
        foreach($all_condition as $key=>$value) {
            $vehiclecondition = new VehicleCondition(); 
           
            $vehiclecondition->isNewRecord = true;
            $vehiclecondition->id = null;
            $vehiclecondition->vehicle_id = $model->id; 
            $vehiclecondition->condition_id =$key; 
            $vehiclecondition->value =strtoupper($value); 
           $vehiclecondition->save();
            
            
        }  
    }

}
