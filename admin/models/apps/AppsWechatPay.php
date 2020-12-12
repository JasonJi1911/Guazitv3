<?php
namespace admin\models\apps;

class AppsWechatPay extends \common\models\apps\AppsWechatPay
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['app_id'], 'required'],
            [['app_id', 'created_at', 'updated_at'], 'integer'],
            [['api_sec_key'], 'string', 'max' => 128],
            [['mch_id'], 'string', 'max' => 64],
            [['api_sec_key', 'mch_id'], 'trim']
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
            'mch_id' => '商户号',
            'api_sec_key' => '密钥',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
