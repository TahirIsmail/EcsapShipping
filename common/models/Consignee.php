<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use Yii;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii\base\Behavior;
/**
 * This is the model class for table "consignee".
 *
 * @property int $id
 * @property int $customer_user_id
 * @property string $consignee_name
 * @property string $consignee_address_1
 * @property string $consignee_address_2
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $zip_code
 * @property string $phone
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Customer $customerUser
 */
class Consignee extends \yii\db\ActiveRecord
{
    public $customer_consignee;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'consignee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['consignee_name','phone'], 'required'],
            [['customer_user_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at','customer_consignee','added_by_role'], 'safe'],
            [['consignee_name', 'consignee_address_1', 'consignee_address_2', 'city', 'state', 'country', 'zip_code', 'phone'], 'string', 'max' => 200],
              [['consignee_is_deleted'], 'boolean'],
            [['customer_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_user_id' => 'user_id']],
        ];
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
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::className(),
                'softDeleteAttributeValues' => [
                    'consignee_is_deleted' => true
                ],
                'replaceRegularDelete' => true
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'customer_user_id' => Yii::t('app', 'CUSTOMER NAME'),
            'consignee_name' => Yii::t('app', 'CONSIGNEE NAME'),
            'consignee_address_1' => Yii::t('app', 'CONSIGNEE ADDRESS 1'),
            'consignee_address_2' => Yii::t('app', 'CONSIGNEE ADDRESS 2'),
            'city' => Yii::t('app', 'CITY'),
            'state' => Yii::t('app', 'STATE'),
            'country' => Yii::t('app', 'COUNTRY'),
            'zip_code' => Yii::t('app', 'ZIP CODE'),
            'phone' => Yii::t('app', 'PHONE'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'customer_consignee' => Yii::t('app', 'ALL CONSIGNEE'),
        ];
    }
    public static function find()
    {
        return new ConsigneeQuery(get_called_class());
    }
    public static function getNameFromId($id){
        $o = self::findOne(['id'=>$id]);
        if($o){
            return $o->consignee_name;
        }else{
            return "";
        }
    }
    public static function getNameFromUserId($id){
        $o = self::findOne(['customer_user_id'=>$id]);
        if($o){
            return $o->consignee_name;
        }else{
            return "";
        }
    }
    public function beforeValidate() {
        if (parent::beforeValidate()) {
            $roles=   Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()); 
            $this->added_by_role = \common\models\Lookup::roleNameFromRole($roles);
            return true;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public  function getCustomerUser()
    {
        return $this->hasOne(Customer::className(), ['user_id' => 'customer_user_id']);
    }
    public static function createConsignee($model){
        $consignee = new Consignee();
        $consignee->customer_user_id = $model->user_id;
        $consignee->consignee_name = $model->company_name;
        $consignee->consignee_address_1 = $model->address_line_1;
        $consignee->consignee_address_2 = $model->address_line_2;
        $consignee->city = $model->city;
        $consignee->state = $model->state;
        $consignee->country = $model->country;
        $consignee->zip_code = $model->zip_code;
        $consignee->phone = $model->phone;
        if(!$consignee->save()){
            throw new \Exception ( implode ( "<br />" , \yii\helpers\ArrayHelper::getColumn ( $consignee->errors , 0 , false ) ) );
        }
       return  $consignee;
    }
    public static function getCustomer(){
        $user_id = Yii::$app->user->getId();
        $Role =   Yii::$app->authManager->getRolesByUser($user_id);
        if(isset($Role['customer']) || isset($Role['admin_LA'])){
        $data= \common\models\Customer::find()->where(['=','user_id',$user_id])->all();
        }else{
        $data= \common\models\Customer::find()->alias('cu')->all();
        }
     $value=(count($data)==0)? [''=>'']: \yii\helpers\ArrayHelper::map($data, 'user_id','company_name'); //id = your ID model, name = your caption
     return $value;
  }
  public static function getConsignee(){
        $data= Consignee::find()->all();
        $value=(count($data)==0)? [''=>'']: \yii\helpers\ArrayHelper::map($data, 'id','consignee_name'); //id = your ID model, name = your caption
        return $value;
  }
}
