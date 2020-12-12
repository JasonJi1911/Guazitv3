<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "{{%user_auth_app}}".
 *
 * @property int $id
 * @property int $uid 用户uid
 * @property string $openid 用户唯一标识
 * @property string $unionid 联合唯一标识
 * @property string $name 用户名称
 * @property string $avatar 头像
 * @property int $type 类型，1：微信，2 qq
 * @property int $app_id app id
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class UserAuthApp extends \xiang\db\ActiveRecord
{
    const TYPE_WECHAT = 1; // 微信
    const TYPE_QQ     = 2; // QQ

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_auth_app}}';
    }
}
