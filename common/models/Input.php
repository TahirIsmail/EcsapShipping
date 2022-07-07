<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "input".
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $default_value
 * @property string $data_type
 *
 * @property VehicleInput[] $vehicleInputs
 */
class Input extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'input';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type', 'default_value', 'data_type'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'default_value' => 'Default Value',
            'data_type' => 'Data Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleInputs()
    {
        return $this->hasMany(VehicleInput::className(), ['input_id' => 'id']);
    }
}
