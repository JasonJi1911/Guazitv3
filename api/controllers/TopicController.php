<?php
namespace api\controllers;

use api\dao\CommonDao;
use api\logic\VideoLogic;
use api\models\video\Topic;

class TopicController extends BaseController
{
    /**
     * @return array
     * 专题首页
     */
    public function actionChannels()
    {
        $fields = ['channel_id', 'channel_name'];

        $commonDao = new CommonDao();
        $data['list'] = $commonDao->videoChannel($fields);

        // 添加热门分类
        array_unshift($data['list'], ['channel_id' => 0, 'channel_name' => '热门']);

        return $data;
    }

    /**
     * 根据频道Id返回专题
     * 当channel_id==0时，返回热门
     */
    public function actionList()
    {
        $channelId = $this->getParamOrFail('channel_id', 1);
        $pageNum   = $this->getParam('page_num', 1);

        if ($channelId == 0) {
            $where = ['is_hot' => Topic::IS_HOT_YES];
        } else {
            $where = ['channel_id' => $channelId];
        }

        $videoLogic = new VideoLogic();
        return $videoLogic->topicList($channelId, $pageNum, $where);
    }

    /**
     * 根据专题Id返回专题系列列表
     */
    public function actionVideo()
    {
        $topicId = $this->getParamOrFail('topic_id');
        $page = $this->getParam('page', 1);
        // 展示字段
        $fields = ['video_id', 'video_name', 'score', 'flag', 'tag', 'year', 'cover', 'horizontal_cover', 'category'];
        $videoLogic = new VideoLogic();
        return $videoLogic->topicVideoInfo($topicId, $fields, $page);
    }
}
