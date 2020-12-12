<?php

namespace common\models\stat;

use Yii;

/**
 * This is the model class for table "{{%user_stat}}".
 *
 * @property int $id
 * @property int $date 日期
 * @property int $android_incr 安卓新增
 * @property int $apple_incr 苹果新增
 * @property int $total_incr 总新增
 * @property int $day_active 日活用户
 * @property int $recharge_incr 充值新增
 * @property int $recharge_total 总充值用户
 * @property int $vip_incr 新增vip
 * @property int $vip_total 总vip用户
 * @property int $created_at
 * @property int $updated_at
 */
class UserStat extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_stat}}';
    }


}
