<?php
namespace pc\controllers;

use api\helpers\ErrorCode;
use common\models\BookChapter;
use common\models\AdvertPosition;
use common\models\UserAuth;
use common\helpers\Tool;
use common\models\WxSetting;
use Yii;
use yii\helpers\Url;
use yii\web\Cookie;
use common\models\Activity;
use common\models\ActivityLog;


class VideoController extends BaseController
{
    /**
     * 视频首页
     */
    public function actionOldIndex()
    {
        //获取影片系列、剧集、源信息
        $channel_id = Yii::$app->request->get('channel_id', '');
        $keyword = Yii::$app->request->get('keyword', '');

        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');

        //请求影片筛选信息
        $info = Yii::$app->api->get('/video/filter', ['channel_id' => $channel_id, 'type' => 1, 'page_size' => 24]);
        //请求热门搜索信息
        $hot = Yii::$app->api->get('/search/hot-word');

        return $this->render('index', [
            'info'      => $info,
            'hot'       => $hot,
            'channel_id'=> $channel_id,
            'keyword'   => $keyword,
            'channels'  => $channels
        ]);
    }

    /**
     * 视频新首页
     */
    public function actionIndex()
    {
        //获取频道信息
        $channel_id = Yii::$app->request->get('channel_id', 0);

        //请求首页信息
        $data = Yii::$app->api->get('/video/index', ['channel_id' => $channel_id]);

        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');

        //获取热搜
        $hotword = Yii::$app->api->get('/search/hot-word');

        if(!$data) {
            return $this->redirect('/site/error');
        }

        return $this->render('newindex',[
            'data'          => $data,
            'channels'      => $channels,
            'channel_id'    => $channel_id,
            'hotword'       => $hotword
        ]);
    }


    /**
     * 视频类目页
     */
    public function actionChannel()
    {
        $pageTab = "channel";

        //获取频道信息
        $channel_id = Yii::$app->request->get('channel_id', 0);

        //请求首页信息
        $data = Yii::$app->api->get('/video/index', ['channel_id' => $channel_id]);

        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');

        //获取热搜
        $hotword = Yii::$app->api->get('/search/hot-word');

        //请求影片筛选信息
        $info = Yii::$app->api->get('/video/filter', ['channel_id' => $channel_id, 'type' => 1, 'page_size' => 12]);

        if(!$data) {
            return $this->redirect('/site/error');
        }

        return $this->render('newframe',[
            'pageTab'       => $pageTab,
            'data'          => $data,
            'channels'      => $channels,
            'channel_id'    => $channel_id,
            'hotword'       => $hotword,
            'info'          => $info,
        ]);
    }

    /**
     * 视频详情播放页
     */
    public function actionOldDetail()
    {
        //获取影片系列、剧集、源信息
        $video_id = Yii::$app->request->get('video_id', 0);
        $chapter_id = Yii::$app->request->get('chapter_id', '');
        $source_id = Yii::$app->request->get('source_id', '');

        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');

        //请求视频信息
        $data = Yii::$app->api->get('/video/info', ['video_id' => $video_id, 'chapter_id' => $chapter_id, 'source_id' => $source_id]);


        if(!$data) {
            return $this->redirect('/site/error');
        }

        //请求热门搜索信息
        $hot = Yii::$app->api->get('/search/hot-word');

        return $this->render('detail', [
            'data'      => $data,
            'channels'  => $channels,
            'hot'       => $hot,
            'source_id' => $source_id,
        ]);
    }

