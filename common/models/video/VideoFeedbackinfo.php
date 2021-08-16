<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%video_feedbackinfo}}".
 *
 * @property int $id 序号id
 * @property string $message 信息
 * @property int $type 1-上网环境；2-使用设备系统；3-浏览器
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 * @property int $deleted_at 删除时间
 */
class VideoFeedbackinfo extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video_feedbackinfo}}';
    }

}
