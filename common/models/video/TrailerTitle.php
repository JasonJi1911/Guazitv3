<?php

namespace common\models\video;

use common\models\traits\SchemeTrait;
use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%trailer_title}}".
 *
 * @property int $id 序号id
 * @property int $channel_id 视频id
 * @property string $title 标题
 * @property string $content 副标题
 * @property int $display_order 排序
 * @property int $status 状态：1-显示，2-隐藏
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 * @property int $deleted_at 删除时间
 */
class TrailerTitle extends \xiang\db\ActiveRecord implements StatusToggleInterface
{
    use StatusToggleTrait , SchemeTrait;

    public static $statusMap = [
        self::STATUS_ENABLED  => '显示',
        self::STATUS_DISABLED => '隐藏',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%trailer_title}}';
    }

}