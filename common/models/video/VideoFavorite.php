<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%video_favorite}}".
 *
 * @property int $id 自增id
 * @property int $uid 用户uid
 * @property int $video_id 视频系列id
 * @property int $status 状态：1收藏，2：取消收藏
 * @property int $created_at 创建时间
 */
class VideoFavorite extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const STATUS_YES = 1;
    const STATUS_NO = 0;


    public static $status = [
        self::STATUS_YES => '已收藏',
        self::STATUS_NO  => '未收藏'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video_favorite}}';
    }


}
