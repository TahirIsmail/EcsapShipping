<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "features".
 *
 * @property int $id
 * @property string $name
 *
 * @property VehicleFeatures[] $vehicleFeatures
 */
class Features extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'features';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 45],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleFeatures()
    {
        return $this->hasMany(VehicleFeatures::className(), ['features_id' => 'id']);
    }
}
