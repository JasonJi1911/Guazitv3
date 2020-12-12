<?php

namespace common\models\apps;

use common\models\traits\SourceInterface;
use common\models\traits\SourceTrait;
use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%push_passageway}}".
 *
 * @property int $id
 * @property string $name 通道名称
 * @property string $p_key 通道key
 * @property string $app_id app id
 * @property string $app_key app key
 * @property string $app_secret app secret
 * @property int $status 状态（1-开启，2-关闭）
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class PushPassageway extends \xiang\db\ActiveRecord implements StatusToggleInterface, SourceInterface
{
    use SourceTrait;
    use StatusToggleTrait;

    /**
     * @var array 状态
     */
    public static $statuses = [
        self::STATUS_ENABLED  => '开启',
        self::STATUS_DISABLED => '关闭'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%push_passageway}}';
    }


}
