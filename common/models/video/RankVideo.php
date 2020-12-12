<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%rank_video}}".
 *
 * @property int $id
 * @property int $rank_id 排行榜id
 * @property int $video_id 视频系列id
 * @property int $period 榜单类型，周榜月榜总榜
 * @property int $display_order 展示排序
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class RankVideo extends \xiang\db\ActiveRecord
{
    const PERIOD_WEEK  = 1;
    const PERIOD_MONTH = 2;
    const PERIOD_TOTAL = 3;


    public static $periodStatus = [
        self::PERIOD_WEEK  => '周榜',
        self::PERIOD_MONTH => '月榜',
        self::PERIOD_TOTAL => '总榜',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%rank_video}}';
    }

    public function getPeriodText()
    {
        return self::$periodStatus[$this->period];
    }


}
