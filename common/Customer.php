<?php
namespace common\models;
use common\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii\base\Behavior;
/**
 * This is the model class for table "customer".
 *
 * @property int $user_id
 * @property string $company_name
 * @property string $address_line_1
 * @property string $address_line_2
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $zip_code
 * @property string $tax_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property bool $is_deleted
 *
 * @property User $user
 * @property Vehicle[] $vehicles
 */
class Customer extends \yii\db\ActiveRecord
{
    public $username;
    public $password;
    public $status;
    public $email;
    public $uploads;
  
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
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
                    'is_deleted' => true
                ],
                'replaceRegularDelete' => true
            ],
       
        ];
    }

    public function rules()
    {
        return [
            [['user_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at','uploads', 'updated_at','legacy_customer_id','fax','phone_two','trn','added_by_role'], 'safe'],
            [['company_name','customer_name','username','password', 'tax_id'], 'string', 'max' => 200],
           [['customer_name','email','legacy_customer_id','company_name','city'], 'required'],
            [['is_deleted','status'], 'boolean'],
            [['address_line_1', 'state','phone', 'country','address_line_2'], 'string', 'max' => 450],
            [[ 'city', 'zip_code'], 'string', 'max' => 45],
            [['user_id','legacy_customer_id'], 'unique'],
            ['email', 'email'],
            [['uploads'], 'file',  'maxFiles' => 10],
            // [['user_id'], 'unique', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['email' => 'email'], 'message' => 'This email address has already been taken.'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
  public static function find()
    {
        return new DeleteQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'USER ID',
            'company_name' => 'COMPANY NAME',
            'customer_name' => 'CUSTOMER NAME',
            'address_line_1' => 'ADDRESS 1',
            'address_line_2' => 'ADDRESS 2',
            'city' => 'CITY',
            'state' => 'STATE',
            'status' => 'ACTIVE',
            'country' => 'COUNTRY',
            'zip_code' => 'ZIP CODE',
            'tax_id' => 'TIN OVERSEAS',
            'phone'=>'PHONE USA',
            'trn' => 'TIN USA',
            'phone_two' => 'PHONE OVERSEAS',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'is_deleted' => 'Is Deleted',
            'user_id'=>'CUSTOMER ID',
            'legacy_customer_id'=>'CUSTOMER ID',
            'uploads'=>'UPLOAD DOCUMENTS',
            'fax'=>'FAX',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
  
    	   /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getConsignees() 
   { 
       return $this->hasMany(Consignee::className(), ['customer_user_id' => 'user_id']); 
   }
   
 
   /**
    * @return \yii\db\ActiveQuery
    */
   public function getCustomerDocuments() 
   { 
       return $this->hasMany(CustomerDocuments::className(), ['customer_user_id' => 'user_id']); 
   }
   public function customerNextId(){
       if($this->isNewRecord){
           $last_customer =  \common\models\Customer::find()->orderBy('user_id desc')->one();
           if($last_customer){
               return $last_customer->user_id+1;
           }else{
            return 1;
           }
       }
   }
 
   /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getInvoices() 
   { 
       return $this->hasMany(Invoice::className(), ['customer_user_id' => 'user_id']); 
   } 
 
   /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getVehicles()
   {
       return $this->hasMany(Vehicle::className(), ['customer_user_id' => 'user_id']);
   }
   public function getExportes()
   {
       return $this->hasMany(Vehicle::className(), ['customer_user_id' => 'user_id']);
   }
   /**
    * @return \yii\db\ActiveQuery
    */
   public function getVehicleExports()
   {
       return $this->hasMany(VehicleExport::className(), ['customer_user_id' => 'user_id']);
   }

}
