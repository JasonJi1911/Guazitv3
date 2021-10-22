<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%video_feedback}}".
 *
 * @property int $id 序号id
 * @property int $uid 用户id
 * @property int $video_id 视频id
 * @property int $chapter_id 分集id
 * @property int $source_id 线路id
 * @property string $country 国家
 * @property int $internets 上网环境id
 * @property int $systems 设备、系统id
 * @property int $browsers 浏览器id
 * @property string $description 问题描述
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 * @property int $deleted_at 删除时间
 */
class VideoFeedback extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video_feedback}}';
    }

}
