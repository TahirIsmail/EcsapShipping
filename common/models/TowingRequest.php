<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "towing_request".
 *
 * @property int $id
 * @property bool $condition
 * @property bool $damaged
 * @property bool $pictures
 * @property bool $towed
 * @property bool $title_recieved
 * @property string $title_recieved_date
 * @property string $title_number
 * @property string $title_state
 * @property string $towing_request_date
 * @property string $pickup_date
 * @property string $deliver_date
 * @property string $note
 *
 * @property Vehicle[] $vehicles
 */
class TowingRequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'towing_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        //    [['condition'], 'required'],
            [['pictures', 'towed', 'title_recieved'], 'boolean'],
           // ['pickup_date', 'required', 'message' => 'Please enter pickup date.'],
           // ['deliver_date', 'required', 'message' => 'Please enter deliver date.'],
            //['towing_request_date', 'required', 'message' => 'Please enter towing request date.'],
            [['title_recieved_date','title_recieved', 'towing_request_date', 'pickup_date', 'deliver_date','condition', 'damaged','title_type'], 'safe'],
            [['note'], 'string'],
            [['title_number', 'title_state'], 'string', 'max' => 450],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'condition' => 'CONDITION',
            'damaged' => 'DAMAGED',
            'pictures' => 'PICTURES',
            'towed' => 'TOWED',
            'title_recieved' => 'TITLE',
            'title_recieved_date' => 'TITLE RECEIVED DATE',
            'title_number' => 'TITLE NO',
            'title_state' => 'TITLE STATE',
            'towing_request_date' => 'TOWING REQUEST DATE',
            'pickup_date' => 'PICKUP DATE',
            'deliver_date' => 'DELIVER DATE',
            'title_type' => 'TITLE TYPE',
            'note' => 'NOTE',
            
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicles()
    {
        return $this->hasMany(Vehicle::className(), ['towing_request_id' => 'id']);
    }
}
