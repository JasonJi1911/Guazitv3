<?php

namespace common\models\advert;

use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%advert_yy_title}}".
 *
 * @property int $id id
 * @property String $title 标题
 * @property int $city_id 状态（1-开启，2-关闭）
 * @property int $display_order 排序
 * @property int $status 状态（1-显示，2-隐藏）
 * @property int $product 产品线 1App 2wap 3PC
 * @property string $platform 平台-播放平台(RY/GZ)
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class AdvertYYTitle extends \xiang\db\ActiveRecord implements StatusToggleInterface
{
    use StatusToggleTrait;

    // 状态
    public static $statusMap = [
        self::STATUS_ENABLED => '显示',
        self::STATUS_DISABLED => '隐藏'
    ];

    const PRODUCT_ALL     = 0;
    const PRODUCT_APP     = 1;
    const PRODUCT_WAP     = 2;
    const PRODUCT_PC      = 3;

    public static $productMap=[
        self::PRODUCT_ALL        => '全部',
        self::PRODUCT_APP        => 'App端',
        self::PRODUCT_WAP         => 'Wap端',
        self::PRODUCT_PC        => 'PC端',
    ];

    const PLATFORM_GZ = 'GZ'; // 瓜子
    const PLATFORM_RY = 'RY'; // 如意
    public static $platformmap=[
        self::PLATFORM_GZ        => '瓜子',
        self::PLATFORM_RY        => '如意',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%advert_yy_title}}';
    }


}
