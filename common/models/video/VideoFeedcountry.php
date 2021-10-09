<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%video_feedcountry}}".
 *
 * @property int $id
 * @property string $country_name 国家名称
 * @property int $display_order 排序
 * @property string $mobile_areacode 手机区号
 * @property int $created_at 添加时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class VideoFeedcountry extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video_feedcountry}}';
    }

}
