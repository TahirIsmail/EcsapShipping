<?php
namespace common\models;


use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;


/**
 * Password reset form
 */
class ChangePasswordForm extends Model
{
	public $old_password;
    public $password;
    public $confirm_password;
    public $user_id = null;
    private $_user = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	// Mandatory fields
            [['old_password','password', 'confirm_password'], 'required'],
      		['old_password', 'validatePassword'],

            // Password and confirm password must match
            [['confirm_password'], 'compare', 'compareAttribute' => 'password', 'message' => 'Password and Confirm Password must be same'],

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
    	if (!$this->hasErrors())
    	{
    		$_user = $this->getUser();

    		if (!$_user->validatePassword($this->old_password))
    		{
    			$this->addError($attribute, 'Old password you specified does not match our record.');
    		}
    	}
    }

    /**
     * Finds user by [[id]]
     *
     * @return User|null
     */
    public function getUser()
    {
    	if ($this->_user === false)
    	{
   			$this->_user = User::findOne($this->user_id);
    	}

    	return $this->_user;
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
    	$user = $this->getUser();
        $user->auth_key = "";
        $user->setPassword($this->password);
//         $user->force_password_reset = 'N';
        return $user->save();
    }

    public function attributeLabels()
    {
        return [
            'old_password' => 'Old Password',
            'password' => 'New Password',
            'confirm_password' => 'Confirm New Password'
        ];
    }
}
