<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%video_seek}}".
 *
 * @property int $id 序号id
 * @property string $video_name 片名
 * @property int $channel_id 频道id
 * @property int $area_id 地区id
 * @property string $year 年代
 * @property string $director_name 导演名称
 * @property string $actor_name 演员名称
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 * @property int $deleted_at 删除时间
 */
class VideoSeek extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video_seek}}';
    }

}
