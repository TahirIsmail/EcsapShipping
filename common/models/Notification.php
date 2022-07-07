<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property int $id
 * @property string $subject
 * @property string $message
 * @property bool $is_read
 * @property bool $status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 * @property int $user_id
 * @property string $expire_date
 *
 * @property User $user
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }
    public function behaviors() {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
      
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_read', 'status'], 'boolean'],
            [['created_by', 'updated_by', 'user_id'], 'integer'],
            [['created_at', 'updated_at', 'expire_date','added_by_role'], 'safe'],
            [['user_id'], 'required'],
            [['subject','message'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
    public function beforeValidate() {
        if (parent::beforeValidate()) {
            $roles=   Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()); 
            $this->added_by_role = \common\models\Lookup::roleNameFromRole($roles);
            return true;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'subject' => Yii::t('app', 'Subject'),
            'message' => Yii::t('app', 'Message'),
            'is_read' => Yii::t('app', 'Is Read'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Date '),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_id' => Yii::t('app', 'User ID'),
            'expire_date' => Yii::t('app', 'Expire Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
