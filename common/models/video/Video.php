<?php

namespace common\models\video;

use common\behaviors\UploadBehavior;
use common\models\traits\ChannelInterface;
use common\models\traits\ChannelTrait;
use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%video}}".
 *
 * @property int $id 系列id
 * @property int $channel_id 频道id
 * @property string $category_ids 类别ids ,拼接
 * @property string $publish_clients 发布端 ,拼接
 * @property string $title 标题
 * @property string $source 来源
 * @property int $type 视频类型 1单集 2连续集
 * @property int $area 地区
 * @property int $year 年代
 * @property string $description 作品简介
 * @property string $keywords 关键词 以|拼接
 * @property int $score 评分 0~100
 * @property int $issue_date 上架日期
 * @property string $cover 封面地址
 * @property string $horizontal_cover 横版封面
 * @property int $episode_num 剧集数
 * @property int $total_views 总浏览
 * @property int $total_favors 总收藏
 * @property int $likes_num 点赞数
 * @property int $status 状态 1上架 2下架
 * @property int $is_finished 是否完结 1已完结 0更新中
 * @property int $is_sensitive 是否敏感 1敏感
 * @property int $play_limit 播放限制
 * @property int $is_down 是否可下载，1可下载，0不可下载
 * @property int $total_price 总价格
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class Video extends \xiang\db\ActiveRecord implements StatusToggleInterface,ChannelInterface
{
    use ChannelTrait;
    use StatusToggleTrait;

    const IS_DOWN_YES = 1;
    const IS_DOWN_NO  = 0;

    const STATUS_FINISHED = 1;
    const STATUS_SERIAL   = 2;

    const STATUS_SIMPLE     = 1;
    const STATUS_CONTINUOUS = 2;

    public static $finishedStatus = [
        self::STATUS_FINISHED => '已完结',
        self::STATUS_SERIAL   => '更新中',
    ];

    public static $typeStatus = [
        self::STATUS_SIMPLE     => '单集',
        self::STATUS_CONTINUOUS => '连续集',
    ];

    public static $isDownMap = [
        self::IS_DOWN_YES => '可下载',
        self::IS_DOWN_NO  => '不可下载'
    ];

    public static $statusMap = [
        self::STATUS_ENABLED => '上架',
        self::STATUS_DISABLED => '下架'
    ];

    // 播放限制条件
    const PLAY_LIMIT_FREE   = 1;
    const PLAY_LIMIT_VIP    = 2;
    const PLAY_LIMIT_COUPON = 3;

    public static $playLimitMap = [
        self::PLAY_LIMIT_FREE   => '免费', // 免费
//        self::PLAY_LIMIT_VIP    => 'VIP',
        self::PLAY_LIMIT_COUPON => '用券',

    ];

    //是否敏感
    const SENSITIVITY_NO  = 1; //不敏感
    const SENSITIVITY_YES = 2; //敏感

    public static $sensitivityMap = [
        self::SENSITIVITY_NO  => '不敏感',
        self::SENSITIVITY_YES => '敏感'
    ];

    //封面尺寸
    const ADMIN_COVER_WIDTH = 150;
    const ADMIN_COVER_HEIGHT = 200;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video}}';
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
                'cover' => [ //竖封面
                    'extensions' => UploadBehavior::$imageExtensions,
                    'maxSize'    => 1024 * 1024 * 1024, // 1M
                    'required'   => true,
                    'dir'        => 'video/cover/' . date('Ymd'),
                ],
                'horizontal_cover' => [ //横封面
                    'extensions' => UploadBehavior::$imageExtensions,
                    'maxSize'    => 1024 * 1024 * 1024, // 1M
                    'required'   => true,
                    'dir'        => 'video/horizontal_cover/' . date('Ymd'),
                ],
            ],
        ];

        return $behaviors;
    }

}
