<?php
namespace console\controllers;

use api\models\user\UserCoupon;
use common\models\stat\VideoStat;
use common\models\user\UserWatchLog;
use common\models\video\VideoFavorite;
use yii\console\Controller;

class VideoStatController extends Controller
{
    private $startTime = null;

    private $startDate = null;
    private $endDate   = null;
    
    private $i = 0;
    /**
     * 影片统计
     * @param null $start
     * @param null $end
     * @return bool
     */
    public function actionRun($start = null, $end = null)
    {
        echo "\n " . date('Y/m/d H:i:s') . " start \n";
        //默认统计昨天数据
        $this->startDate = date('Ymd', strtotime('-1 day'));
        $this->endDate   = date('Ymd');
        // 当传入开始时间，计算开始时间和结束时间，时间取整
        if ($start) {
            $this->startDate = date('Ymd', strtotime($start));
            $this->endDate   = date('Ymd', (strtotime($start) + 86400));
        }
        // 当传入结束时间，重置结束时间，时间取整
        if ($end) {
            $this->endDate = date('Ymd', strtotime($end));
        }

        //计算两天相差的天数
        $days = intval((strtotime($this->endDate) - strtotime($this->startDate)) / 86400);
        // 开始时间戳
        $this->startTime = strtotime($this->startDate);
        // 循环，统计数据
        for ($i=0; $i<$days; $i++) {
            $interval = $i* 86400;
            $date = date('Ymd', ($this->startTime+$interval));

            $this->_buildDateVideoStat($date);
        }

        echo "\n生成了{$this->i}统计记录\n";
        echo "\n " . date('Y/m/d H:i:s') . " end \n";
        return true;
    }

    private function _buildDateVideoStat($date)
    {
        if (empty($date)) {
            return false;
        }
        $startTime = strtotime($date);
        $endTime = $startTime + 86400;

        $yearMonth = date('Ym', $startTime);

        // 取收藏数
        $videoFavorite = VideoFavorite::find()
            ->select('video_id,count(*) num')
            ->where('created_at>=:start and created_at<:end', [':start' => $startTime, ':end' => $endTime])
            ->andWhere(['status' => VideoFavorite::STATUS_YES])
            ->groupBy('video_id')
            ->asArray()
            ->all();
        $data = [];
        foreach ($videoFavorite as $val) {
            $data[$val['video_id']]['favors'] = $val['num'];
        }
        // 取播放数
        $userWatchLog = UserWatchLog::find()
            ->select('video_id,count(*) num')
            ->where('updated_at>=:start and updated_at<:end', [':start' => $startTime, ':end' => $endTime])
            ->groupBy('video_id')
            ->asArray()
            ->all();
        // 播放量（PV） 和 访客量（UV） 其实是一样的，因为一个uid看一部影片只会记录一条数据
        foreach ($userWatchLog as $val) {
            $data[$val['video_id']]['play_num']  = $val['num'];
            $data[$val['video_id']]['visit_num'] = $val['num'];
        }

        // 查询券的使用记录
        $userCoupon = UserCoupon::find()->where(['type' => UserCoupon::TYPE_USE])->asArray()->all();

        // 记录购买影视的uid
        $uid = [];
        foreach ($userCoupon as $val) {
            if (empty($val['video_id'])) {
                continue;
            }
            // 初始化记录购买本片的uid数组
            if (!isset($uid[$val['video_id']])) {
                $uid[$val['video_id']] = [];
            }
            // 购买次数+1
            @$data[$val['video_id']]['pay_num'] += 1;
            // 收入
            @$data[$val['video_id']]['total_income'] += $val['num'];

            // 先判断这个人是否购买过本片，没有购买人数+1，然后记录uid
            if (!in_array($userCoupon['uid'], $uid[$val['video_id']])) {
                // 购买人数+1
                @$data[$val['video_id']]['pay_user'] += 1;
                $uid[$val['video_id']][] = $userCoupon['uid'];
            }
        }
        if (empty($data)) {
            return true;
        }
        // 统计入库
        foreach ($data as $videoId => $stat) {
            $videoStat = VideoStat::find()
                ->where(['date' => $date, 'video_id' => $videoId])
                ->one();
            if (empty($videoStat)) {
                $videoStat = new VideoStat();
                $videoStat->date       = $date;
                $videoStat->year_month = $yearMonth;
                $videoStat->video_id   = $videoId;
            }
            foreach ($stat as $field => $val) {
                $videoStat->$field = $val;
            }
            $videoStat->save();
            $this->i ++;
        }
        return true;

    }
}