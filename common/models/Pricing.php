<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use Yii;

/**
 * This is the model class for table "pricing".
 *
 * @property int $id
 * @property string $upload_file
 * @property string $month
 * @property int $pricing_type
 * @property int $status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Pricing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pricing';
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
    public function beforeValidate() {
        if (parent::beforeValidate()) {
            $roles=   Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()); 
            $this->added_by_role = \common\models\Lookup::roleNameFromRole($roles);
            return true;
        }
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['upload_file'], 'required'],
            [['pricing_type', 'status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at','description','upload_file','added_by_role'], 'safe'],
            [['upload_file'], 'string', 'max' => 200],
            [['month'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'upload_file' => Yii::t('app', 'Upload File'),
            'month' => Yii::t('app', 'Month'),
            'pricing_type' => Yii::t('app', 'Pricing Type'),
            'status' => Yii::t('app', 'Status'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
