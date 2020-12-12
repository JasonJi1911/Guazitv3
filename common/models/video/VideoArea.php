<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%video_area}}".
 *
 * @property int $id 地区id
 * @property string $area 地区
 * @property string $description 描述
 * @property int $display_order 展示排序
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class VideoArea extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video_area}}';
    }

}
