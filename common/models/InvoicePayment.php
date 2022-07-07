<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoice_payment".
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $customer_id
 * @property double $paid_amount
 * @property int $updated_by
 * @property int $created_by
 * @property string $updated_at
 * @property string $created_at
 * @property string $note
 */
class InvoicePayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice_id', 'customer_id', 'paid_amount', 'updated_by', 'created_by', 'updated_at','export_id'], 'required'],
            [['invoice_id', 'customer_id', 'updated_by', 'created_by'], 'integer'],
            [['paid_amount'], 'number'],
            [['updated_at', 'created_at','added_by_role'], 'safe'],
            [['note'], 'string', 'max' => 256],
        ];
    }
    public function getCustomerUser()
    {
        return $this->hasOne(Customer::className(), ['user_id' => 'customer_id']);
    }
    public function getPaymentInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_id' => 'INVOICE ID',
            'customer_id' => 'CUSTOMER ID',
            'paid_amount' => 'PAID AMOUNT',
            'updated_by' => 'Updated By',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'note' => 'Note',
        ];
    }
}
