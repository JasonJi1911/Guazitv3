<?php
namespace admin\models\apps;

class AppsAlipay extends \common\models\apps\AppsAlipay
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alipay_app_id', 'alipay_public_key', 'rsa_private_key'], 'trim'],
            [['alipay_app_id', 'alipay_public_key', 'rsa_private_key'], 'required'],
            [['app_id', 'created_at', 'updated_at'], 'integer'],
            [['alipay_app_id'], 'string', 'max' => 64],
            [['alipay_public_key'], 'string', 'max' => 1024],
            [['rsa_private_key'], 'string', 'max' => 2048],
            [['alipay_app_id', 'alipay_public_key', 'rsa_private_key'], 'trim']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app_id' => 'App ID',
            'alipay_app_id' => 'AppID',
            'alipay_public_key' => '支付宝公钥',
            'rsa_private_key' => '商户私钥',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
