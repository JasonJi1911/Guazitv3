<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%topic_video}}".
 *
 * @property int $id
 * @property int $topic_id 专题id
 * @property int $video_id 视频系列id
 * @property int $display_order 展示排序
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class TopicVideo extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%topic_video}}';
    }


}
