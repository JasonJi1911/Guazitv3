<?php
namespace api\controllers;

use api\dao\CommonDao;

class ChannelController extends BaseController
{
    /**
     * 频道列表
     */
    public function actionList()
    {
        $commonDao = new CommonDao();
        $data['list'] = $commonDao->videoChannel(['channel_id', 'channel_name', 'icon']);
        // 插入排行榜
        array_push($data['list'], ['channel_id' => 0, 'channel_name' => '排行榜', 'icon' => API_HOST_PATH . '/img/king_kong/rank.png']);

        return $data;
    }

    /**
     * 供vip页面视频频道列表
     */
    public function actionTab()
    {
        $commonDao = new CommonDao();
        $data = $commonDao->videoChannel(['channel_id', 'channel_name']);
        array_unshift($data, ['channel_id' => 0, 'channel_name' => '全部']);
        return $data;
    }
}
