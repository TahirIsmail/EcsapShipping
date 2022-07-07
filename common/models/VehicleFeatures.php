<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vehicle_features".
 *
 * @property int $id
 * @property int $vehicle_id
 * @property int $features_id
 * @property int $value
 *
 * @property Features $features
 * @property Vehicle $vehicle
 */
class VehicleFeatures extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vehicle_features';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['vehicle_id', 'features_id'], 'required'],
            [['vehicle_id', 'features_id', 'value'], 'integer'],
            [['features_id'], 'exist', 'skipOnError' => true, 'targetClass' => Features::className(), 'targetAttribute' => ['features_id' => 'id']],
            [['vehicle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehicle::className(), 'targetAttribute' => ['vehicle_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vehicle_id' => 'Vehicle ID',
            'features_id' => 'Features ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeatures()
    {
        return $this->hasOne(Features::className(), ['id' => 'features_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicle()
    {
        return $this->hasOne(Vehicle::className(), ['id' => 'vehicle_id']);
    }
    public static function inert_vehicle_feature($model,$all_features){
        foreach($all_features as $key=>$value) {
        $vehiclefeatures = new VehicleFeatures(); 
            $vehiclefeatures->isNewRecord = true;
            $vehiclefeatures->id = null;
            $vehiclefeatures->vehicle_id = $model->id; 
            $vehiclefeatures->features_id =$key; 
            $vehiclefeatures->value = strtoupper($value);
             $vehiclefeatures->save();    
        }
    }
}
