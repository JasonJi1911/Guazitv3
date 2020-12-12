<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "{{%sign_log}}".
 *
 * @property int $id
 * @property int $uid 用户ID
 * @property string $trade_no 交易号
 * @property int $date 签到日期
 * @property int $year_month 签到年月
 * @property int $sign_days 连续签到天数
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class SignLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sign_log}}';
    }


}
