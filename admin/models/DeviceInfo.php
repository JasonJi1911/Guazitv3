<?php
namespace admin\models;

class DeviceInfo extends \common\models\DeviceInfo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'os_type', 'created_at', 'updated_at', 'last_visit_time'], 'integer'],
            [['udid', 'sysver', 'ver'], 'string', 'max' => 64],
            [['ali_device_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'device_id' => 'Device ID',
            'uid' => 'Uid',
            'os_type' => 'Os Type',
            'udid' => 'Udid',
            'ali_device_id' => 'Ali Device ID',
            'sysver' => 'Sysver',
            'ver' => 'Ver',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'last_visit_time' => 'Last Visit Time',
        ];
    }
}