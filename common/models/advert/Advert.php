<?php

namespace common\models\advert;


use common\behaviors\UploadBehavior;
use common\models\traits\SourceInterface;
use common\models\traits\SourceTrait;
use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%advert}}".
 *
 * @property int $id id
 * @property int $position_id 广告位置ID
 * @property int $ad_type 广告类型
 * @property string $title 标题
 * @property string $image 图片地址
 * @property int $width 宽
 * @property int $height 高
 * @property string $skip_url 跳转地址
 * @property int $url_type 链接类型（1-外部链接，2内部链接）
 * @property string $ad_key ios广告key
 * @property string $ad_android_key android广告key
 * @property int $pv pv量
 * @property int $click 点击量
 * @property int $status 状态（1-开启，2-关闭）
 * @property int $city_id 城市id
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class Advert extends \xiang\db\ActiveRecord implements StatusToggleInterface,SourceInterface
{
    use SourceTrait;
    use StatusToggleTrait;

    // 链接类型
    const TYPE_INSIDE = 1; // 内部跳转
    const TYPE_OUTSIDEO = 2; // 外部跳转
    public static $urlTypes = [
        self::TYPE_INSIDE => '内部跳转',
        self::TYPE_OUTSIDEO => '外部跳转'
    ];


    // 状态
    const STATUS_OPEN = 1; // 开启
    const STATUS_CLOSE = 2; // 关闭
    public static $statusMap= [
        self::STATUS_OPEN => '开启',
        self::STATUS_CLOSE => '关闭'
    ];

    // 广告类型
    const AD_TYPE_WEB = 1; // web广告
    const AD_TYPE_CHUANSHANJIA = 2; // 穿山甲广告
    const AD_TYPE_GOOGLE = 3; // google广告
    const AD_TYPE_GUANGDIANTONG = 4; // 广点通广告
    public static $adTypes = [
        self::AD_TYPE_WEB => 'web广告',
        self::AD_TYPE_CHUANSHANJIA => '穿山甲广告',
        self::AD_TYPE_GOOGLE => 'google广告',
        self::AD_TYPE_GUANGDIANTONG => '广点通广告',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%advert}}';
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
                    'maxSize'    => 1024 * 1024 * 10 , // 10M
                    'required'   => true,
                    'dir'        => 'audio/advert/',
                ]
            ],
        ];

        return $behaviors;
    }
}
