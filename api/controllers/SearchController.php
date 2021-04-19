<?php
namespace api\controllers;

use api\data\ActiveDataProvider;
use api\exceptions\InvalidParamException;
use api\logic\VideoLogic;
use common\models\apps\AppsCheckSwitch;
use common\models\apps\AppsVersion;

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
    
    /**
     * 搜索结果页new
     */
    public function actionNewResult()
    {
        $keyword = $this->getParam('keyword', '');  //关键词
        $channelId = $this->getParam('channel_id', ''); // 频道
        $sort      = $this->getParam('sort', 'hot'); // 排序
        $tag       = $this->getParam('tag', ''); // 标签
        $area      = $this->getParam('area', ''); // 地区
        $year      = $this->getParam('year', ''); // 年代
        $page      = $this->getParam('page_num', DEFAULT_PAGE_NUM); // 页面 当传入1时，返回检索项
        $pageSize  = $this->getParam('page_size', 10);
        $type      = $this->getParam('type', 0); // 类型 当传入1时，位点击分类进入，服务端要返回所有频道筛选项
        $playLimit = $this->getParam('play_limit', '');

        $area      = !empty($area) ? $area : '';
        $year      = !empty($year) ? $year : '';
        $tag       = !empty($tag) ? $tag : '';
        $playLimit = !empty($playLimit) ? $playLimit : '';
        $channelId = !empty($channelId) ? $channelId : '';
//        if (empty($keyword)) {
//            throw new InvalidParamException('关键词');
//        }

        $videoLogic = new VideoLogic();
        // 筛选项
        $data = [];
        // 当请求为第一页时，返回筛选页头部信息
        if ($page == 1) {
            $data = $videoLogic->filterHeader($channelId, $sort, $tag, $area, $year, $type, $playLimit);
        }
        $video = $videoLogic->searchResult1($channelId, $keyword, $sort, $tag, $area, $year, $type, $playLimit, $page, $pageSize);
        $data = array_merge($data, $video);
        return $data;
    }
    
    
    public function actionLetterResult()
    {
        $keyword = $this->getParam('keyword', '');  //关键词
        $page      = $this->getParam('page_num', DEFAULT_PAGE_NUM); // 页面 当传入1时，返回检索项
        $pageSize  = $this->getParam('page_size', 18);
        if (empty($keyword)) {
            throw new InvalidParamException('关键词');
        }

        $videoLogic = new VideoLogic();
        $data = $videoLogic->searchLetterResult($keyword, $page, $pageSize);
        return $data;
        // $versionUpdate = [
        //     'status' => 0,  // 更新状态 0-不更新，1-更新，2-强制更新
        //     'msg'    => '',    // 更新信息
        //     'url'    => '',    // 下载地址
        // ];
        // return $versionUpdate;
    }
    
    public function actionAppVersion()
    {
        $data = [];
        $appverModel = new AppsVersion();

        $iosprovider  = new ActiveDataProvider([
            'query' => $appverModel::find()
                ->andWhere(["os_type" => AppsVersion::OS_TYPE_IOS, "is_release" => AppsVersion::RELEASE_ON]),
        ]);

        $andprovider  = new ActiveDataProvider([
            'query' => $appverModel::find()
                ->andWhere(["os_type" => AppsVersion::OS_TYPE_ANDROID, "is_release" => AppsVersion::RELEASE_ON]),
        ]);

        $tvprovider  = new ActiveDataProvider([
            'query' => $appverModel::find()
                ->andWhere(["os_type" => AppsVersion::OS_TYPE_TV, "is_release" => AppsVersion::RELEASE_ON]),
        ]);

        $iosdata = AppsCheckSwitch::find()->andWhere(['version_id' => $iosprovider->getKeys()])->asArray()->one();
        $androiddata = AppsCheckSwitch::find()->andWhere(['version_id' => $andprovider->getKeys()])->asArray()->one();
        $tvdata = AppsCheckSwitch::find()->andWhere(['version_id' => $tvprovider->getKeys()])->asArray()->one();

        $data['iosdata'] = $iosdata;
        $data['androiddata'] = $androiddata;
        $data['tvdata'] = $tvdata;
        
        return $data;
    }
}
