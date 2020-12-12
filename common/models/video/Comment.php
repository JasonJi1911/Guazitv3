<?php

namespace common\models\video;

use common\helpers\RedisKey;
use common\helpers\Tool;
use common\models\traits\SourceInterface;
use common\models\traits\SourceTrait;
use Yii;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property int $id
 * @property int $uid 评论用户ID
 * @property int $video_id 视频系列id
 * @property int $chapter_id 视频id
 * @property int $pid 父级ID
 * @property string $content 评论内容
 * @property int $likes_num 点赞数
 * @property int $source 来源
 * @property int $status 状态 0审核中 1通过
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class Comment extends \xiang\db\ActiveRecord implements SourceInterface
{
    use SourceTrait;

    const STATUS_EXAMINE_ING = 0;
    const STATUS_EXAMINE_YES = 1;

    public static $statues = [
        self::STATUS_EXAMINE_ING => '待审核',
        self::STATUS_EXAMINE_YES => '已通过',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    public function afterSave($insert, $changedAttributes)
    {
        // 清理缓存
        Tool::batchClearCache(sprintf(RedisKey::VIDEO_COMMENT, $this->video_id));
        parent::afterSave($insert, $changedAttributes);
    }
}
