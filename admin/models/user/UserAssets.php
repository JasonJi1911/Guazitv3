<?php
namespace admin\models\user;

class UserAssets extends \common\models\user\UserAssets
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'score_remain', 'total_score', 'coupon_remain', 'total_coupon', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['uid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => '用户uid',
            'score_remain' => '剩余积分',
            'total_score' => '累计获得积分',
            'coupon_remain' => '剩余卡券',
            'total_coupon' => '累计卡券',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'deleted_at' => '删除时间',
        ];
    }
}
