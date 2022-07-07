<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "location".
 *
 * @property int $location_id
 * @property string $location_name
 * @property int $status is active : 0 = inActive,1 = Active
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 */
class Location extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'location';
    }

    public function behaviors()
    {
        return array(
            array(
                "class" => \yii\behaviors\BlameableBehavior::className(), 
                "createdByAttribute" => "created_by", 
                "updatedByAttribute" => "updated_by"
            ), 
            array(
                "class" => \yii\behaviors\TimestampBehavior::className(), 
                "createdAtAttribute" => "created_at", 
                "updatedAtAttribute" => "updated_at", 
                "value" => new \yii\db\Expression("NOW()")
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['location_name', 'created_by', 'updated_by'], 'required'],
            [['status', 'created_by', 'updated_by','type'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['location_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'location_id' => 'Location ID',
            'location_name' => 'Location Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Get location data for Location dropdown box
     * @param boolean $active_only whether you want to active only records or all
     * @return mixed|boolean|\yii\caching\Dependency|string
     */
    public static function getLocationDropDrown($active_only = false,$type = false)
    {
        // $locations = Yii::$app->cache->get(__CLASS__.__FUNCTION__ . '_' . $active_only);
        //if ($locations === false)
        {
            $query = Location::find();
//             $query = $query->orderBy('location_name');
            if($active_only) $query->andWhere(['status' => 1]);
            if($type) $query->andWhere(['type' => $type]);

            $countries = ArrayHelper::map($query->all(), 'location_id', 'location_name');
            // Yii::$app->cache->set(__CLASS__.__FUNCTION__ . '_' . $active_only, $countries, Yii::$app->params['cache_duration']);
        }

        return $countries;
    }
}
