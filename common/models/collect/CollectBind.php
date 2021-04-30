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
 * @property int $id id
 * @property int $type_id 类型id
 * @property string $type_name  类型名称
 * @property int $collect_id 采集资源id
 * @property int $video_channel 绑定频道
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */

class CollectBind extends \xiang\db\ActiveRecord implements StatusToggleInterface,SourceInterface
{
    use SourceTrait;
    use StatusToggleTrait;

    // 视频频道
    const VIDEO_CHANNEL_MOVIE = 1; //电影
    const VIDEO_CHANNEL_DRAMA = 2; //电视剧
    const VIDEO_CHANNEL_ENTER = 3; //综艺
    const VIDEO_CHANNEL_ANIMATION = 4; //动漫
    const VIDEO_CHANNEL_DOCUMENTARY = 32; //纪录片
    const VIDEO_CHANNEL_SPORT = 33; //体育直播
    const VIDEO_CHANNEL_TV = 34; //电视直播

    // 电影类型
    const MOVIE_CATE_COMEDY = 153; // 喜剧
    const MOVIE_CATE_ACTION = 154; // 动作
    const MOVIE_CATE_ROMANCE = 155; // 爱情
    const MOVIE_CATE_THRILLER = 156; // 惊悚
    const MOVIE_CATE_CRIME = 157; // 犯罪
    const MOVIE_CATE_ADVENTURE = 158; // 冒险
    const MOVIE_CATE_SCIENCEFICTION = 159; // 科幻
    const MOVIE_CATE_SUSPENSE = 160; // 悬疑
    const MOVIE_CATE_PLOT = 161; // 剧情
    const MOVIE_CATE_ANIMATION = 162; // 动画
    const MOVIE_CATE_MARTIALARTS = 163; // 武侠
    const MOVIE_CATE_WAR = 164; // 战争
    const MOVIE_CATE_HORROR = 169; // 恐怖
    const MOVIE_CATE_OTHER = 178; // 其他
    const MOVIE_CATE_MAGIC = 179; // 魔幻
    const MOVIE_CATE_STRANGE = 226; // 奇幻

    public static $movieCategorys = [
        self::MOVIE_CATE_COMEDY => '喜剧',
        self::MOVIE_CATE_ACTION => '动作',
        self::MOVIE_CATE_ROMANCE => '爱情',
        self::MOVIE_CATE_THRILLER => '惊悚',
        self::MOVIE_CATE_CRIME => '犯罪',
        self::MOVIE_CATE_ADVENTURE => '冒险',
        self::MOVIE_CATE_SCIENCEFICTION => '科幻',
        self::MOVIE_CATE_SUSPENSE => '悬疑',
        self::MOVIE_CATE_PLOT => '剧情',
        self::MOVIE_CATE_ANIMATION => '动画',
        self::MOVIE_CATE_MARTIALARTS => '武侠',
        self::MOVIE_CATE_WAR => '战争',
        self::MOVIE_CATE_HORROR => '恐怖',
        self::MOVIE_CATE_OTHER => '其他',
        self::MOVIE_CATE_MAGIC => '魔幻',
        self::MOVIE_CATE_STRANGE => '奇幻',
    ];

    //电视剧类型
    const DRAMA_CATE_CHINAMAINLAND = 171; // 国产
    const DRAMA_CATE_TAILAND = 172; // 泰国
    const DRAMA_CATE_HONGKONG = 173; // 香港
    const DRAMA_CATE_USA = 174; // 欧美
    const DRAMA_CATE_JAPAN = 175; // 日本
    const DRAMA_CATE_KOREAN = 176; // 韩国
    const DRAMA_CATE_TAIWAN = 177; // 台湾
    const DRAMA_CATE_HONGTAI = 181; // 港台
    const DRAMA_CATE_JAKO = 182; // 日韩
    const DRAMA_CATE_OTHER = 231; // 其他

    public static $dramaCategorys = [
        self::DRAMA_CATE_CHINAMAINLAND => '国产',
        self::DRAMA_CATE_TAILAND => '泰国',
        self::DRAMA_CATE_HONGKONG => '香港',
        self::DRAMA_CATE_USA => '欧美',
        self::DRAMA_CATE_JAPAN => '日本',
        self::DRAMA_CATE_KOREAN => '韩国',
        self::DRAMA_CATE_TAIWAN => '台湾',
        self::DRAMA_CATE_HONGTAI => '港台',
        self::DRAMA_CATE_JAKO => '日韩',
        self::DRAMA_CATE_OTHER => '其他',
    ];