    /**
     * 视频详情播放页
     */
    public function actionDetail()
    {
        $pageTab = "newdetail";

        //获取影片系列、剧集、源信息
        $video_id = Yii::$app->request->get('video_id', 0);
        $chapter_id = Yii::$app->request->get('chapter_id', '');
        $source_id = Yii::$app->request->get('source_id', '');

        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');

        //请求视频信息
        $data = Yii::$app->api->get('/video/info', ['video_id' => $video_id, 'chapter_id' => $chapter_id, 'source_id' => $source_id]);

        $channel_id = $data['channel_id'];
        $data['info']['actorvideos'] = [];
        if (isset($data['info']['actors'])) {
            foreach ($data['info']['actors'] as $key => $actor)
            {
                $actor_id = $actor['actor_id'];
                $acVideos = Yii::$app->api->get('/actor/videos', ['actor_id' => $actor_id]);
                array_push($data['info']['actorvideos'], $acVideos['list']);
            }
        }
//        array_merge($data['info'], ['actorvideos' => $actorVideos]);
//        $data['info']['actorvideos'] = $actorVideos;
        if(!$data || !isset($data['info']['source'])) {
            return $this->redirect('/site/error');
        }

        //请求热门搜索信息
        $hot = Yii::$app->api->get('/search/hot-word');

        return $this->render('newframe', [
            'pageTab'       => $pageTab,
            'data'          => $data,
            'channels'      => $channels,
            'hotword'       => $hot,
            'source_id'     => $source_id,
            'channel_id'    => $channel_id,
        ]);
    }

    /**
     * 视频详情列表页
     */
    public function actionList()
    {
        $pageTab = "list";

        //获取影片系列、剧集、源信息
        $channel_id = Yii::$app->request->get('channel_id', '');
        $keyword = Yii::$app->request->get('keyword', '');
        $sort = Yii::$app->request->get('sort', 'hot');
        $tag = Yii::$app->request->get('tag', '');
        $area = Yii::$app->request->get('area', '');
        $year = Yii::$app->request->get('year', '');
        $play_limit = Yii::$app->request->get('play_limit', '');
        $page_num = Yii::$app->request->get('page_num', 1);

        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');

        //请求影片筛选信息
        $info = Yii::$app->api->get('/video/filter', ['channel_id' => $channel_id, 'tag' => $tag, 'sort' => $sort, 'area' => $area,
            'play_limit' => $play_limit, 'year' => $year, 'page_num' => $page_num, 'page_size' =>24 ,'type' => 1]);
        //请求热门搜索信息
        $hot = Yii::$app->api->get('/search/hot-word');

        return $this->render('newframe', [
            'pageTab'       => $pageTab,
            'info'          => $info,
            'hotword'       => $hot,
//            'channel_id'    => $channel_id,
            'keyword'       => $keyword,
            'channels'      => $channels
        ]);
    }

    /**
     * 视频筛选接口
     */
    public function actionRefreshCate()
    {
        //获取影片系列、剧集、源信息
        $channel_id = Yii::$app->request->get('channel_id', 0);
        $sort = Yii::$app->request->get('sort', '');
        $tag = Yii::$app->request->get('tag', '');
        $area = Yii::$app->request->get('area', '');
        $year = Yii::$app->request->get('year', '');
        $play_limit = Yii::$app->request->get('play_limit', '');
        $page_num = Yii::$app->request->get('page_num', 1);

        //请求影片筛选信息
        $data = Yii::$app->api->get('/video/filter', ['channel_id' => $channel_id, 'tag' => $tag, 'sort' => $sort, 'area' => $area,
            'play_limit' => $play_limit, 'year' => $year, 'page_num' => $page_num, 'page_size' =>24 ,'type' => 1]);

        return Tool::responseJson(0, '操作成功', $data);
    }

    /**
     * 视频筛选接口
     */
    public function actionRefreshVideo()
    {
        $keyword = Yii::$app->request->get('keyword');
        $channel_id = Yii::$app->request->get('channel_id', 0);
        $sort = Yii::$app->request->get('sort', '');
        $tag = Yii::$app->request->get('tag', '');
        $area = Yii::$app->request->get('area', '');
        $year = Yii::$app->request->get('year', '');
        $play_limit = Yii::$app->request->get('play_limit', '');
        $page_num = Yii::$app->request->get('page_num', 1);

        //搜索首页信息
        $data = Yii::$app->api->get('/search/new-result', ['keyword' => $keyword, 'channel_id' => $channel_id, 'tag' => $tag, 'sort' => $sort,
            'area' => $area, 'play_limit' => $play_limit, 'year' => $year, 'page_num' => $page_num, 'page_size' =>24 ,'type' => 1]);

        return $this->renderPartial('partialresult', ['info' => $data]);
    }

