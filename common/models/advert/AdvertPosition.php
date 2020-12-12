<?php

namespace common\models\advert;

use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%advert_position}}".
 *
 * @property int $id id
 * @property int $position 广告位置
 * @property int $status 状态（1-开启，2-关闭）
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class AdvertPosition extends \xiang\db\ActiveRecord implements StatusToggleInterface
{
    use StatusToggleTrait;

    // 位置常量
    const POSITION_VIDEO_INDEX  = 1;
    const POSITION_VIDEO_TOPIC  = 2;
    const POSITION_PLAY_BEFORE  = 3;
    const POSITION_PLAY_STOP    = 4;
    const POSITION_LIKE_TOP     = 5;
    const POSITION_LIKE_BOTTOM  = 6;
    const POSITION_TASK         = 7;
    const POSITION_SIGN         = 8;
    const POSITION_ORDER_LIST   = 9;


    public static $positionMap = [
        self::POSITION_VIDEO_INDEX  => '首页',
        self::POSITION_VIDEO_TOPIC  => '发现页',
        self::POSITION_PLAY_BEFORE  => '视频播放播放前广告',
        self::POSITION_PLAY_STOP    => '视频播放暂停时广告',
        self::POSITION_LIKE_TOP     => '播放页-猜你喜欢上方',
        self::POSITION_LIKE_BOTTOM  => '播放页-猜你喜欢下方',
        self::POSITION_TASK         => '福利任务',
        self::POSITION_SIGN         => '每日签到',
        self::POSITION_ORDER_LIST   => '个人中心',
    ];

    // 状态
    public static $statusMap = [
        self::STATUS_ENABLED => '开启',
        self::STATUS_DISABLED => '关闭'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%advert_position}}';
    }


}
