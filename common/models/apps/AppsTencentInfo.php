<?php

namespace common\models\apps;

use Yii;

/**
 * This is the model class for table "{{%apps_wechat_info}}".
 *
 * @property int $id
 * @property int $app_id
 * @property string $wechat_app_id
 * @property string $wechat_app_secret
 * @property int $created_at
 * @property int $updated_at
 */
class AppsTencentInfo extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%apps_tencent_info}}';
    }
    
}
