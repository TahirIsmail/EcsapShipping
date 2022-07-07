<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer_documents".
 *
 * @property int $id
 * @property string $file
 * @property string $description
 * @property int $customer_user_id
 *
 * @property Customer $customerUser
 */
class CustomerDocuments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer_documents';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_user_id'], 'required'],
            [['customer_user_id'], 'integer'],
            [['file', 'thumbnail'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 45],
            [['customer_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_user_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'file' => Yii::t('app', 'File'),
            'description' => Yii::t('app', 'Description'),
            'customer_user_id' => Yii::t('app', 'Customer User ID'),
        ];
    }
    public static function save_document($model_id, $photo)
    {
        foreach ($photo as $photo) {
            $customer_doc = new CustomerDocuments();
            $customer_doc->isNewRecord = true;
            $customer_doc->file = $photo->name;
            $ext = explode(".", $photo->name);
            $file_extension = end($ext);
            $customer_doc->file = Yii::$app->security->generateRandomString() . ".{$file_extension}";
            $path = Yii::getAlias('@app') . '/../uploads/' . $customer_doc->file;
            $photo->saveAs($path);
            $customer_doc->customer_user_id = $model_id;
            $customer_doc->save();

        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerUser()
    {
        return $this->hasOne(Customer::className(), ['user_id' => 'customer_user_id']);
    }
}
