<?php
namespace admin\models\setting;

class SettingMpInfo extends \common\models\setting\SettingMpInfo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lead_down_switch', 'force_chapter_num'], 'required'],
            [['lead_down_switch', 'force_chapter_num'], 'integer'],
            [['white_ip_list'], 'string', 'max' => 512],
            [['service_info', 'pay_tips_txt'], 'string', 'max' => 4096],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'white_ip_list' => 'White Ip List',
            'lead_down_switch' => 'Lead Down Switch',
            'service_info' => 'Service Info',
            'pay_tips_txt' => 'Pay Tips Txt',
            'force_chapter_num' => 'Force Chapter Num',
        ];
    }
}