    /**
     * 获取搜索影片接口
     */
    public function actionSearchVideo()
    {
        //获取搜索关键字、频道
        $keyword = Yii::$app->request->get('keyword');
        $page_num = Yii::$app->request->get('page_num', 1);

        //搜索首页信息
        $data = Yii::$app->api->get('/search/result', ['keyword' => $keyword, 'page_num' => $page_num, 'page_size' => 24]);

        return Tool::responseJson(0, '操作成功', $data);
    }


    /**
     * 切换下一集
     */
    public function actionSwitchVideo()
    {
        //获取影片系列、剧集、源信息
        $video_id = Yii::$app->request->get('video_id', 0);
        $chapter_id = Yii::$app->request->get('chapter_id', '');
        $source_id = Yii::$app->request->get('source_id', '');

        //请求视频信息
        $data = Yii::$app->api->get('/video/info', ['video_id' => $video_id, 'chapter_id' => $chapter_id, 'source_id' => $source_id]);

        return Tool::responseJson(0, '操作成功', $data );
    }

    /**
     * 热搜榜
     **/
    public function  actionHotSearch()
    {
        $pageTab = "hotsearch";
        //搜索首页信息
        $data = Yii::$app->api->get('/search/hot-word');

        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');

        return $this->render('newframe', [
            'pageTab'       => $pageTab,
            'data'          => $data,
            'channels'      => $channels,
            'hotword'       => $data,
        ]);
    }

    /**
     * 热搜榜
     **/
    public function  actionHotPlay()
    {
        $pageTab = "hotplay";
        //获取频道信息
        $channel_id = Yii::$app->request->get('channel_id', 0);

        //请求首页信息
        $data = Yii::$app->api->get('/video/index', ['channel_id' => 0]);

        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');

        //获取热搜
        $hotword = Yii::$app->api->get('/search/hot-word');

        if(!$data) {
            return $this->redirect('/site/error');
        }

        return $this->render('newframe',[
            'pageTab'       => $pageTab,
            'data'          => $data,
            'channels'      => $channels,
            'channel_id'    => $channel_id,
            'hotword'       => $hotword
        ]);
    }

    /**
     * 春晚直播
     **/
    public function actionSpringFestival()
    {
        return $this->render('springfestival');
    }


    public function  actionSearchResult()
    {
        $pageTab = "searchresult";
        $keyword = Yii::$app->request->get('keyword', '');
        $channel_id = Yii::$app->request->get('channel_id', 0);
        $sort = Yii::$app->request->get('sort', 'hot');
        $tag = Yii::$app->request->get('tag', '');
        $area = Yii::$app->request->get('area', '');
        $year = Yii::$app->request->get('year', '');
        $play_limit = Yii::$app->request->get('play_limit', '');
        $page_num = Yii::$app->request->get('page_num', 1);

        $channels = Yii::$app->api->get('/video/channels');
        $hotword = Yii::$app->api->get('/search/hot-word');

        //搜索首页信息
        $info = Yii::$app->api->get('/search/new-result', ['keyword' => $keyword, 'channel_id' => $channel_id, 'tag' => $tag, 'sort' => $sort, 'area' => $area,
            'play_limit' => $play_limit, 'year' => $year, 'page_num' => $page_num, 'page_size' =>24 ,'type' => 1]);

        return $this->render('newframe',[
            'pageTab'       => $pageTab,
            'keyword'       => $keyword,
            'info'          => $info,
            'channels'      => $channels,
            'hotword'       => $hotword
        ]);
    }
}
