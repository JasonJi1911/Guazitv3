<?php
namespace admin\models\stat;

class UserStat extends \common\models\stat\UserStat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'android_incr', 'apple_incr', 'total_incr', 'day_active', 'recharge_incr', 'recharge_total', 'vip_incr', 'vip_total', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => '日期',
            'android_incr' => '安卓新增用户',
            'apple_incr' => '苹果新增用户',
            'total_incr' => '总新增用户',
            'day_active' => '日活用户',
            'recharge_incr' => '充值新增用户',
            'recharge_total' => '总充值用户',
            'vip_incr' => '新增VIP用户',
            'vip_total' => '总VIP用户',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
