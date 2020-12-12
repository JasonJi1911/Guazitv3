<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%video_chapter}}".
 *
 * @property int $id 作品id
 * @property int $video_id 系列id
 * @property string $title 剧集标题
 * @property string $resource_url 资源地址
 * @property int $duration_time 时长
 * @property int $total_views 浏览数
 * @property int $total_comment 评论数
 * @property int $display_order 排序
 * @property int $play_limit 播放限制
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class VideoChapter extends \xiang\db\ActiveRecord
{
    // 播放限制条件
    const PLAY_LIMIT_FREE   = 1;
    const PLAY_LIMIT_VIP    = 2;
    const PLAY_LIMIT_COUPON = 3;
    //资源类型
    const RESOURCE_TYPE_DATA = 1; //数据流格式
    const RESOURCE_TYPE_HTML = 2; //html页面

    public static $playLimitMap = [
        self::PLAY_LIMIT_FREE   => '免费',
        self::PLAY_LIMIT_VIP    => 'VIP',
        self::PLAY_LIMIT_COUPON => '用券',

    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video_chapter}}';
    }


}
