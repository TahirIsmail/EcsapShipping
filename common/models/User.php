<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * User model.
 *
 * @property int    $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property int    $status
 * @property int    $created_at
 * @property int    $updated_at
 * @property string $password             write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    public $role;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => User::className(), 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            [['address_line_1', 'address_line_1', 'country', 'state', 'zip', 'phone', 'fax', 'role', 'username'], 'safe'],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::className(), 'message' => 'This email address has already been taken.'],
            // ['password', 'required'],
            // ['password', 'string', 'min' => 6],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        // return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }
    
    public function afterLogin($insert)
    {
        $identity = $insert->identity;
        
        $identity->auth_key = \Yii::$app->security->generateRandomString();
        $identity->save(false);
        //$this->auth_key = \Yii::$app->security->generateRandomString();
        
        return true;
       
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) 
            {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changeAttributes)
    {
        try {
            $user = \common\models\User::findOne(['id' => Yii::$app->user->id]);
            if ($insert) {
                $message = $user->username.' has add USER with username '.$this->username;
                \Yii::$app->getDb()->createCommand('INSERT INTO `audit` (`user_id`, `datetime`, `logs`) VALUES ('.Yii::$app->user->id.", CURRENT_TIMESTAMP, '$message');")->query();
            } else {
                $message = $user->username.' has changed USER ('.$this->username.') '.json_encode($changeAttributes);
                \Yii::$app->getDb()->createCommand('INSERT INTO `audit` (`user_id`, `datetime`, `logs`) VALUES ('.Yii::$app->user->id.", CURRENT_TIMESTAMP, '$message');")->query();
            }
        } catch (\Exception $e) {
        }
    }

    /**
     * Finds user by username.
     *
     * @param string $username
     *
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token.
     *
     * @param string $token password reset token
     *
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid.
     *
     * @param string $token password reset token
     *
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];

        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password.
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model.
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key.
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token.
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString().'_'.time();
    }

    /**
     * Removes password reset token.
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public static function customeruser($model)
    {
        $user = new User();
        $user->username = $model->email;
        $user->email = $model->email;
        $user->setPassword($model->legacy_customer_id);
        $user->generateAuthKey();
        if (!$user->save()) {
            throw new \Exception(implode('<br />', \yii\helpers\ArrayHelper::getColumn($user->errors, 0, false)));
        }

        return $user;
    }

    public static function update_customer($model)
    {
        if ($model->legacy_customer_id) {
             if($model->status == 1){
                $status = 10;
            } else {
                $status =0;
            }
            $update_customer = Yii::$app->db->createCommand()
                ->update('user', ['username' => $model->email,
                    'status' => $status,
                    'email' => $model->email,
                    'Password_hash' => Yii::$app->security->generatePasswordHash($model->legacy_customer_id),
                ], 'id ="'.$model->user_id.'"')
                ->execute();
        }
    }

    public function getPassword()
    {
        return '';
    }
}
