<?php

namespace common\models\advert;

use common\behaviors\UploadBehavior;

use common\models\traits\SourceInterface;
use common\models\traits\SourceTrait;
use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%start_page}}".
 *
 * @property int $id id
 * @property string $title 标题
 * @property int $skip_type 跳转类型（1-内部跳转-书籍，2-外部跳转链接，3-内部跳转-漫画）
 * @property string $image 图片地址
 * @property string $content 内容
 * @property string $ad_key ios广告key
 * @property string $ad_android_key android广告key
 * @property int $status 状态（1-上线，2-下线）
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class StartPage extends \xiang\db\ActiveRecord implements StatusToggleInterface,SourceInterface
{
    use SourceTrait;
    use StatusToggleTrait;

    // 跳转类型
    const SKIP_TYPE_VIDEO       = 1; // 内部跳转影视作品
    const SKIP_TYPE_WEB         = 2; // 外部跳转链接
    const SKIP_TYPE_BROWSER     = 3; // 浏览器打开链接
    // 广告类型
    const AD_TYPE_CHUANSHANJIA  = 4; // 穿山甲广告



    /**
     * @var array 跳转类型
     */
    public static $skipTypeMap = [
        self::SKIP_TYPE_VIDEO      => 'APP打开影视作品',
        self::SKIP_TYPE_WEB        => 'APP内打开链接',
        self::SKIP_TYPE_BROWSER    => '浏览器打开链接',

        self::AD_TYPE_CHUANSHANJIA => '穿山甲广告',

    ];

    /**
     * 状态数组
     */
    public static $statusMap = [
        self::STATUS_ENABLED  => '显示',
        self::STATUS_DISABLED => '隐藏',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%start_page}}';
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
                'image' => [
                    'extensions' => UploadBehavior::$imageExtensions,
                    'maxSize'    => 1024 * 1024 , // 1M
                    'required'   => true,
                    'dir'        => 'video/start_image/',
                ]
            ],
        ];

        return $behaviors;
    }
}
