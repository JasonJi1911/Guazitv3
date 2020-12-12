<?php

namespace common\models\apps;

use Yii;

/**
 * This is the model class for table "{{%setting_alipay}}".
 *
 * @property int $id
 * @property int $app_id
 * @property string $alipay_app_id APPID
 * @property string $alipay_public_key 支付宝公钥
 * @property string $rsa_private_key 商户私钥
 * @property int $created_at
 * @property int $updated_at
 */
class AppsAlipay extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%apps_alipay}}';
    }
}
