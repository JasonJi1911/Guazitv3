<?php

namespace common\models\video;

use common\behaviors\UploadBehavior;
use common\models\traits\SchemeTrait;
use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%banner}}".
 *
 * @property int $id banner id
 * @property int $channel_id 频道id
 * @property string $title 标题
 * @property string $image banner图地址
 * @property int $action 动作类型 1跳作品 2scheme跳转 3App打开url 4浏览器打开url
 * @property string $content 内容
 * @property int $display_order 展示顺序
 * @property int $product 产品线 1App 2wap 3PC
 * @property int $status 状态，1显示 2隐藏
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class Banner extends \xiang\db\ActiveRecord implements StatusToggleInterface
{
    use StatusToggleTrait , SchemeTrait;

    const PROMPT = 0;
    //图片尺寸
    const ADMIN_BOOK_BANNER_WIDTH = 200;
    const ADMIN_BOOK_BANNER_HEIGHT = 120;
    const API_BOOK_BANNER_WIDTH = 500;
    const API_BOOK_BANNER_HEIGHT = 300;

    const ACTION_VIDEO       = 1; // 作品
    const ACTION_SCHEME      = 2; // APP页面
    const ACTION_URL         = 3; // 内部url
    const ACTION_BROWSER_URL = 4; // 浏览器打开页面

    const SOURCE_ALL     = 0;
    const SOURCE_APP     = 1;
    const SOURCE_WAP     = 2;
    const SOURCE_PC      = 3;

    public static $actionMap = [
        self::ACTION_VIDEO       => '作品详情页',
        self::ACTION_SCHEME      => 'APP页面',
        self::ACTION_URL         => '跳转链接',
        self::ACTION_BROWSER_URL => '浏览器打开链接',
    ];

    public static $sourceBanner=[
        self::SOURCE_ALL        => '全部',
        self::SOURCE_APP        => 'App端',
        self::SOURCE_WAP         => 'Wap端',
        self::SOURCE_PC        => 'Pc端',
    ];

    public static $statusMap = [
        self::STATUS_ENABLED  => '显示',
        self::STATUS_DISABLED => '隐藏',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%banner}}';
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
                'image' => [ //竖封面
                    'extensions' => UploadBehavior::$imageExtensions,
                    'maxSize'    => 1024 * 1024 , // 100K
                    'required'   => true,
                    'dir'        => 'video/banner/'. date('Ym'),
                ]
            ],
        ];

        return $behaviors;
    }
}
