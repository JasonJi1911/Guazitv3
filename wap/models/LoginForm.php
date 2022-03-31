<?php
namespace wap\models;

use Yii;
use yii\base\Model;
use wap\models\User;

/**
 * Login form
 */
class LoginForm extends Model
{
//    public $username;
    public $mobile;
    public $mobile_areacode;
    public $email;
    public $password;
//    public $captcha;
    public $rememberMe = true;
    public $flag;

    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['mobile','mobile_areacode'], 'required'],
//            ['captcha', 'captcha'],
            [['mobile'], 'string', 'max' => 11],
            [['mobile_areacode'], 'string', 'max' => 10],
            [['email'], 'string', 'max' => 32],
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
//            'username' => '用户名',
            'mobile' => '手机号',
            'email' => '邮箱',
            'password' => '密码',
//            'captcha' => '验证码',
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
        if ($this->validateUser()) {
            return Yii::$app->user->login($this->getUser(), Yii::$app->user->authTimeout);
        }

        return false;
    }

    /*
     * 登录校验：1.密码；2.短信验证码
     */
    public function validateUser(){
        if(!$this->mobile){
            return false;
        }
        if($this->flag==0){//密码登录
            $u = User::findOne(['mobile' => $this->mobile,'mobile_areacode' => $this->mobile_areacode, 'status' => User::STATUS_ENABLED]);
            if($u){
                return $this->validate();
            }else{
                return false;
            }
        }else{//短信验证码登录
            return true;
        }
    }

    /**
     * Finds User by [[mobile|email]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user ===null) {
            if($this->mobile){
                $this->_user = User::finduserBymobile($this->mobile);
            }else{
                $this->_user = User::finduserByemail($this->email);
            }
        }
        return $this->_user;
    }
}
