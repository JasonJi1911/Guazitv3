<?php
namespace admin\models\setting;

class SettingOss extends \common\models\setting\SettingOss
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['save_type'], 'integer'],
            [['bucket'], 'string', 'max' => 128],
            [['server_point'], 'string', 'max' => 256],
            [['bucket', 'server_point'], 'trim']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'save_type' => '存储类型',
            'bucket' => '存储空间名',
            'server_point' => '节点域名',
        ];
    }
}
