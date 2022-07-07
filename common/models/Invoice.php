<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use Yii;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

/**
 * This is the model class for table "invoice".
 *
 * @property int       $id
 * @property int       $export_id
 * @property int       $customer_user_id
 * @property int       $consignee_id
 * @property float     $total_amount
 * @property float     $paid_amount
 * @property string    $note
 * @property string    $is_deleted
 * @property string    $currency
 * @property int       $updated_by
 * @property int       $created_by
 * @property string    $updated_at
 * @property string    $created_at
 * @property Consignee $consignee
 * @property Customer  $customerUser
 * @property Export    $export
 */
class Invoice extends \yii\db\ActiveRecord
{
    public $invoice_info;
    public $payment_amount;
    public $remaining_amount;
    public $invoice_global_search;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice';
    }

    public function behaviors()
    {
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
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::className(),
                'softDeleteAttributeValues' => [
                    'invoice_is_deleted' => true,
                ],
                'replaceRegularDelete' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['export_id', 'customer_user_id', 'total_amount'], 'required'],
            [['export_id', 'customer_user_id', 'consignee_id', 'updated_by', 'created_by'], 'integer'],
            [['total_amount', 'paid_amount', 'adjustment_damaged', 'adjustment_storage', 'adjustment_discount', 'adjustment_other'], 'number'],
            [['note'], 'string'],
            [['export_id'], 'unique', 'targetAttribute' => ['export_id', 'customer_user_id']],
            [['updated_at', 'before_discount', 'upload_invoice', 'created_at', 'invoice_global_search', 'invoice_info', 'payment_amount', 'discount', 'remaining_amount', 'added_by_role'], 'safe'],
            [['currency'], 'string', 'max' => 45],
            [['consignee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consignee::className(), 'targetAttribute' => ['consignee_id' => 'id']],
            [['customer_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_user_id' => 'user_id']],
            [['export_id'], 'exist', 'skipOnError' => true, 'targetClass' => Export::className(), 'targetAttribute' => ['export_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'INVOICE ID'),
            'export_id' => Yii::t('app', 'CONTAINER NO'),
            'customer_user_id' => Yii::t('app', 'CUSTOMER NAME'),
            'customer_id' => Yii::t('app', 'CUST IT'),
            'consignee_id' => Yii::t('app', 'CONSIGNEE NAME'),
            'payment_amount' => Yii::t('app', 'PAYMENT AMOUNT'),
            'total_amount' => Yii::t('app', 'TOTAL AMOUNT'),
            'paid_amount' => Yii::t('app', 'PAID AMOUNT'),
            'note' => Yii::t('app', 'NOTE'),
            'is_deleted' => Yii::t('app', 'IS DELETED'),
            'currency' => Yii::t('app', 'CURRENCY'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_at' => Yii::t('app', 'Created At'),
            'discount' => Yii::t('app', 'DISCOUNT'),
            'upload_invoice' => Yii::t('app', 'UPLOAD INVOICE'),
            'adjustment_damaged' => Yii::t('app', 'DAMAGED'),
             'adjustment_storage' => Yii::t('app', 'STORAGE'),
              'adjustment_discount' => Yii::t('app', 'DISCOUNT'),
               'adjustment_other' => Yii::t('app', 'OTHER'),
            'before_discount' => Yii::t('app', 'TOTAL AMOUNT(BEFORE DISCOUNT)'),
        ];
    }

    public function afterSave($insert, $changeAttributes)
    {
        try {
            $user = \common\models\User::findOne(['id' => Yii::$app->user->id]);
            if ($insert) {
                $message = $user->username.' has add invoice with INVOICE ID '.$this->id;
                \Yii::$app->getDb()->createCommand('INSERT INTO `audit` (`user_id`, `datetime`, `logs`) VALUES ('.Yii::$app->user->id.", CURRENT_TIMESTAMP, '$message');")->query();
            } else {
                $message = $user->username.' has changed invoice ('.$this->id.') '.json_encode($changeAttributes);
                \Yii::$app->getDb()->createCommand('INSERT INTO `audit` (`user_id`, `datetime`, `logs`) VALUES ('.Yii::$app->user->id.", CURRENT_TIMESTAMP, '$message');")->query();
            }
        } catch (\Exception $e) {
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsignee()
    {
        return $this->hasOne(Consignee::className(), ['id' => 'consignee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerUser()
    {
        return $this->hasOne(Customer::className(), ['user_id' => 'customer_user_id']);
    }

    public function beforeValidate()
    {
        if(empty($this->paid_amount)){
            $this->paid_amount = 0;
        }
        if(empty($this->adjustment_damaged)){
            $this->adjustment_damaged = 0;
        }
        if(empty($this->adjustment_storage)){
            $this->adjustment_storage = 0;
        }
        if(empty($this->adjustment_discount)){
            $this->adjustment_discount = 0;
        }
        if(empty($this->adjustment_other)){
            $this->adjustment_other = 0;
        }
        if (parent::beforeValidate()) {
            $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
            $this->added_by_role = \common\models\Lookup::roleNameFromRole($roles);

            return true;
        }
    }

    public static function getTotal($provider, $columnName)
    {
        $total = 0;
        foreach ($provider as $item) {
            $total += $item[$columnName];
        }

        return $total;
    }

    public static function getTotalremaning($provider)
    {
        $total = 0;
        foreach ($provider as $item) {
            //adjustment_damaged+adjustment_storage+adjustment_discount+adjustment_other
            $total += $item['total_amount'] - $item['paid_amount'] - $item['adjustment_damaged'] - $item['adjustment_storage']- $item['adjustment_discount']- $item['adjustment_other'];
        }

        return $total;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExport()
    {
        return $this->hasOne(Export::className(), ['id' => 'export_id']);
    }

    public function vehicles($customer_id, $export_id)
    {
        $i = 1;
        $vehicles_data = '';
        $vehicle_export_id = \common\models\VehicleExport::find()->where(['=', 'export_id', $export_id])->andWhere(['=', 'customer_user_id', $customer_id])->all();

        if ($vehicle_export_id) {
            foreach ($vehicle_export_id as $vehicle_export) {
                $vehicle = \common\models\Vehicle::find()->where(['=', 'id', $vehicle_export->vehicle_id])->one();
                if ($vehicle) {
                    $vehicles_data .= '<div class="vehicle_grid"> '.$i.'&nbsp;&nbsp;'.$vehicle->make.'&nbsp;('.$vehicle->model.','.$vehicle->color.')&nbsp;Vin#'.$vehicle->vin.'&nbsp;Lot# '.$vehicle->lot_number.'<br></div>';
                }
                ++$i;
            }
        }

        return $vehicles_data;
    }
}
