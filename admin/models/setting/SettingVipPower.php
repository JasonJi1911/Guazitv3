<?php
namespace admin\models\setting;

class SettingVipPower extends \common\models\setting\SettingVipPower
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vip_read_all'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vip_read_all' => '全站读开关',
        ];
    }
}
