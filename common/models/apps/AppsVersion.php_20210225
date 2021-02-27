<?php

namespace common\models\apps;

use Yii;

/**
 * This is the model class for table "{{%apps_version}}".
 *
 * @property int $id
 * @property int $app_id
 * @property string $ver_sn 版本号
 * @property int $os_type 端类型1-iOS 2-Android
 * @property string $content 更新文案
 * @property int $online_time 上架时间
 * @property int $force_update 是否强制更新 0不是 1是
 * @property int $is_release 是否发布 1-发布 0-未发布
 * @property int $created_at 创建时间
 * @property int $updated_at 修改时间
 */
class AppsVersion extends \xiang\db\ActiveRecord
{
    
    // 系统类型
    const OS_TYPE_IOS = 1;
    const OS_TYPE_ANDROID = 2;
    public static $osType = [
        self::OS_TYPE_IOS => '苹果',
        self::OS_TYPE_ANDROID => '安卓',
    ];

    // 是否强制更新
    const FORCE_UPDATE_YES = 1;
    const FORCE_UPDATE_NOT = 0;
    public static $forceUpdate = [
        self::FORCE_UPDATE_YES => '是',
        self::FORCE_UPDATE_NOT => '否',
    ];

    // 是否发布
    const RELEASE_OFF= 0;
    const RELEASE_ON = 1;
    public static $release = [
        self::RELEASE_OFF => '未发布',
        self::RELEASE_ON  => '已发布',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%apps_version}}';
    }
}
