<?php

namespace common\models\video;

use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%rank}}".
 *
 * @property int $id
 * @property int $channel_id 频道id
 * @property string $title 排行榜题名
 * @property int $status 状态，1正常，2下线
 * @property string $description 排行榜描述
 * @property int $display_order 排行榜展示排序
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class Rank extends \xiang\db\ActiveRecord implements StatusToggleInterface
{
    use StatusToggleTrait;

    /**
     * @var array 状态
     */
    public static $statuses = [
        self::STATUS_ENABLED  => '正常',
        self::STATUS_DISABLED => '下线',
    ];

    const TYPE_WEEK  = 1;
    const TYPE_MONTH = 2;
    const TYPE_TOTAL = 3;

    public static $rankType = [
        self::TYPE_WEEK  => '周榜',
        self::TYPE_MONTH => '月榜',
        self::TYPE_TOTAL => '总榜',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%rank}}';
    }


}
