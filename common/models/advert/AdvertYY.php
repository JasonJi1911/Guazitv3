<?php

namespace common\models\advert;

use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%advert_yy_title}}".
 *
 * @property int $id id
 * @property int $yy_id advert_yy_title表对应id
 * @property String $title 广告标题
 * @property String $url 广告跳转链接
 * @property int $display_order 排序
 * @property int $status 状态（1-显示，2-隐藏）
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class AdvertYY extends \xiang\db\ActiveRecord implements StatusToggleInterface
{
    use StatusToggleTrait;

    // 状态
    public static $statusMap = [
        self::STATUS_ENABLED => '显示',
        self::STATUS_DISABLED => '隐藏'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%advert_yy}}';
    }


}
