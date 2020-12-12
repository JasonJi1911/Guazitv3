<?php
namespace admin\models\apps;

class AppsMessage extends \common\models\apps\AppsMessage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['app_id', 'message_type'], 'integer'],
            [['ali_sign_name', 'ali_verify_code', 'yun_account_id', 'yun_token', 'yun_app_id', 'yun_template_id'], 'string', 'max' => 64],
            [['ali_sign_name', 'ali_verify_code', 'yun_account_id', 'yun_token', 'yun_app_id', 'yun_template_id'], 'trim']
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
            'message_type' => '短信类型',
            'ali_sign_name' => '阿里云短信签名',
            'ali_verify_code' => '阿里云短信模板code',
            'yun_account_id' => '云之讯账号id',
            'yun_token' => '云之讯账号idToken',
            'yun_app_id' => '云之讯账号app id',
            'yun_template_id' => '云之讯模板ID',
        ];
    }
}
