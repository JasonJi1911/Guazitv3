<?php

namespace common\models\collect;

use common\behaviors\UploadBehavior;
use common\models\traits\SourceInterface;
use common\models\traits\SourceTrait;
use common\models\traits\StatusToggleInterface;
use common\models\traits\StatusToggleTrait;
use Yii;

/**
 * This is the model class for table "{{%collect}}".
 *
 * @property int $collect_id id
 * @property string $collect_name 采集名称
 * @property string $collect_url  采集接口链接
 * @property int $collect_type 接口返回数据类型 (1-xml, 2-json)
 * @property int $collect_mid 资源类型(1-视频, 2-演员, 8-文章)
 * @property string $collect_appid 采集账户
 * @property string $collect_appkey 采集秘钥
 * @property string $collect_param 采集参数
 * @property int $collect_opt 采集数据操作（0-新增+更新，1-新增，2-更新）
 * @property int $collect_filter 采集数据过滤（0-不过滤，1-新增+更新，2-新增，3-更新）
 * @property string $collect_filter_from 过滤代码
 * @property int $video_source 视频线路
 * @property int $isdownload 是否下载
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */

class Collect extends \xiang\db\ActiveRecord implements StatusToggleInterface,SourceInterface
{
    use SourceTrait;
    use StatusToggleTrait;

    // 接口返回数据类型
    const DATA_TYPE_XML = 1; // XML类型
    const DATA_TYPE_JSON = 2; // JSON类型
    public static $dataTypes = [
        self::DATA_TYPE_XML => 'XML类型',
        self::DATA_TYPE_JSON => 'JSON类型'
    ];


    // 资源类型
    const SRC_TYPE_VOD = 1; // 视频
    const SRC_TYPE_ACT = 2; // 演员
    const SRC_TYPE_ART = 8; // 文章
    public static $resourceMap= [
        self::SRC_TYPE_VOD => '视频',
        self::SRC_TYPE_ACT => '演员',
        self::SRC_TYPE_ART => '文章'
    ];

    // 采集数据操作
    const COLLECT_OPT_NEWUP = 0; // 新增+更新
    const COLLECT_OPT_NEW = 2; // 新增
    const COLLECT_OPT_UP = 3; // 更新
    public static $collectOptions = [
        self::COLLECT_OPT_NEWUP => '新增+更新',
        self::COLLECT_OPT_NEW => '新增',
        self::COLLECT_OPT_UP => '更新',
    ];

    // 采集数据过滤
    const COLLECT_FILTER_NONE = 0; // 不过滤
    const COLLECT_FILTER_NEWUP = 1; // 过滤
//    const COLLECT_FILTER_NEW = 2; // 过滤新增
//    const COLLECT_FILTER_UP = 3; // 过滤更新
    public static $collectFilters = [
        self::COLLECT_FILTER_NONE => '不过滤',
        self::COLLECT_FILTER_NEWUP => '过滤',
//        self::COLLECT_FILTER_NEW => '过滤新增',
//        self::COLLECT_FILTER_UP => '过滤更新',
    ];

    // 是否下载图片
    const COLLECT_DOWNLOAD_NO = 0; // 不下载
    const COLLECT_DOWNLOAD_YES = 1; // 下载
    public static $isDownloadPic = [
        self::COLLECT_DOWNLOAD_NO => '不下载',
        self::COLLECT_DOWNLOAD_YES => '下载',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%collect}}';
    }
}