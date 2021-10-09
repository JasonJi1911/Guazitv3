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
    const POSITION_VIDEO_INDEX_PC   = 10;
    const POSITION_PLAY_BEFORE_PC   = 11;
    const POSITION_FLASH_PC         = 12;
    const POSITION_FLASH_WAP        = 13;
    const POSITION_VIDEO_TOP_PC     = 14;
    const POSITION_VIDEO_BOTTOM_PC  = 15;
    const POSITION_VIDEO_INDEX_PC1  = 16;
    const POSITION_VIDEO_INDEX_PC2  = 17;
    const POSITION_VIDEO_INDEX_PC3  = 18;
    const POSITION_VIDEO_INDEX_PC4  = 19;
    const POSITION_VIDEO_INDEX_PC5  = 20;
    const POSITION_VIDEO_CHANNEL_PC1 = 21;
    const POSITION_VIDEO_CHANNEL_PC2 = 22;
    const POSITION_VIDEO_CHANNEL_PC3 = 23;
    const POSITION_VIDEO_CHANNEL_PC4 = 24;
    const POSITION_VIDEO_CHANNEL_PC5 = 25;
    const POSITION_VIDEO_CHANNEL_PC6 = 26;
    const POSITION_VIDEO_CHANNEL_PC7 = 27;
    const POSITION_VIDEO_CHANNEL_PC8 = 28;
    const POSITION_VIDEO_CHANNEL_PC9 = 29;
    const POSITION_VIDEO_CHANNEL_PC10 = 30;
    const POSITION_VIDEO_RIGHT_PC  = 31;
    const POSITION_VIDEO_SEARCH_PC  = 32;
    const POSITION_VIDEO_LIST_PC  = 33;
    const POSITION_VIDEO_LOGIN_PC  = 34;

    public static $positionMap = [
        self::POSITION_VIDEO_INDEX  => '手机端首页',
        self::POSITION_VIDEO_TOPIC  => '手机端发现页',
        self::POSITION_PLAY_BEFORE  => '手机端视频播放播放前广告',
        self::POSITION_PLAY_STOP    => 'APP视频播放暂停时广告',
        self::POSITION_LIKE_TOP     => '播放页-猜你喜欢上方',
        self::POSITION_LIKE_BOTTOM  => '播放页-猜你喜欢下方',
        self::POSITION_TASK         => '手机端福利任务',
        self::POSITION_SIGN         => '手机端每日签到',
        self::POSITION_ORDER_LIST   => '手机端个人中心',
        self::POSITION_VIDEO_INDEX_PC   => 'PC首页',
        self::POSITION_PLAY_BEFORE_PC   => 'PC视频播放前广告',
        self::POSITION_FLASH_PC         => 'PC弹窗',
        self::POSITION_FLASH_WAP        => 'WAP弹窗',
        self::POSITION_VIDEO_TOP_PC     => 'PC播放页-播放窗口上方',
        self::POSITION_VIDEO_BOTTOM_PC  => 'PC播放页-播放窗口下方',
        self::POSITION_VIDEO_INDEX_PC1  => 'PC首页1',
        self::POSITION_VIDEO_INDEX_PC2  => 'PC首页2',
        self::POSITION_VIDEO_INDEX_PC3  => 'PC首页3',
        self::POSITION_VIDEO_INDEX_PC4  => 'PC首页4',
        self::POSITION_VIDEO_INDEX_PC5  => 'PC首页5',
        self::POSITION_VIDEO_CHANNEL_PC1  => 'PC类目页1',
        self::POSITION_VIDEO_CHANNEL_PC2  => 'PC类目页2',
        self::POSITION_VIDEO_CHANNEL_PC3  => 'PC类目页3',
        self::POSITION_VIDEO_CHANNEL_PC4  => 'PC类目页4',
        self::POSITION_VIDEO_CHANNEL_PC5  => 'PC类目页5',
        self::POSITION_VIDEO_CHANNEL_PC6  => 'PC类目页6',
        self::POSITION_VIDEO_CHANNEL_PC7  => 'PC类目页7',
        self::POSITION_VIDEO_CHANNEL_PC8  => 'PC类目页8',
        self::POSITION_VIDEO_CHANNEL_PC9  => 'PC类目页9',
        self::POSITION_VIDEO_CHANNEL_PC10 => 'PC类目页10',
        self::POSITION_VIDEO_RIGHT_PC  => 'PC播放页右侧',
        self::POSITION_VIDEO_SEARCH_PC => 'PC搜索页右侧',
        self::POSITION_VIDEO_LIST_PC   => 'PC列表页右侧',
        self::POSITION_VIDEO_LOGIN_PC  => 'PC登录左侧'
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
