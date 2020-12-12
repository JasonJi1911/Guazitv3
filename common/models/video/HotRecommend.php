<?php

namespace common\models\video;

use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "sf_hot_recommend".
 *
 * @property string $recommend_id
 * @property string $title 标题
 * @property string $display_order 排序
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class HotRecommend extends \xiang\db\ActiveRecord implements StatusToggleInterface
{
    use StatusToggleTrait;

    public static $statusMap = [
        self::STATUS_ENABLED  => '显示',
        self::STATUS_DISABLED => '隐藏',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hot_recommend}}';
    }


}
