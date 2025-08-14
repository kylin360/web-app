<?php

namespace app\forms;

use Yii;
use app\models\User;
/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class LoginForm extends BaseForm
{
    public $username;
    public $password;
    public $tenant_code;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username, password and tenant_code are required
            [['username', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @return array the attribute labels.
     */
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'tenant_code' => '租户编码',
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

        \Yii::info('validatePassword: ' . $this->password);
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或密码错误');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return array|bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            \Yii::info('login: ' . $user->username);
            // 生成新的访问令牌
            $user->generateAccessToken();
            $user->save();
            
            // 返回用户信息
            return $user->getUserProfile();
        }
        return false;
    }

    /**
     * Finds user by [[username]] and [[tenant_code]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            
            // 在指定租户下查找用户
            $this->_user = User::findOne([
                'username' => $this->username, 
                'status' => User::STATUS_ACTIVE
            ]);
        }

        return $this->_user;
    }
}