    //综艺类型
    const ENTER_CATE_TALK = 168; //访谈
    const ENTER_CATE_REALITY = 227; //真人秀
    const ENTER_CATE_TALKSHOW = 228; //脱口秀
    const ENTER_CATE_LIFE = 229; //生活
    const ENTER_CATE_OTHER = 232; //其他

    public static $enterCategorys = [
        self::ENTER_CATE_TALK => '访谈',
        self::ENTER_CATE_REALITY => '真人秀',
        self::ENTER_CATE_TALKSHOW => '脱口秀',
        self::ENTER_CATE_LIFE => '生活',
        self::ENTER_CATE_OTHER => '其他',
    ];

    //动画类型
    const ANNI_CATE_JANKO = 165; // 日韩动漫
    const ANNI_CATE_EURUS = 166; // 欧美动漫
    const ANNI_CATE_CHINA = 167; // 国产动漫
    const ANNI_CATE_OTHER = 170; // 其他

    public static $animationCategorys = [
        self::ANNI_CATE_JANKO => '日韩动漫',
        self::ANNI_CATE_EURUS => '欧美动漫',
        self::ANNI_CATE_CHINA => '国产动漫',
        self::ANNI_CATE_OTHER => '其他',
    ];

    //纪录片类型
    const DOCU_CATE_CHINA = 234;//大陆地区
    const DOCU_CATE_EUROPEAMERICA = 235;//欧美地区
    const DOCU_CATE_HONGKONGM = 236;//香港地区
    const DOCU_CATE_JAPAN = 237;//日本地区
    const DOCU_CATE_OTHER = 238;//其他

    public static $documentaryCategorys = [
        self::DOCU_CATE_CHINA => '大陆',
        self::DOCU_CATE_EUROPEAMERICA => '欧美',
        self::DOCU_CATE_HONGKONGM => '香港',
        self::DOCU_CATE_JAPAN => '日本',
        self::DOCU_CATE_OTHER => '其他',
    ];

    // 视频地区
    const AREA_CHINAMAINLAND = 18;
    const AREA_USA = 19;
    const AREA_HONGKONG = 20;
    const AREA_KOREAN = 21;
    const AREA_ENGLAND = 22;
    const AREA_TAIWAN = 23;
    const AREA_JAPAN = 24;
    const AREA_FRANCE = 25;
    const AREA_ITALY = 26;
    const AREA_GERMAN = 27;
    const AREA_SPANISH = 28;
    const AREA_SOUTHASIAN = 29;
    const AREA_OTHER = 30;

    public static $videoAreas = [
        self::AREA_CHINAMAINLAND => '大陆',
        self::AREA_USA => '欧美',
        self::AREA_HONGKONG => '香港',
        self::AREA_KOREAN => '韩国',
        //self::AREA_ENGLAND => '英国',
        self::AREA_TAIWAN => '台湾',
        self::AREA_JAPAN => '日本',
//        self::AREA_FRANCE => '法国',
//        self::AREA_ITALY => '意大利',
//        self::AREA_GERMAN => '德国',
//        self::AREA_SPANISH => '西班牙',
        self::AREA_SOUTHASIAN => '东南亚',
        self::AREA_OTHER => '其它',
    ];

    //视频年份
    const YEAR2021 = 22;
    const YEAR2020 = 23;
    const YEAR2019 = 24;
    const YEAR2018 = 25;
    const YEAR2017 = 26;
    const YEAR2016 = 27;
    const YEAR2015 = 28;
    const YEAR2014 = 29;
    const YEAR2013 = 30;
    const YEAR2012 = 31;
    const YEAR2011 = 32;
    const YEAR2010 = 33;
    const YEAR2009 = 34;
    const YEAR2008 = 35;
    const YEAREARLY = 127;

    public static $videoYears = [
        self::YEAR2021 => '2021',
        self::YEAR2020 => '2020',
        self::YEAR2019 => '2019',
        self::YEAR2018 => '2018',
        self::YEAR2017 => '2017',
        self::YEAR2016 => '2016',
        self::YEAR2015 => '2015',
        self::YEAR2014 => '2014',
        self::YEAR2013 => '2013',
        self::YEAR2012 => '2012',
        self::YEAR2011 => '2011',
        self::YEAR2010 => '2010',
        self::YEAR2009 => '2009',
        self::YEAR2008 => '2008',
        self::YEAREARLY => '更早',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%collect_bind}}';
    }
}