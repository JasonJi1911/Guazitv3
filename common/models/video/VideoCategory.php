<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%video_category}}".
 *
 * @property int $id 分类id
 * @property int $channel_id 频道id
 * @property string $title 分类名
 * @property string $description 分类描述
 * @property int $display_order 分类展示排序
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class VideoCategory extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video_category}}';
    }

}
