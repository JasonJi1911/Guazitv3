<?php
namespace api\models\user;

class UserAssets extends \common\models\user\UserAssets
{
    public function fields()
    {
        return [
            'score_remain',
            'coupon_remain',
            'total_coupon'
        ];
    }

    /**
     * 查询用户财富
     * @param $uid
     * @return UserAssets|array|bool|null|\yii\db\ActiveRecord|static
     */
    public static function getUserAssets($uid) {
        if (empty($uid)) {
            return false;
        }

        $objUserAssets = self::findOne(['uid' => $uid]);

        if (empty($objUserAssets)) {
            $objUserAssets = new self();
            $objUserAssets->uid = $uid;
        }

        return $objUserAssets;
    }
}
