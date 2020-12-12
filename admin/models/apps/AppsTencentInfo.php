<?php
namespace admin\models\apps;

class AppsTencentInfo extends \common\models\apps\AppsTencentInfo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['app_id', 'created_at', 'updated_at'], 'integer'],
            [['wechat_app_id', 'wechat_app_secret', 'qq_app_id'], 'string', 'max' => 64],
            [['wechat_app_id', 'wechat_app_secret', 'qq_app_id'], 'trim']
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
            'wechat_app_id' => '开放平台appid',
            'wechat_app_secret' => '开放平台secret',
            'qq_app_id' => 'qq互联id',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
