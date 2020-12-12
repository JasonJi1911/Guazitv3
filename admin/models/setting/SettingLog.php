<?php
namespace admin\models\setting;

use admin\models\Admin;

class SettingLog extends \common\models\setting\SettingLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['admin_id', 'created_at'], 'integer'],
            [['route'], 'string', 'max' => 256],
            [['content'], 'string', 'max' => 2048],
            [['ip'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_id' => 'Admin ID',
            'route' => 'Route',
            'content' => 'Content',
            'ip' => 'Ip',
            'created_at' => 'Created At',
        ];
    }

    public function getAdminName()
    {
        $admin = Admin::findOne($this->admin_id);
        return $admin->username;
    }
}