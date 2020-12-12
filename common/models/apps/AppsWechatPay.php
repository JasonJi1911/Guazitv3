<?php

namespace common\models\apps;

use Yii;

/**
 * This is the model class for table "{{%apps_wechat_pay}}".
 *
 * @property int $id
 * @property int $app_id
 * @property string $wechat_app_id 开放平台id
 * @property string $mch_id 商户号
 * @property string $api_sec_key 秘钥
 * @property int $created_at
 * @property int $updated_at
 */
class AppsWechatPay extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%apps_wechat_pay}}';
    }
}
