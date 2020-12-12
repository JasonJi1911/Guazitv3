<?php
namespace admin\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $captcha;
    public $rememberMe = true;

    private $_admin;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'captcha'], 'required'],
            ['captcha', 'captcha'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'captcha' => '验证码',
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
            $admin = $this->getAdmin();
            if (!$admin || !$admin->validatePassword($this->password)) {
                $this->addError($attribute, '非法的用户名或密码.');
            }
        }
    }

    /**
     * Logs in a admin using the provided username and password.
     *
     * @return bool whether the admin is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getAdmin(), Yii::$app->user->authTimeout);
        }
        
        return false;
    }

    /**
     * Finds admin by [[username]]
     *
     * @return Admin|null
     */
    public function getAdmin()
    {
        if ($this->_admin === null) {
            $this->_admin = Admin::findByUsername($this->username);
        }

        return $this->_admin;
    }
}
