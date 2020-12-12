<?php
namespace admin\models\apps;

class Apps extends \common\models\apps\Apps
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['package_name', 'status'], 'required'],
            [['status', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['package_name', 'icon'], 'string', 'max' => 256],
            [['channel', 'share_link'], 'string', 'max' => 512],
            [['description'], 'string', 'max' => 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'app_id' => 'App ID',
            'name' => 'app名称',
            'package_name' => 'Package Name',
            'icon' => 'icon',
            'channel' => '渠道信息',
            'status' => '状态',
            'description' => '描述',
            'share_link' => '分享链接',
            'package_name' => '包名',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
