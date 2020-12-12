<?php
namespace admin\models\apps;

class AppsInfo extends \common\models\apps\AppsInfo
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
            [['channel'], 'string', 'max' => 512],
            [['description'], 'string', 'max' => 1024],
            [['package_name'], 'trim']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'app_id' => 'appid',
            'name' => 'app名称',
            'package_name' => '包名',
            'icon' => 'icon',
            'channel' => '渠道信息',
            'description' => '描述',
            'status' => '状态',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }


}
