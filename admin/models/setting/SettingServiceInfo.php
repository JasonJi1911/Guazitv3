<?php
namespace admin\models\setting;

class SettingServiceInfo extends \common\models\setting\SettingServiceInfo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['qq'], 'string', 'max' => 64],
            [['email', 'telphone', 'company', 'wechat'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'qq' => 'qq号',
            'email' => '邮箱',
            'telphone' => '电话',
            'company' => '公司名称',
            'wechat' => '微信'
        ];
    }
}
