<?php

namespace common\models\apps;

use Yii;

/**
 * This is the model class for table "{{%apps_message}}".
 *
 * @property int $id
 * @property int $app_id
 * @property int $message_type 短信类型
 * @property string $ali_sign_name 阿里短信签名
 * @property string $ali_verify_code 阿里短信模板CODE
 * @property string $yun_account_id 云之讯账号id
 * @property string $yun_token 云之讯账号token
 * @property string $yun_app_id 云之讯账号APP ID
 * @property string $yun_template_id 云之讯模板id
 */
class AppsMessage extends \yii\db\ActiveRecord
{

    const MESSAGE_ALIYUN    = 1;
    const MESSAGE_YUNZHIXUN = 2;

    public static $messageType = [
        self::MESSAGE_ALIYUN  => 'aliyun',
        self::MESSAGE_YUNZHIXUN => '云之讯',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%apps_message}}';
    }
}
