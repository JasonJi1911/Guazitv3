<?php
namespace admin\models\stat\search;

use admin\models\stat\VideoStat;
use admin\models\user\UserCoupon;
use admin\models\user\UserWatchLog;
use admin\models\video\Video;
use common\models\traits\SearchInterface;
use common\models\traits\SearchTrait;

class VideoStatSearch extends VideoStat implements SearchInterface
{
    use SearchTrait;

    /**
     * @var string 影视名称
     */
    public $title;
    /**
     * @var int 频道
     */
    public $channel;
    /**
     * @var string 排序
     */
    public $sort;

    /**
     * @var array 排序选项
     */
    public static $sorts = [1 => '总收入', '总收藏'];


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'trim'],
            [['sort'], 'string'],
            [['channel'], 'integer']
        ];
    }

    /**
     * 在架影视数
     * @return int|string
     */
    public function countNum()
    {
        return Video::find()->where(['status' => Video::STATUS_ENABLED, 'deleted_at' => 0])->count();
    }

    /**
     * 播放影视部数
     * @param $startDate
     * @param int $day
     * @return int|string
     */
    public function videoNum($startDate = '', $day = 0)
    {
        $where = [];
        if ($startDate) {
            $startTime = strtotime($startDate);
            $endTime  = $startTime + 86400 * $day;
            $where = ['and',['>=' , 'updated_at', $startTime], ['<', 'updated_at', $endTime]];
        }
        return UserWatchLog::find()
            ->andFilterWhere($where)
            ->groupBy('video_id')
            ->count();
    }

    /**
     * 访客量
     * @param $startDate
     * @param $day
     * @return mixed
     */
    public function visitNum($startDate = '', $day = 0)
    {
        $where = [];
        if ($startDate) {
            $startTime = strtotime($startDate);
            $endTime  = $startTime + 86400 * $day;
            $where = ['and',['>=' , 'updated_at', $startTime], ['<', 'updated_at', $endTime]];
        }
        return UserWatchLog::find()
            ->andFilterWhere($where)
            ->groupBy('uid')
            ->count();
    }

    /**
     * 视频播放次数
     * @param $startDate
     * @param $day
     * @return mixed
     */
    public function playNum($startDate = '', $day = 0)
    {
        $where = [];
        if ($startDate) {
            $startTime = strtotime($startDate);
            $endTime  = $startTime + 86400 * $day;
            $where = ['and',['>=' , 'updated_at', $startTime], ['<', 'updated_at', $endTime]];
        }
        return UserWatchLog::find()
            ->andFilterWhere($where)
            ->count();
    }


    /**
     * 付款播放部数
     * @param $startDate
     * @param $day
     * @return mixed
     */
    public function payVideoNum($startDate = '', $day = 0)
    {
        $where = [];
        if ($startDate) {
            $startTime = strtotime($startDate);
            $endTime  = $startTime + 86400 * $day;
            $where = ['and',['>=' , 'updated_at', $startTime], ['<', 'updated_at', $endTime]];
        }

        return UserCoupon::find()
            ->andFilterWhere($where)
            ->andWhere(['type' => UserCoupon::TYPE_USE])
            ->groupBy('video_id')
            ->count();
    }

    public function prepareQuery($query)
    {
        $tbv = Video::tableName();
      
        $sort = $this->sort == 1 ? ['total_income' => SORT_DESC] : ['favors' => SORT_DESC];
        $field = 'video_id, sum(favors) as favors, sum(play_num) as play_num, sum(visit_num) as visit_num, sum(pay_user) as pay_user, sum(pay_num) as pay_num, sum(total_income) as total_income';

        $query->joinWith('video');
        return $query->select($field)
            ->andFilterWhere(['like', $tbv . '.title', $this->title])
            ->andFilterWhere([$tbv . '.channel_id' => $this->channel])
            ->orderBy($sort)
            ->groupBy('video_id');
    }
}
