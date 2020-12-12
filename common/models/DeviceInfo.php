<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%device_info}}".
 *
 * @property int $device_id 设备ID
 * @property int $uid
 * @property int $os_type 1:ios,2:android
 * @property string $udid ios:UDID,android:imei
 * @property string $ali_device_id 阿里推送设备
 * @property string $sysver 系统版本
 * @property string $ver 客户端版本
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $last_visit_time 最后访问时间
 */
class DeviceInfo extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%device_info}}';
    }


}
