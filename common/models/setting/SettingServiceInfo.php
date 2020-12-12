<?php

namespace common\models\setting;

use Yii;

/**
 * This is the model class for table "{{%setting_service_info}}".
 *
 * @property int $id
 * @property string $qq qq
 * @property string $email
 * @property string $telphone
 * @property string $company
 * @property string $wechat
 */
class SettingServiceInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%setting_service_info}}';
    }
}
