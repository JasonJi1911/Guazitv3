<?php
namespace admin\models\user;

class User extends \common\models\user\User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from_channel', 'product', 'from_market', 'source', 'gender', 'reg_type', 'reg_time', 'last_login_time', 'status', 'user_type', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['mobile'], 'string', 'max' => 11],
            [['nickname', 'device_id'], 'string', 'max' => 128],
            [['udid', 'intro'], 'string', 'max' => 64],
            [['user_token', 'password_hash'], 'string', 'max' => 32],
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
        return (sha1(md5($password) . $this->salt) === $this->encrypt_password);
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
}
