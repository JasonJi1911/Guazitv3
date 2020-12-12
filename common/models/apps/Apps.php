<?php

namespace common\models\apps;

use common\behaviors\UploadBehavior;
use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%apps_info}}".
 *
 * @property int $app_id appid
 * @property string $name app名称
 * @property string $package_name 包名
 * @property string $icon icon
 * @property string $channel 渠道信息
 * @property int $status 状态
 * @property string $description 描述
 * @property string $share_link 描述
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
class Apps extends \yii\db\ActiveRecord implements StatusToggleInterface
{
    use StatusToggleTrait;

    public static $statuses = [
        self::STATUS_ENABLED => '开启',
        self::STATUS_DISABLED => '关闭'
    ];
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%apps_info}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['upload'] = [
            'class'  => UploadBehavior::className(),
            'config' => [
                'icon' => [ //竖封面
                    'extensions' => UploadBehavior::$imageExtensions,
                    'maxSize'    => 1024 * 1024 , // 100K
                    'required'   => false,
                    'dir'        => 'apps-info/icon/'. date('Ym') .'/',
                ],
            ],
        ];

        return $behaviors;
    }
}
