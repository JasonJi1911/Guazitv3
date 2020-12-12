<?php
namespace admin\models\setting;

/**
 * 新手用户奖励
 * Class SettingNewUser
 * @package admin\models\setting
 */
class SettingNewUser extends \common\models\setting\SettingNewUser
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gold_num', 'gold_probability', 'silver_num', 'silver_probability', 'vip_num', 'vip_probability'], 'integer'],
            [['gold_probability', 'silver_probability', 'vip_probability'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gold_num' => '金币数',
            'gold_probability' => '概率',
            'silver_num' => '银币数',
            'silver_probability' => '概率',
            'vip_num' => 'vip',
            'vip_probability' => '概率',
        ];
    }
}
