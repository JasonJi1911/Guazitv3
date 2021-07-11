<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%video_favorite}}".
 *
 * @property int $id 自增id
 * @property int $video_id 视频id
 * @property int $chapter_id 分集id
 * @property int $source_id 线路id
 * @property string $reason 报错原因
 * @property string $ip 客户ip
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class VideoFeed extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const REASON_NO_SCEEN = 1;
    const REASON_SLOW = 2;


    public static $reasons = [
        self::REASON_NO_SCEEN => '视频加载不出来',
        self::REASON_SLOW  => '视频卡顿'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video_feed}}';
    }


}
