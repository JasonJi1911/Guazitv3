<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "{{%sign_status}}".
 *
 * @property int $id
 * @property int $uid 用户ID
 * @property int $sign_days 连续签到次数
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class SignStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sign_status}}';
    }


}
