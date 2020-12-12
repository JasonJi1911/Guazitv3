<?php

namespace common\models\setting;

use Yii;

/**
 * This is the model class for table "{{%setting_log}}".
 *
 * @property int $id
 * @property int $admin_id 操作人id
 * @property string $route 操作路由
 * @property string $content 修改内容
 * @property string $ip ip地址
 * @property int $created_at
 */
class SettingLog extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting_log}}';
    }
}
