<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "{{%user_vip}}".
 *
 * @property int $uid
 * @property int $start_time vip开始时间
 * @property int $continue_time 续购时间
 * @property int $end_time vip到期时间
 * @property int $status 1正常 2过期
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class UserVip extends \xiang\db\ActiveRecord
{
    //状态
    const STATUS_NORMAL = 1;
    const STATUS_EXPIRE = 2;

    public static $statusMap = [
        self::STATUS_NORMAL => '会员',
        self::STATUS_EXPIRE => '非会员'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_vip}}';
    }

    /**
     * 获取用户vip状态,用于开通会员时使用
     * @param $uid
     * @return UserVip|null|static
     */
    public static function getUserVip($uid) {
        $objUserVip = UserVip::findOne(['uid' => $uid]);
        if (empty($objUserVip)) {
            $objUserVip = new self();
            $objUserVip->uid = $uid;
        }

        return $objUserVip;
    }
}
