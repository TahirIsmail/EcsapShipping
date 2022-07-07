<?php
namespace api\modules\v1\models;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $role=0;
    private $_user;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
         
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['role', 'validateRole'],

        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
       
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
     
  
        }
    }
    public function validateRole($attribute)
    {
        if (!$this->hasErrors()) {  
            $user = $this->getUser();
            $role =   Yii::$app->authManager->getRolesByUser($user->id);
            if (ArrayHelper::keyExists('super_admin', $role, true) || ArrayHelper::keyExists('admin_LA', $role, false)||ArrayHelper::keyExists('admin_GA', $role, false)||ArrayHelper::keyExists('admin_NY', $role, false)||ArrayHelper::keyExists('admin_TX', $role, false)||ArrayHelper::keyExists('admin_TX2', $role, false)||ArrayHelper::keyExists('admin_NJ2', $role, false)||ArrayHelper::keyExists('admin_CA', $role, false)) 
            {
                return true;
            }
            else
            {
                $this->addError($attribute, 'Only Admins are allowed to perfrom this action');
            }
        }
        
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
          return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
         
        }

        return false;

 

        // return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = \common\models\User::findByUsername($this->username);
        }

        return $this->_user;
    }
}