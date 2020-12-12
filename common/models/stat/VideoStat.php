<?php

namespace common\models\stat;

use Yii;

/**
 * This is the model class for table "{{%video_stat}}".
 *
 * @property int $id 自增id
 * @property int $date 日期
 * @property int $year_month 年月
 * @property int $video_id 作品ID
 * @property int $favors 收藏数
 * @property int $play_num 播放量（PV）
 * @property int $visit_num 访客量（UV）
 * @property int $pay_user 购买人数
 * @property int $pay_num 购买次数
 * @property int $total_income 总收入
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 * @property int $deleted_at 删除时间
 */
class VideoStat extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video_stat}}';
    }


}
