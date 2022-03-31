<?php
namespace wap\models;

use yii\web\IdentityInterface;
use Yii;

class User extends \common\models\user\User implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from_channel', 'product', 'from_market', 'source', 'gender', 'reg_type', 'reg_time', 'last_login_time', 'status', 'user_type', 'created_at', 'updated_at', 'deleted_at','security_question'], 'integer'],
            [['mobile'], 'string', 'max' => 11],
            [['nickname', 'device_id'], 'string', 'max' => 128],
            [['udid', 'intro'], 'string', 'max' => 64],
            [['user_token','email', 'auth_key','security_answer'], 'string', 'max' => 32],
            [['password_hash'], 'string', 'max' => 255],
//            [['avatar'], 'string', 'max' => 256],
            [['reg_ip', 'last_login_ip'], 'string', 'max' => 15],
            [['salt'], 'string', 'max' => 6],
            [['nickname', 'gender', 'status'], 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'mobile' => '手机号',
            'email'=>'邮箱',
            'nickname' => '昵称',
            'udid' => 'Udid',
            'user_token' => 'User Token',
            'password_hash' => 'Password Hash',
            'from_channel' => 'From Channel',
            'product' => 'Product',
            'from_market' => 'From Market',
            'source' => '用户来源',
            'gender' => '性别',
            'avatar' => '头像',
            'intro' => 'Intro',
            'reg_type' => 'Reg Type',
            'reg_ip' => 'Reg Ip',
            'reg_time' => 'Reg Time',
            'last_login_ip' => 'Last Login Ip',
            'last_login_time' => 'Last Login Time',
            'status' => '状态',
            'salt' => 'Salt',
            'fromChannelText' => '来源',
            'device_id' => 'Device ID',
            'user_type' => 'User Type',
            'auth_key' => 'AUTH_KEY',
            'security_question' => '密保问题',
            'security_answer' => '密保答案',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public static function find()
    {
        return parent::find()->orderBy('created_at desc');
    }


    /**
     * 验证密码
     * @return bool
     */
    public function validatePassword($password)
    {
//        return (sha1(md5($password) . $this->salt) === $this->encrypt_password);
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * 关联资产
     */
    public function getAsset()
    {
        return $this->hasOne(UserAssets::className(), ['uid' => 'uid']);
    }

    public function afterDelete()
    {
        if (!parent::afterDelete()) {
            return false;
        }
        // 删除绑定关系
        UserAuthApp::deleteAll(['uid' => $this->uid]);
    }

    // public function finduserBymobileOremail($mobile,$email){
    //     if(!$mobile){
    //         return static::findOne(['mobile' => $mobile, 'status' => self::STATUS_ENABLED]);
    //     }else{
    //         return static::findOne(['email' => $email, 'status' => self::STATUS_ENABLED]);
    //     }
    // }

    public static function finduserBymobile($mobile)
    {
        return static::findOne(['mobile' => $mobile, 'status' => self::STATUS_ENABLED]);
    }

    public static function finduserByemail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ENABLED]);
    }

    //Implement method
    public static function findIdentity($id)
    {
        return static::findOne(['uid' => $id, 'status' => self::STATUS_ENABLED]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
