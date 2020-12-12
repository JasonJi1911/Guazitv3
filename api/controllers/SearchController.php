<?php
namespace api\controllers;

use api\exceptions\InvalidParamException;
use api\logic\VideoLogic;

class SearchController extends BaseController
{
    /**
     * 热搜词组
     */
    public function actionHotWord()
    {
        $videoLogic = new VideoLogic();
        return $videoLogic->hotWord();
    }

    /**
     * 搜索结果页
     */
    public function actionResult()
    {
        $channelId = $this->getParam('channel_id', '');  //频道id
        $keyword = trim($this->getParamOrFail('keyword'));  //关键词
        if (empty($keyword)) {
            throw new InvalidParamException('关键词');
        }

        $videoLogic = new VideoLogic();

        return $videoLogic->searchResult($channelId, $keyword);
    }
}
