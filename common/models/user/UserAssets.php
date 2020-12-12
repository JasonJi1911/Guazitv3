<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "{{%user_assets}}".
 *
 * @property int $uid 用户uid
 * @property int $score_remain 剩余积分
 * @property int $total_score 累计获得积分
 * @property int $coupon_remain 剩余卡券
 * @property int $total_coupon 累计卡券
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class UserAssets extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_assets}}';
    }
}
