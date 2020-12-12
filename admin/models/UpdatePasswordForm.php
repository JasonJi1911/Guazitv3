<?php
namespace admin\models;

use Yii;
use yii\base\Model;

/**
 * Update password form
 */
class UpdatePasswordForm extends Model
{
    public $oldPassword;
    public $newPassword;
    public $newPassword_repeat;

    private $_admin;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->_admin = Yii::$app->user->identity;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['oldPassword', 'newPassword', 'newPassword_repeat'], 'required'],
            ['oldPassword', function ($attribute, $params) {
                if (!$this->_admin->validatePassword($this->oldPassword)) {
                    $this->addError($attribute, '原始密码输入错误.');
                }
            }],
            ['newPassword', 'string', 'length' => [6, 16]],
            ['newPassword', 'compare'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'oldPassword' => '原始密码',
            'newPassword' => '新密码',
            'newPassword_repeat' => '重复新密码',
        ];
    }

    /**
     * Update password
     *
     * @return boolean
     */
    public function updatePassword()
    {
        if ($this->validate()) {
            $this->_admin->setPassword($this->newPassword);
            return $this->_admin->save(false);
        }

        return false;
    }
}
