<?php
namespace api\controllers;

use api\dao\RankDao;
use api\logic\ChannelLogic;
use api\models\video\RankVideo;

class RankController extends BaseController
{
    /**
     * 排行榜顶部tab
     */
    public function actionTab()
    {
        // 榜单类型
        $period = [];
        foreach (RankVideo::$periodStatus as $key => $item) {
            $period[] = [
                'period_id'   => $key,
                'period_name' => $item
            ];
        }
        $channelLogic = new ChannelLogic();
        // 每个频道下排行最高的排行榜
        $channel = $channelLogic->channelRankTab();

        return [
            'period' => $period,  //榜单周期
            'list'   => $channel
        ];
    }

    /**
     * 排行榜数据列表
     */
    public function actionList()
    {
        $period = $this->getParam('period_id');  //默认周榜
        if (!in_array($period, array_keys(RankVideo::$periodStatus))) {
            $period = RankVideo::PERIOD_WEEK;
        }
        $rankId = $this->getParam('rank_id');  //默认全部
        $rankId = $rankId ? $rankId : ''; // 排行id
        
        // 获取信息
        $rankDao = new RankDao();
        return $rankDao->getRankVideo($rankId, $period);
    }
}
