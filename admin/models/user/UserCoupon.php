<?php
namespace admin\models\user;

use admin\models\video\Video;

class UserCoupon extends \common\models\user\UserCoupon
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'num', 'recv_time', 'use_time', 'expire_time', 'video_id', 'type', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['trade_no'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增主键',
            'uid' => '用户uid',
            'trade_no' => '交易号',
            'num' => '数量',
            'recv_time' => '获取时间',
            'use_time' => '使用时间',
            'expire_time' => '过期时间',
            'video_id' => '使用于视频的id',
            'type' => '状态 1使用 2获取',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'deleted_at' => '删除时间',
        ];
    }

    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['id' => 'video_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['uid' => 'uid']);
    }
}
