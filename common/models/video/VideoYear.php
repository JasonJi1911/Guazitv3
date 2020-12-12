<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%video_year}}".
 *
 * @property int $id 年代id
 * @property string $year 年代
 * @property string $description 描述
 * @property int $created_at 创建时间
 * @property int $display_order 排序
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class VideoYear extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video_year}}';
    }


}
