<?php

namespace admin\models\apps;

use common\models\apps\AppsCheckSwitch;

class AppsVersion extends \common\models\apps\AppsVersion
{
    public $upload_file;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['online_time'], 'datetime', 'timestampAttribute' => 'online_time'],
            [['ver_sn', 'content'], 'required'],
            [['app_id','os_type', 'force_update', 'is_release', 'created_at', 'updated_at'], 'integer'],
            [['content'], 'string'],
            [['ver_sn'], 'string', 'max' => 32],
            [['ver_sn'], 'match', 'pattern' => '/^[0-9]{0}([0-9]|[.])+[0-9]$/', 'message'=>'版本号不符合规则'],
//            [['file_path'], 'string', 'max' => 128],
            [['ver_sn', 'os_type'], 'unique', 'targetAttribute' => ['ver_sn', 'os_type'], 'message' => '系统版本重复！'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app_id' => 'App ID',
            'ver_sn' => '版本号',
            'file_path' => 'File Path',
            'os_type' => '端类型',
            'content' => '更新文案',
            'online_time' => '上架时间',
            'force_update' => '是否强制更新',
            'is_release' => '是否发布',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    public function beforeDelete()
    {
        //删除版本对应渠道信息
        AppsCheckSwitch::deleteAll(['version_id' => $this->id]);

        return parent::beforeDelete();
    }
}