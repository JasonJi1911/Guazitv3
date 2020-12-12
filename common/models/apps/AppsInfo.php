<?php

namespace common\models\apps;

use Yii;

/**
 * This is the model class for table "{{%apps_info}}".
 *
 * @property int $app_id appid
 * @property string $name app名称
 * @property string $package_name 包名
 * @property string $icon icon
 * @property string $channel 渠道信息
 * @property string $description 描述
 * @property int $status 状态
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
class AppsInfo extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%apps_info}}';
    }

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
