<?php

namespace common\models\apps;

use Yii;

/**
 * This is the model class for table "sf_apps_check_switch".
 *
 * @property string $id
 * @property string $version_id 版本ID
 * @property string $channel 渠道
 * @property string $label 渠道名称
 * @property int $status 0:关，1开
 * @property string $file_path 文件地址
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class AppsCheckSwitch extends \xiang\db\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON  = 1;
    public static $statues = [
        self::STATUS_OFF => '正常',
        self::STATUS_ON  => '审核中',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sf_apps_check_switch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['version_id', 'status', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['channel', 'label', 'file_path'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'version_id' => 'Version ID',
            'channel' => 'Channel',
            'label' => '渠道名称',
            'status' => 'Status',
            'file_path' => 'File Path',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }


    public static function getChannelUrl()
    {
        $where = ['<>', 'file_path', ''];
        $order = 'version_id desc';
        $iosChannel = self::find()->andWhere(['channel' => 'ios'])->andWhere($where)->orderBy($order)->one();
        $data[\admin\models\apps\AppsVersion::OS_TYPE_IOS] = $iosChannel ? $iosChannel->file_path : Yii::$app->setting->get('appInfo.ios_down_url');
        $androidChannel = self::find()->andWhere(['<>', 'channel', 'ios'])->andWhere($where)->orderBy($order)->one();
        $data[\admin\models\apps\AppsVersion::OS_TYPE_ANDROID] = $androidChannel ? $androidChannel->file_path : Yii::$app->setting->get('appInfo.android_down_url');

        return $data;
    }
}
