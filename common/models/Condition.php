<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "condition".
 *
 * @property int $id
 * @property string $name
 *
 * @property VehicleCondition[] $vehicleConditions
 */
class Condition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'condition';
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
    public function getVehicleConditions()
    {
        return $this->hasMany(VehicleCondition::className(), ['condition_id' => 'id']);
    }
}
