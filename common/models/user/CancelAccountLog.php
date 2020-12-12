<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "{{%cancel_account_log}}".
 *
 * @property int $id
 * @property int $uid 用户uid
 * @property int $status 状态0-待处理，1-已打款，2-已驳回
 * @property string $remark 备注
 * @property int $admin_id 审核id
 * @property int $extract_at 审核时间
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class CancelAccountLog extends \xiang\db\ActiveRecord
{
    // 状态
    const STATUS_HANDLE  = 0;
    const STATUS_CONFIRM = 1;
    const STATUS_REJECT  = 2;

    /**
     * @var array 状态
     */
    public static $statuses = [
        self::STATUS_HANDLE  => '待处理',
        self::STATUS_CONFIRM => '已注销',
        self::STATUS_REJECT  => '已驳回',
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cancel_account_log}}';
    }

}
