<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "audit".
 *
 * @property int $id
 * @property int $user_id
 * @property string $datetime
 * @property string $logs
 */
class Audit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['datetime'], 'safe'],
            [['logs'], 'required'],
            [['logs'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'datetime' => 'Datetime',
            'logs' => 'Logs',
        ];
    }
}
