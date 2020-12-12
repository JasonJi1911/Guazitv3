<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "sf_hot_recommend_list".
 *
 * @property string $id
 * @property int $recommend_id
 * @property int $video_id
 * @property string $display_order
 * @property string $created_at
 * @property string $updated_at
 */
class HotRecommendList extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hot_recommend_list}}';
    }


}
