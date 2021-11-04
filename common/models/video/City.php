<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%video_feedcountry}}".
 *
 * @property int $id
 * @property string $city_code 三字码
 * @property string $city_name 城市
 * @property int $country_id 国家id(对应video_feedcountry)
 * @property int $created_at 添加时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class City extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%city}}';
    }

}
