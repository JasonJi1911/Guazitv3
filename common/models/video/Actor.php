<?php

namespace common\models\video;

use common\behaviors\UploadBehavior;
use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%actor}}".
 *
 * @property int $actor_id 主演id
 * @property string $actor_name 主演名
 * @property string $avatar 头像
 * @property int $weight 权重 值越大越靠前
 * @property int $type 类型，1演员，2导演
 * @property int $area_id 地域
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class Actor extends \xiang\db\ActiveRecord implements StatusToggleInterface
{
    use StatusToggleTrait;

    const TYPE_ACTOR      = 1;    //演员
    const TYPE_DIRECTOR   = 2;    //导演

    public static $actionMap = [
        self::TYPE_ACTOR      => '演员',
        self::TYPE_DIRECTOR   => '导演',
    ];

    public static $statuses = [
        self::STATUS_ENABLED  => '演员',
        self::STATUS_DISABLED => '导演',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%actor}}';
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['upload'] = [
            'class'  => UploadBehavior::className(),
            'config' => [
                'avatar' => [
                    'extensions' => UploadBehavior::$imageExtensions,
                    'maxSize'    => 1024 * 1024 , // 1M
                    'required'   => true,
                    'dir'        => 'video/actor_avatar/'. date('Ym'),
                ]
            ],
        ];

        return $behaviors;
    }
}
