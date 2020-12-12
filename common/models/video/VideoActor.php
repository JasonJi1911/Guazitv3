<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%video_actor}}".
 *
 * @property int $id
 * @property int $video_id 视频id
 * @property int $actor_id 演员id
 * @property int $display_order
 * @property int $created_at 创建时间
 */
class VideoActor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video_actor}}';
    }


}
