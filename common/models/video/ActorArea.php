<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%actor_area}}".
 *
 * @property int $id
 * @property string $area 地域名称
 * @property int $display_order 排序
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
class ActorArea extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%actor_area}}';
    }

}
