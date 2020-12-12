<?php

namespace common\models\video;

use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%recommend}}".
 *
 * @property int $id id
 * @property int $channel_id 频道id
 * @property string $title 栏目标题名
 * @property string $search 检索项json字符串
 * @property string $description 描述
 * @property int $style 样式
 * @property int $display_order 展示排序
 * @property int $status 上架状态 1上架 2下架
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class Recommend extends \xiang\db\ActiveRecord implements StatusToggleInterface
{
    use StatusToggleTrait;

    // 首页lable四种样式,
    const STYLE_1 = 1; // 竖排6个
    const STYLE_2 = 2; // 竖排6个横排1个
    const STYLE_3 = 3; // 横排7个
    const STYLE_4 = 4; // 横排6个
    const STYLE_5 = 5; // 竖排滑动

    public static $styleMap = [
        self::STYLE_1 => '竖排6个',
        self::STYLE_2 => '竖排6个横排1个',
        self::STYLE_3 => '横排7个',
        self::STYLE_4 => '横排6个',
        self::STYLE_5 => '竖排滑动',
    ];

    public static $selectLimit = [
        self::STYLE_1 => 6,
        self::STYLE_2 => 7,
        self::STYLE_3 => 7,
        self::STYLE_4 => 6,
        self::STYLE_5 => 15,

    ];

    public static $statusMap = [
        self::STATUS_ENABLED => '上架',
        self::STATUS_DISABLED=> '下架'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%recommend}}';
    }


}
