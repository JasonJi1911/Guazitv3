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
use common\helpers\RedisStore;
use yii\helpers\ArrayHelper;
use pc\models\LoginForm;

class VideoController extends BaseController
{
    private function ReformateCityName($region_code, $city)
    {
        if ($region_code == 'NSW' && $city != '悉尼')
            $city = '悉尼';

        if ($region_code == 'QLD' && $city != '布里斯班')
            $city = '布里斯班';

        if ($region_code == 'VIC' && $city != '墨尔本')
            $city = '墨尔本';

        if ($region_code == 'SA' && $city != '阿德莱德')
            $city = '阿德莱德';

        if ($region_code == 'WA' && $city != '珀斯')
            $city = '珀斯';

        return $city;
    }

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
        // 获取ip访问的cookie 时间
        $tick=false; //不展示
        $cookie1 = \Yii::$app->request->cookies;
        $adTime=$cookie1->get("adTime");
        if(($adTime->value+1800) < time()){
            $cookie = new \yii\web\Cookie();
            $cookie -> name = 'adTime';        //cookie的名称
            $cookie -> expire = time() + 1800;	   //存活的时间
            $cookie -> httpOnly = true;		   //无法通过js读取cookie
            $cookie -> value =time();   //cookie的值
            \Yii::$app->response->getCookies()->add($cookie);
            $tick=true;
        }

        //获取频道信息
        $channel_id = Yii::$app->request->get('channel_id', 0);

        $city = "";
        $redis = new RedisStore();
        $ip = Tool::getIp();

        $cityCache=$redis->get(md5($ip."_city"));
        if (empty($cityCache)) {
            $ipAddress = Tool::getIpAddressFromStack($ip);
            $city = $ipAddress['city'];
            $city = $this->ReformateCityName($ipAddress['region_code'], $city);
            if (!isset($city))
                $city = "";
            $redis->setEx(md5($ip."_city"), $city, 3600*24*30);
        }
        else {
            $city = $cityCache;
        }
        //请求首页信息
        $data = Yii::$app->api->get('/video/index', ['channel_id' => $channel_id, 'city'=> $city]);

        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');

        //获取热搜
        $hotword = Yii::$app->api->get('/search/hot-word');

        $version = Yii::$app->api->get('/search/app-version');

        //新片预告
        $trailer = Yii::$app->api->get('/video/trailer', ['channel_id' => $channel_id]);
        if($trailer){
            $data['trailer'] = $trailer;
        }

        if(!$data) {
            return $this->redirect('/site/error');
        }
        $view = Yii::$app->view->params['isIndex'] = '1';
        $pageTab = "newindex";
        return $this->render('newframe',[
            'data'          => $data,
            'channels'      => $channels,
            'channel_id'    => $channel_id,
            'hotword'       => $hotword,
            'tick'          => $tick,
            'tvpath'        => $version['tvdata'],
            'city'          => $city,
            'pageTab'       => $pageTab

        ]);
    }

    /**
     * 首页banner局部视图
     */
    public function actionIndexBanner()
    {
        //获取频道信息
        $channel_id = Yii::$app->request->get('channel_id', 0);

        $city = "";
        $redis = new RedisStore();
        $ip = Tool::getIp();

        $cityCache=$redis->get(md5($ip."_city"));
        if (empty($cityCache)) {
            $ipAddress = Tool::getIpAddressFromStack($ip);
            $city = $ipAddress['city'];
            $city = $this->ReformateCityName($ipAddress['region_code'], $city);
            if (!isset($city))
                $city = "";
            $redis->setEx(md5($ip."_city"), $city, 3600*24*30);
        }
        else {
            $city = $cityCache;
        }
        //请求首页信息
        $data = Yii::$app->api->get('/video/banner', ['channel_id' => $channel_id, 'city'=> $city]);
        return $this->renderPartial('indexbanner', ['data' => $data]);
    }

    /**
     * 广告局部刷新
     */
    public function actionAdvert()
    {
        //获取频道信息
        $page = Yii::$app->request->get('page', "home");

        $city = "";
        $redis = new RedisStore();
        $ip = Tool::getIp();

        $cityCache=$redis->get(md5($ip."_city"));
        if (empty($cityCache)) {
            $ipAddress = Tool::getIpAddressFromStack($ip);
            $city = $ipAddress['city'];

            $city = $this->ReformateCityName($ipAddress['region_code'], $city);

            if (!isset($city))
                $city = "";
            $redis->setEx(md5($ip."_city"), $city, 3600*24*30);
        }
        else {
            $city = $cityCache;
        }
        //请求首页信息
        $data = Yii::$app->api->get('/video/advert', ['page' => $page, 'city'=> $city]);
        $data['page'] = $page;
        $data['city'] = $city;
        $data['cityCache'] = $cityCache;
        $data['ip'] = Tool::getIp();
        $data['random'] = rand(10000, 99999);

        return Tool::responseJson(0, '操作成功', $data);
    }

    public function actionGetCity()
    {
        $city = "";
        $redis = new RedisStore();
        $ip = Tool::getIp();

        $cityCache=$redis->get(md5($ip."_city"));
        if (empty($cityCache)) {
            $ipAddress = Tool::getIpAddressFromStack($ip);
            $city = $ipAddress['city'];
            $city = $this->ReformateCityName($ipAddress['region_code'], $city);
            if (!isset($city))
                $city = "";
            $redis->setEx(md5($ip."_city"), $city, 3600*24*30);
        }
        else {
            $city = $cityCache;
        }

        $data['city'] = $city;
        $data['cityctche'] = $cityCache;
        $data['random'] = rand(10000, 99999);

        return Tool::responseJson(0, '操作成功', $data);
    }

    /**
     * 视频类目页
     */
    public function actionChannel()
    {
        $pageTab = "channel";

        //获取频道信息
        $channel_id = Yii::$app->request->get('channel_id', 0);

        $city = "";
        $redis = new RedisStore();
        $ip = Tool::getIp();

        $cityCache=$redis->get(md5($ip."_city"));
        if (empty($cityCache)) {
            $ipAddress = Tool::getIpAddressFromStack($ip);
            $city = $ipAddress['city'];
            $city = $this->ReformateCityName($ipAddress['region_code'], $city);
            if (!isset($city))
                $city = "";
            $redis->setEx(md5($ip."_city"), $city, 3600*24*30);
        }
        else {
            $city = $cityCache;
        }
        //请求首页信息
        $data = Yii::$app->api->get('/video/index', ['channel_id' => $channel_id, 'city'=> $city]);

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

        $uid = Yii::$app->user->id;

        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');
        $city = "";
        $redis = new RedisStore();
        $ip = Tool::getIp();

        $cityCache=$redis->get(md5($ip."_city"));
        if (empty($cityCache)) {
            $ipAddress = Tool::getIpAddressFromStack($ip);
            $city = $ipAddress['city'];
            $city = $this->ReformateCityName($ipAddress['region_code'], $city);
            if (!isset($city))
                $city = "";
            $redis->setEx(md5($ip."_city"), $city, 3600*24*30);
        }
        else {
            $city = $cityCache;
        }
        //请求视频信息
        // $data = Yii::$app->api->get('/video/info', ['video_id' => $video_id, 'chapter_id' => $chapter_id, 'source_id' => $source_id]);
        $data = Yii::$app->api->get('/video/info', ['video_id' => $video_id, 'chapter_id' => $chapter_id, 'source_id' => $source_id, 'city'=> $city, 'uid'=>$uid]);

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
        if(!$data
            || !isset($data['info'])
            || !isset($data['info']['source'])) {
            return $this->redirect('/site/error');
        }

        //请求热门搜索信息
        $hot = Yii::$app->api->get('/search/hot-word');
        $source_id = $data['info']['source_id'];
        $sourceFilter = $data['info']['filter'];
        $souceVideos = ArrayHelper::index($sourceFilter, 'resId')[$source_id]['data'];
        if ($souceVideos) {
            $data['info']['next_chapter'] = ArrayHelper::index($souceVideos, 'chapter_id')[$data['info']['play_chapter_id']]['next_chapter'];
            $data['info']['last_chapter'] = ArrayHelper::index($souceVideos, 'chapter_id')[$data['info']['play_chapter_id']]['last_chapter'];
        }

        //在线反馈信息
        $feedbackinfo = Yii::$app->api->get('/video/feedbackinfo');

        return $this->render('newframe', [
            'pageTab'       => $pageTab,
            'data'          => $data,
            'channels'      => $channels,
            'hotword'       => $hot,
            'source_id'     => $source_id,
            'channel_id'    => $channel_id,
            'city'=> $city,
            'feedbackinfo'  => $feedbackinfo
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
        $sort = Yii::$app->request->get('sort', 'new');
        $sorttype = Yii::$app->request->get('sorttype', 'desc');//排序高低
        $tag = Yii::$app->request->get('tag', '');
        $area = Yii::$app->request->get('area', '');
        $year = Yii::$app->request->get('year', '');
        $play_limit = Yii::$app->request->get('play_limit', '');
        $page_num = Yii::$app->request->get('page_num', 1);
        $page_size = Yii::$app->request->get('page_size', 32);
        $status = Yii::$app->request->get('status', 0); // 剧集是否完结：全部 / 更新中

        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');

        //请求影片筛选信息
        $info = Yii::$app->api->get('/video/filters', ['channel_id' => $channel_id, 'tag' => $tag, 'sort' => $sort, 'sorttype' => $sorttype, 'area' => $area,
            'play_limit' => $play_limit, 'year' => $year, 'page_num' => $page_num, 'page_size' =>$page_size ,'type' => 1, 'status' => $status]);
        //请求热门搜索信息
        $hot = Yii::$app->api->get('/search/hot-word');

        //右侧广告
        $advert = Yii::$app->api->get('/video/advert', ['page' => $pageTab, 'city'=> '']);

        return $this->render('newframe', [
            'pageTab'       => $pageTab,
            'info'          => $info,
            'hotword'       => $hot,
//            'channel_id'    => $channel_id,
            'keyword'       => $keyword,
            'channels'      => $channels,
            'advert'        => $advert['advert']
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
        $sorttype = Yii::$app->request->get('sorttype', 'desc');//排序高低
        $tag = Yii::$app->request->get('tag', '');
        $area = Yii::$app->request->get('area', '');
        $year = Yii::$app->request->get('year', '');
        $play_limit = Yii::$app->request->get('play_limit', '');
        $page_num = Yii::$app->request->get('page_num', 1);
        $page_size = Yii::$app->request->get('page_size', 32);
        $status = Yii::$app->request->get('status', 0); // 剧集是否完结：全部 / 更新中

        //请求影片筛选信息
//        $data = Yii::$app->api->get('/video/filter', ['channel_id' => $channel_id, 'tag' => $tag, 'sort' => $sort, 'area' => $area,
//            'play_limit' => $play_limit, 'year' => $year, 'page_num' => $page_num, 'page_size' =>24 ,'type' => 1]);

        $data = Yii::$app->api->get('/video/filters', ['channel_id' => $channel_id, 'tag' => $tag, 'sort' => $sort, 'sorttype' => $sorttype, 'area' => $area,
            'play_limit' => $play_limit, 'year' => $year, 'page_num' => $page_num, 'page_size' =>$page_size ,'type' => 1, 'status' => $status]);

        return Tool::responseJson(0, '操作成功', $data);
    }

    /**
     * 视频筛选接口new
     */
    public function actionRefreshVideo()
    {
        $keyword = Yii::$app->request->get('keyword');
        $channel_id = Yii::$app->request->get('channel_id', 0);
        $sort = Yii::$app->request->get('sort', 'new');
        $sorttype = Yii::$app->request->get('sorttype', 'desc');//排序高低
        $tag = Yii::$app->request->get('tag', '');
        $area = Yii::$app->request->get('area', '');
        $year = Yii::$app->request->get('year', '');
        $play_limit = Yii::$app->request->get('play_limit', '');
        $page_num = Yii::$app->request->get('page_num', 1);
        $page_size = Yii::$app->request->get('page_size', 32);
        $tvNum = Yii::$app->request->get('tvNum', 7);//集数的显示个数
        $status = Yii::$app->request->get('status', 0); // 剧集是否完结：全部 / 更新中

        //搜索首页信息
        $data = Yii::$app->api->get('/search/new-result', ['keyword' => $keyword, 'channel_id' => $channel_id, 'tag' => $tag, 'sort' => $sort,'sorttype' => $sorttype,
            'area' => $area, 'play_limit' => $play_limit, 'year' => $year, 'page_num' => $page_num, 'page_size' =>$page_size ,'type' => 1, 'status' => $status]);
        $data['tvNum'] = $tvNum;//集数的显示个数
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


    /**
     * 新搜索结果页
     **/
    public function  actionSearchResult()
    {
        $pageTab = "searchresult";
        $keyword = Yii::$app->request->get('keyword', '');
        $channel_id = Yii::$app->request->get('channel_id', 0);
        $sort = Yii::$app->request->get('sort', 'new');
        $sorttype = Yii::$app->request->get('sorttype', 'desc');//排序高低
        $tag = Yii::$app->request->get('tag', '');
        $area = Yii::$app->request->get('area', '');
        $year = Yii::$app->request->get('year', '');
        $play_limit = Yii::$app->request->get('play_limit', '');
        $page_num = Yii::$app->request->get('page_num', 1);
        $page_size = Yii::$app->request->get('page_size', 32);
        $status = Yii::$app->request->get('status', 0); // 剧集是否完结：全集 / 更新中

        $channels = Yii::$app->api->get('/video/channels');
        $hotword = Yii::$app->api->get('/search/hot-word');

        //搜索首页信息
        $info = Yii::$app->api->get('/search/new-result', ['keyword' => $keyword, 'channel_id' => $channel_id, 'tag' => $tag, 'sort' => $sort, 'sorttype' => $sorttype,
            'area' => $area, 'play_limit' => $play_limit, 'year' => $year, 'page_num' => $page_num, 'page_size' =>$page_size ,'type' => 1, 'status' => $status]);

        //右侧广告
        $advert = Yii::$app->api->get('/video/advert', ['page' => $pageTab, 'city'=> '']);

        return $this->render('newframe',[
            'pageTab'       => $pageTab,
            'keyword'       => $keyword,
            'info'          => $info,
            'channels'      => $channels,
            'hotword'       => $hotword,
            'advert'        => $advert['advert']
        ]);
    }

    public function actionMap()
    {
        $pageTab = "map";

        $channels = Yii::$app->api->get('/video/channels');
        $hotword = Yii::$app->api->get('/search/hot-word');

        foreach ($channels['list'] as $s_k => &$s_v)
        {
            $channel_id = $s_v['channel_id'];
            $cates = Yii::$app->api->get('/video/filter', ['channel_id' => $channel_id, 'tag' => '', 'sort' => '', 'area' => '',
                'play_limit' => '', 'year' => '', 'page_num' => 1, 'page_size' =>24 ,'type' => 1]);
            $s_v['search_box'] = $cates['search_box'];
        }

        return $this->render('newframe',[
            'pageTab'       => $pageTab,
            'channels'      => $channels,
            'hotword'       => $hotword
        ]);
    }

    public function actionCollaboration()
    {
        $pageTab = "collaboration";

        //获取频道信息
        $channel_id = 0;

        //请求首页信息
        $data = Yii::$app->api->get('/video/index', ['channel_id' => $channel_id]);

        //获取热搜
        $hotword = Yii::$app->api->get('/search/hot-word');

        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');

        if(!$data) {
            return $this->redirect('/site/error');
        }

        return $this->render('newframe',[
            'pageTab'       => $pageTab,
            'data'          => $data,
            'channels'      => $channels,
            'channel_id'    => $channel_id,
            'hotword'       => $hotword,
        ]);
    }

    public function actionGetWechat()
    {
        $cacheKey = rand(100000, 999999);;

        $cookie1 = \Yii::$app->request->cookies;
        $wechatTime=$cookie1->get("wechatTime");
        if(!empty($wechatTime->value)){
            $return['status_code'] = 500;
            $return['msg'] = "用户已经扫码";
            return Tool::responseJson(0, '操作成功', $return);
        }

        $city = "";
        $redis = new RedisStore();
        $ip = Tool::getIp();

        $cityCache=$redis->get(md5($ip."_city"));
        if (empty($cityCache)) {
            $ipAddress = Tool::getIpAddressFromStack($ip);
            $city = $ipAddress['city'];
            $city = $this->ReformateCityName($ipAddress['region_code'], $city);
            if (!isset($city))
                $city = "";
            $redis->setEx(md5($ip."_city"), $city, 3600*24*30);
        }
        else {
            $city = $cityCache;
        }

        if ($city != "悉尼") {
            $return['status_code'] = 500;
            $return['msg'] = "非悉尼用户不用扫码";
            return Tool::responseJson(0, '操作成功', $return);
        }


        $picUrl = "/images/NewVideo/wechatLIVEQR.png";

        $return['status_code'] = 200;
        $data['img_url'] = $picUrl;
        $data['weChatFlag'] = $cacheKey;
        $return['data'] = $data;
        return Tool::responseJson(0, '操作成功', $return);
    }

    public function actionCheckWechat()
    {
        $cacheKey =  Yii::$app->request->get('wechat_flag', "scene");
        $redis = new \Redis();
        //连接
        $redis->connect('127.0.0.1', 6381);
        $redis->auth("guazity1987");
        $sceneCache = $redis->get($cacheKey);

        $scene = "";
        if (empty($sceneCache)) {
            $scene = "empty";
        }
        else {
            $scene = $sceneCache;
        }
        $return['catch'] = $cacheKey;
        $return['scene'] = $scene;

        return Tool::responseJson(0, '操作成功', $return);
    }

    public function actionClearCatch()
    {
        $cacheKey =  Yii::$app->request->get('catachkey', "scene");
        $redis = new \Redis();
        //连接
        $redis->connect('127.0.0.1', 6381);
        $redis->auth("guazity1987");
        $redis->del($cacheKey);

        $cookie1 = \Yii::$app->request->cookies;
        $wechatTime=$cookie1->get("wechatTime");
        if(empty($wechatTime->value)){
            $cookie = new \yii\web\Cookie();
            $cookie -> name = 'wechatTime';        //cookie的名称
            $cookie -> expire = time() + 3600*24*30;	   //存活的时间
            $cookie -> httpOnly = true;		   //无法通过js读取cookie
            $cookie -> value =time();   //cookie的值
            \Yii::$app->response->getCookies()->add($cookie);
        }

        return Tool::responseJson(0, '操作成功', $data);
    }

    public function actionFeedBack()
    {
        $video_id = Yii::$app->request->get('video_id', "");
        $chapter_id = Yii::$app->request->get('chapter_id', "");
        $source_id = Yii::$app->request->get('source_id', "");
        $reason = Yii::$app->request->get('reason', "");
        $ip = Tool::getIp();
        //保存反馈信息
        $data = Yii::$app->api->get('/video/feed-back', ['video_id' => $video_id, 'chapter_id' => $chapter_id
            , 'source_id' => $source_id, 'ip'=>$ip, 'reason' => $reason]);

        $data['para'] = ['video_id'=>$video_id, 'chapter_id'=>$chapter_id, 'source_id'=>$source_id, 'reason' => $reason];
        return Tool::responseJson(0, '操作成功', $data);
    }

    /*
     * 求片
     */
    public function actionSeek(){
        $pageTab = 'seek';

        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');
        //获取热搜
        $hotword = Yii::$app->api->get('/search/hot-word');
        //获取地区
        $data = Yii::$app->api->get('/video/seek');

        return $this->render('newframe',[
            'pageTab'       => $pageTab,
            'channels'      => $channels,
            'hotword'       => $hotword,
            'data'          => $data
        ]);
    }

    /*
     * 提交求片信息
     * $video_name 片名
     * $channel_id 频道id
     * $area_id 地区id
     * $year 年代
     * $director_name 导演名称
     * $actor_name 主演名称
     */
    public function actionSaveSeek(){
        $video_name    = Yii::$app->request->get('video_name', "");
        $channel_id    = Yii::$app->request->get('channel_id', 0);
        $area_id       = Yii::$app->request->get('area_id', 0);
        $year          = Yii::$app->request->get('year', "");
        $director_name = Yii::$app->request->get('director_name', "");
        $actor_name    = Yii::$app->request->get('actor_name', "");
        $result = Yii::$app->api->get('/video/save-seek',['video_name' => $video_name,'channel_id' => $channel_id,'area_id' => $area_id, 'year'=>$year, 'director_name'=>$director_name, 'actor_name'=>$actor_name]);

        return $result;
    }
    /*
     * 帮助中心
     */
    public function actionHelp(){
        $pageTab = 'help';

        $helptab = Yii::$app->request->get('tab', "");
        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');
        //获取热搜
        $hotword = Yii::$app->api->get('/search/hot-word');
        //在线反馈信息
        $feedbackinfo = Yii::$app->api->get('/video/feedbackinfo');

        return $this->render('newframe',[
            'pageTab'       => $pageTab,
            'channels'      => $channels,
            'hotword'       => $hotword,
            'feedbackinfo'  => $feedbackinfo,
            'helptab'       => $helptab
        ]);
    }

    /*
     * 保存反馈信息
     */
    public function actionSaveFeedbackinfo(){
        $uid         = Yii::$app->user->id;
        $country     = Yii::$app->request->get('country', 0);
        $internets   = Yii::$app->request->get('internets', 0);
        $systems     = Yii::$app->request->get('systems', 0);
        $browsers    = Yii::$app->request->get('browsers', 0);
        $description = Yii::$app->request->get('description', "");
        $video_id    = Yii::$app->request->get('video_id', 0);
        $chapter_id  = Yii::$app->request->get('chapter_id', 0);
        $source_id   = Yii::$app->request->get('source_id', 0);
        $result = Yii::$app->api->get('/video/save-feedbackinfo',['country' => $country,'internets' => $internets,
            'systems' => $systems, 'browsers'=>$browsers, 'description'=>$description,
            'video_id' =>$video_id ,'chapter_id'=>$chapter_id ,'source_id'=>$source_id ,'uid'=>$uid]);
        return $result;
    }

    /*
     * 获取国家信息
     */
    public function actionGetCountry(){
        $country_code = Yii::$app->request->get('country_code', "");
        $country_name = Yii::$app->request->get('country_name', "");
        $result = Yii::$app->api->get('/video/get-country',['country_code' => $country_code, 'country_name' => $country_name]);
        return Tool::responseJson(0, '操作成功', $result);
    }
    /*
     * 广告中心
     */
    public function actionAdcenter(){

        $pageTab = 'adcenter';

//        $helptab = Yii::$app->request->get('tab', "");
        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');
        //获取热搜
        $hotword = Yii::$app->api->get('/search/hot-word');
        //在线反馈信息
        $data = Yii::$app->api->get('/video/feedbackinfo');

        return $this->render('newframe',[
            'pageTab'  => $pageTab,
            'channels' => $channels,
            'hotword'  => $hotword,
            'data'     => $data
        ]);
    }

    /*
     * 注册广告商
     */
    public function actionSaveAdcenter(){
        $type = Yii::$app->request->get('type', "");
        $realname = Yii::$app->request->get('realname', "");
        $telephone = Yii::$app->request->get('telephone', "");
        $country = Yii::$app->request->get('country', "");
        $address = Yii::$app->request->get('address', "");
        $industry = Yii::$app->request->get('industry', "");
        $wechatNO = Yii::$app->request->get('wechatNO', "");
        $email = Yii::$app->request->get('email', "");

        $result = Yii::$app->api->get('/video/save-adcenter',['type' => $type,'realname' => $realname,'telephone' => $telephone,
            'country'=>$country, 'address'=>$address, 'industry'=>$industry,'wechatNO'=>$wechatNO,'email'=>$email]);
        return Tool::responseJson(0, '提交成功', $result);
    }

    /*
     * PC端手机、邮箱登录
     */
    public function actionLogin(){
        $account = Yii::$app->request->get('account', "");//手机或邮箱
        $password = Yii::$app->request->get('password', "");
        $is_email = Tool::isEmail($account);//验证邮箱格式
        if($is_email){
            //邮箱登录
            $result = Yii::$app->api->get('/user/email-weblogin',['email' => $account,'password' => $password]);
        }else{
            //手机登录
            $result = Yii::$app->api->get('/user/mobile-weblogin',['mobile' => $account,'password' => $password]);
        }
        return Tool::responseJson(0, '提交成功', $result);
    }

    /*
     * PC端手机短信验证码注册
     */
    public function actionRegister(){
        $mobile_areacode = Yii::$app->request->get('mobile_areacode', "");
        $mobile = Yii::$app->request->get('mobile', "");
        $code = Yii::$app->request->get('code', "");
//        $password = Yii::$app->request->get('newpwd', "");
        $password = '111111';

        $redis = new RedisStore();
        $key = 'SMScode'.$mobile_areacode.$mobile;
        if($redis->get($key) && $redis->get($key)==$code){
            $result = Yii::$app->api->get('/user/message-register',['mobile' => $mobile,'mobile_areacode'=>$mobile_areacode,'password'=>$password]);
            if($result['errno']==0){
                $model = new LoginForm();
                $model->mobile = $mobile;
                $model->password = $password;
                $model->flag = 1;
                if ( $model->login()) {
                    Yii::$app->cache->set('login_flag', '1');
                }
                $uid = Yii::$app->user->id;
                $result['uid'] = $uid;
                $cookie1 = \Yii::$app->request->cookies;
                $uid1=$cookie1->get("uid");
                if(!$uid1){
                    $cookie = new \yii\web\Cookie();
                    $cookie -> name = 'uid';        //cookie的名称
                    $cookie -> expire = time() + 3600*24;	   //存活的时间
                    $cookie -> httpOnly = false;		   //无法通过js读取cookie
                    $cookie -> value = $uid;   //cookie的值
                    $cookie -> secure = false; //不加密
                    \Yii::$app->response->getCookies()->add($cookie);
                }
                $errno = 0;
                $msg = '操作成功';
            }else{
                $errno = -1;
                $msg = '注册失败';
                $uid = '';
            }
        }else{
            $errno = -1;
            $msg = '短信验证码输入错误';
            $uid = '';
        }

        return Tool::responseJson($errno,$msg,$uid);
    }

    /*
     * PC端用户修改密码
     */
    public function actionModifyPassword(){
        $mobile = Yii::$app->request->get('mobile', "");//手机
        $password = Yii::$app->request->get('newpwd', "");

        $data = Yii::$app->api->get('/user/new-modify-password',['mobile'=>$mobile, 'password' => $password]);

        return Tool::responseJson($data['error'], $data['msg'], $data);
    }

    /*
     * PC端用户修改邮箱
     */
    public function actionModifyEmail(){
        $mobile = Yii::$app->request->get('mobile', "");//手机
        $email = Yii::$app->request->get('email', "");//邮箱
//        $password = Yii::$app->request->get('newpwd', "");
        $is_email = Tool::isEmail($email);//验证邮箱格式
        if($is_email){
            $data = Yii::$app->api->get('/user/modify-email',['email'=>$email, 'mobile' => $mobile]);
        }else{
            $data['errno'] = -1;
            $data['msg'] = '您输入的邮箱格式不正确';
        }
        return Tool::responseJson($data['error'], $data['msg'], $data);
    }

    //个人中心
    public function actionPersonal(){
        $pageTab = 'personal';

        $ptab = Yii::$app->request->get('ptab', "");
        $uid = Yii::$app->user->id;
        if(!$uid){
            return $this->redirect('/video/index');
        }
        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');
        //获取热搜
        $hotword = Yii::$app->api->get('/search/hot-word');
        //个人中心信息
        $data['watchlog'] = Yii::$app->api->get('/video/watchlog-pc',['uid'=>$uid]);
        $data['favorite'] = Yii::$app->api->get('/video/favorite-pc',['uid'=>$uid]);
        $comment = Yii::$app->api->get('/user/comment-pc',['uid'=>$uid]);
        if($comment){
            $data = array_merge($data,$comment);
        }
        $relations = Yii::$app->api->get('/user/relations-pc',['uid'=>$uid]);
        if($relations){
            $data = array_merge($data,$relations);
        }

        $uservip = Yii::$app->api->get('/user/userinfo',['uid'=>$uid]);
        if($uservip['user']){
            $data['user'] = $uservip['user'];
        }
        //任务
//        $task = Yii::$app->api->get('/task/center');

        return $this->render('newframe',[
            'pageTab'  => $pageTab,
            'channels' => $channels,
            'hotword'  => $hotword,
            'data'     => $data,
            'ptab'      => $ptab,
//            'task'     => $task
        ]);
    }

    /*
     * 查vip
     * 根据id查光看记录、消息
     */
    public function actionUservip(){
        $uid = Yii::$app->user->id;
        $vip = Yii::$app->api->get('/user/uservip',['uid'=>$uid]);
        if($vip){
            $errno = 0;
        }else{
            $errno = -1;
        }
        return TOOL::responseJson($errno,"操作成功",$vip);
    }

    /*
     * 删除播放记录
     */
    public function actionRemoveWatchlog(){
        $uid = Yii::$app->user->id;
        $logId = Yii::$app->request->get('logid', "");//多个id,以逗号(,)拼接
        $result = Yii::$app->api->get('/video/remove-watchlog',['uid'=>$uid,'logid'=>$logId]);
        return TOOL::responseJson(0,"操作成功",$result);
    }

    /*
     * 添加播放记录
     */
    public function actionAddWatchlog(){
        $uid = Yii::$app->user->id;
        $video_id = Yii::$app->request->get('video_id', 0);
        $chapter_id = Yii::$app->request->get('chapter_id', 0);
        $watchTime = Yii::$app->request->get('watchTime', 0);
        $totalTime = Yii::$app->request->get('totalTime', 0);
        $result = Yii::$app->api->get('/video/add-watchlog',['uid'=>$uid,'video_id'=>$video_id,'chapter_id'=>$chapter_id,'watchTime'=>$watchTime,'totalTime'=>$totalTime]);
        return TOOL::responseJson(0,"操作成功",$result);
    }

    /*
     * 搜索播放记录
     * 添加频道分类
     */
    public function actionSearchWatchlog(){
        $uid = Yii::$app->user->id;
        $searchword = Yii::$app->request->get('searchword', "");
        $channel_id = Yii::$app->request->get('channel_id', "");
        $result = Yii::$app->api->get('/video/search-watchlog',['uid'=>$uid,'searchword'=>$searchword,'channel_id'=>$channel_id]);
        if($result){
            $errno = 0;
        }else{
            $errno = -1;
        }
        return TOOL::responseJson($errno,"操作成功",$result);
    }
    /*
     * 收藏条件查询
     */
    public function actionSearchFavorite(){
        $uid = Yii::$app->user->id;
        $searchword  = Yii::$app->request->get('searchword', "");
        $order       = Yii::$app->request->get('order', "");
        $channel     = Yii::$app->request->get('channel', 0);
        $is_finished = Yii::$app->request->get('is_finished', 0);
        $result = Yii::$app->api->get('/video/search-favorite',['uid'=>$uid,'searchword'=>$searchword,
            'order'=>$order,'channel'=>$channel,'is_finished'=>$is_finished]);
        if($result){
            $errno = 0;
        }else{
            $errno = -1;
        }
        return TOOL::responseJson($errno,"操作成功",$result);
    }

    /*
     * 收藏 / 取消收藏
     */
    public function actionChangeFavorite(){
        $uid = Yii::$app->user->id;
        $videoid  = Yii::$app->request->get('videoid', "");
        $result = Yii::$app->api->get('/video/change-favorite',['uid'=>$uid,'videoid'=>$videoid]);
        if($result){
            $errno = 0;
        }else{
            $errno = -1;
        }
        return TOOL::responseJson($errno,"操作成功",$result);
    }

    //个人主页/他人主页
    public function actionOtherHome(){
        $pageTab = 'otherhome';

        $uid = Yii::$app->user->id;
        $other_uid = Yii::$app->request->get('uid', 0);
        if(!$uid){
            return $this->redirect('/video/index');
        }else if($other_uid==0){
            $other_uid = $uid;
        }
        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');
        //获取热搜
        $hotword = Yii::$app->api->get('/search/hot-word');
        //加载个人主页信息
        $data = Yii::$app->api->get('/user/other-home',['uid'=>$uid,'other_uid'=>$other_uid]);
        $data['main_uid'] = $uid;

        return $this->render('newframe',[
            'pageTab'  => $pageTab,
            'channels' => $channels,
            'hotword'  => $hotword,
            'data'     => $data
        ]);
    }

    /*
     * 关注/拉黑 或取消
     */
    public function actionChangeRelations(){
        $type  = Yii::$app->request->get('type', 1);
        if($type==3){//粉丝（uid和other_uid反着查）
            $other_uid  = Yii::$app->request->get('uid', 0);
            $uid  = Yii::$app->request->get('other_uid', 0);
            $type = 1;
        }else{//黑名单/关注
            $uid = Yii::$app->user->id;
            $other_uid  = Yii::$app->request->get('other_uid', 0);
        }

        $result = Yii::$app->api->get('/user/change-relations',['uid'=>$uid,'other_uid'=>$other_uid,'type'=>$type]);
        if($result){
            $errno = 0;
        }else{
            $errno = -1;
        }
        return TOOL::responseJson($errno,"操作成功",$result);
    }

    /*
     * 点赞
     */
    public function actionAddLikes(){
        $comment_id  = Yii::$app->request->get('id', 0);
        $cal  = Yii::$app->request->get('cal', 'plus');
        $result = Yii::$app->api->get('/user/add-likes',['comment_id'=>$comment_id, 'cal'=>$cal]);
        return TOOL::responseJson(0,"操作成功",$result);
    }
    /*
     * 删除消息
     */
    public function actionRemoveMessage(){
        $uid = Yii::$app->user->id;
        $comment_id  = Yii::$app->request->get('id', 0);
        $type  = Yii::$app->request->get('type', "");
        if($type=="message"){
            $result = Yii::$app->api->get('/user/remove-message',['comment_id'=>$comment_id, 'uid'=>$uid]);
        }else if($type=="comment"){
            $result = Yii::$app->api->get('/user/remove-comment',['comment_id'=>$comment_id]);
        }
        return TOOL::responseJson(0,"操作成功",$result);
    }

    /*
     * 根据条件重新查消息
     */
    public function actionSearchRelation(){
        $uid = Yii::$app->user->id;
        $type  = Yii::$app->request->get('type', 1);
        $order = Yii::$app->request->get('order', 'time');
        $searchword  = Yii::$app->request->get('searchword', '');
        $result = Yii::$app->api->get('/user/search-relation',['uid'=>$uid,'type'=>$type,'order'=>$order,'searchword'=>$searchword]);
        if($result){
            $errno = 0;
        }else{
            $errno = -1;
        }
        return TOOL::responseJson($errno,"操作成功",$result);
    }
    /*
     * 提交评论 / 回复
     */
    public function actionSendComment(){
        $uid = Yii::$app->user->id;
        $video_id = Yii::$app->request->get('video_id', 0);
        $chapter_id = Yii::$app->request->get('chapter_id', 0);
        $content  = Yii::$app->request->get('content', "");
        $pid  = Yii::$app->request->get('pid', 0);
        $result = Yii::$app->api->get('/video/send-comment',['uid'=>$uid,'video_id'=>$video_id,'chapter_id'=>$chapter_id,
            'content'=>$content,'pid'=>$pid]);
        if($result){
            $errno = 0;
        }else{
            $errno = -1;
        }
        return TOOL::responseJson($errno,"操作成功",$result);
    }

    /*
     * 加载评论列表
     */
    public function actionCommentMore(){
        $video_id = Yii::$app->request->get('video_id', 0);
        $chapter_id = Yii::$app->request->get('chapter_id', 0);
        $page_num = Yii::$app->request->get('page_num', 1);
        $order = Yii::$app->request->get('order', 'time');

        $data = Yii::$app->api->get('/video/comment-more', ['video_id' => $video_id, 'chapter_id' => $chapter_id, 'page_num' => $page_num, 'order' => $order]);

        return $this->renderPartial('commentmore', ['data' => $data]);
    }


    /*
     * 加载回复列表
     */
    public function actionReplyMore(){
//        $video_id = Yii::$app->request->get('video_id', 0);
//        $channel_id = Yii::$app->request->get('channel_id', 0);
        $page_num = Yii::$app->request->get('page_num', 1);
        $pid = Yii::$app->request->get('pid', 1);

        $data = Yii::$app->api->get('/video/reply-more', ['pid' => $pid, 'page_num' => $page_num]);
        if($data){
            $errno = 0;
        }else{
            $errno = -1;
        }
        return TOOL::responseJson($errno,"操作成功",$data);
    }

    /*
     * 滚动加载
     */
    public function actionLoadMore(){
        $uid = Yii::$app->user->id;
        $page_num = Yii::$app->request->get('page_num', 1);
        $tab = Yii::$app->request->get('tab', '');
        $searchword = Yii::$app->request->get('searchword', '');
        $order       = Yii::$app->request->get('order', "");
        $channel     = Yii::$app->request->get('channel', 0);
        $is_finished = Yii::$app->request->get('is_finished', 0);
        $type  = Yii::$app->request->get('type', 1);
        $ctype  = Yii::$app->request->get('ctype', "comment");
        $result = [];
        if($tab=="watchlog"){
            //播放记录
            $result = Yii::$app->api->get('/video/search-watchlog',['uid'=>$uid,'searchword'=>$searchword,'page_num'=>$page_num]);
        }else if($tab=="favorite"){
            //收藏
            $result = Yii::$app->api->get('/video/search-favorite',['uid'=>$uid,'searchword'=>$searchword,
                'order'=>$order,'channel'=>$channel,'is_finished'=>$is_finished,'page_num'=>$page_num]);
        }else if($tab=="comment"){
            //消息（评论）
            $result = Yii::$app->api->get('/user/search-comment',['uid'=>$uid,'type'=>$ctype,'page_num'=>$page_num]);
        }else if($tab=="relation"){
            $result = Yii::$app->api->get('/user/search-relation',['uid'=>$uid,'type'=>$type,'order'=>$order,'searchword'=>$searchword,'page_num'=>$page_num]);
        }
        if($result){
            $errno = 0;
        }else{
            $errno = -1;
        }
        return TOOL::responseJson($errno,"操作成功",$result);
    }
    /*
     * 查用户信息
     */
    public function actionUserinfo(){
        $uid = Yii::$app->request->get('uid', 0);
        $result = Yii::$app->api->get('/user/userinfo',['uid'=>$uid]);
        if($result){
            $errno = 0;
        }else{
            $errno = -1;
        }
        return TOOL::responseJson($errno,"操作成功",$result);
    }

    /*
     * 右上角导航-用户相关信息
     */
    public function actionUserall(){
        $uid = Yii::$app->request->get('uid', 0);
        //用户信息
        $user = Yii::$app->api->get('/user/userinfo',['uid'=>$uid]);
        $data = [];
        $data['main_uid'] = $uid;
        if($uid){
//            $errno = 0;
            $data['login_show'] = '';
            $data['notlogin_show'] = 'display:none';
            $data['user'] = $user['user'];
            $data['vip'] = $user['vip'];
            $data['isvip'] = $user['isvip'];
        }else{
//            $errno = -1;
            $data['login_show'] = 'display:none';
            $data['notlogin_show'] = '';
            $data['user'] = [];
            $data['vip'] = [];
            $data['isvip'] = 0;
        }

        //播放记录
        $watchlog = Yii::$app->api->get('/video/watchlog-pc',['uid'=>$uid]);
        if($watchlog){
            $data['watchlog'] = $watchlog;
        }
        //收藏
        $favorite = Yii::$app->api->get('/video/favorite-new',['uid'=>$uid]);
        if($favorite){
            $data['favorite'] = $favorite;
        }

        //消息
        $message = Yii::$app->api->get('/user/message-pc',['uid'=>$uid]);
        if($message){
            $data['message'] = $message;
        }

//        return TOOL::responseJson(0,"操作成功",$result);
        return $this->renderPartial('rheadnavi', ['data' => $data]);
    }
    /*
     * 删除右上角导航收藏消息
     */
    public function actionRemoveFmes(){
        $uid = Yii::$app->user->id;
        $data = Yii::$app->api->get('/video/remove-fmes',['uid'=>$uid]);

        return TOOL::responseJson(0,"操作成功",$data);
    }
    /*
     * 首页和频道页，详情里的收藏
     * 根据uid和videoId查收藏
     */
    public function actionUserFavorite(){
        $uid = Yii::$app->user->id;
        $videoId = Yii::$app->request->get('videoId', 0);

        $data = Yii::$app->api->get('/video/user-favorite',['uid'=>$uid,'videoId'=>$videoId]);
        $return = -1;
        if($data){
            $return = 1;
        }

        return TOOL::responseJson(0,"操作成功",$return);
    }
    /*
     * 根据chapterId查线路
     */
    public function actionChapterSources(){
        $uid = Yii::$app->user->id;
        $chapterId = Yii::$app->request->get('chapterId', 0);
        $data = Yii::$app->api->get('/video/chapter-sources',['uid'=>$uid,'chapterId'=>$chapterId,]);
        if($data){
            $errno = 0;
        }else{
            $errno = -1;
        }
        return TOOL::responseJson($errno,"操作成功",$data);
    }
    /*
     * 根据三字码，查city，返回对应广告信息
     * 同时根据chapterId查线路
     */
    public function actionAdvertInfo(){
        $uid = Yii::$app->user->id;
        $citycode = Yii::$app->request->get('citycode', 0);//城市三字码
        $page = Yii::$app->request->get('page', '');
        $chapterId = Yii::$app->request->get('chapterId', 0);

        $data = [];
        //查城市
        $citylist = Yii::$app->api->get('/video/city-info', ['citycode' => $citycode]);

        if($citylist){
            $city = $citylist['city_name'];
        }else{
            $city = '';
        }

        //查广告
        $advert = Yii::$app->api->get('/video/advert', ['page' => $page, 'city'=> $city]);
        if($advert){
            $data['advert'] = $advert['advert'];
        }

        //查线路
        $sources = Yii::$app->api->get('/video/chapter-sources',['uid'=>$uid,'chapterId'=>$chapterId,]);
        if($sources){
            $data['sources'] = $sources;
        }
        if($data){
            $errno = 0;
        }else{
            $errno = -1;
        }
        return TOOL::responseJson($errno,"操作成功",$data);
    }
    /*
     * 发送验证码
     */
    public function actionSendCode(){
        $mobile_areacode = Yii::$app->request->get('mobile_areacode', "");
        $mobile = Yii::$app->request->get('mobile', "");
        $result = Yii::$app->api->get('/user/send-code',['mobile'=>$mobile,'mobile_areacode'=>$mobile_areacode]);
        if($result){
            $errno = $result['errno'];
            $msg = $result['msg'];
        }else{
            $errno = -1;
            $msg = '发送失败';
        }
        return TOOL::responseJson($errno,$msg,$result);
    }

    /*
     * 验证
     */
    public function actionValiCode(){
        $mobile_areacode = Yii::$app->request->get('mobile_areacode', "");
        $mobile = Yii::$app->request->get('mobile', "");
        $code = Yii::$app->request->get('code', "");

        $redis = new RedisStore();
        $key = 'SMScode'.$mobile_areacode.$mobile;
        if($redis->get($key) && $redis->get($key)==$code){
            $errno = 0;
            $msg = '操作成功';
        }else{
            $errno = -1;
            $msg = '短信验证码输入错误';
        }
        return Tool::responseJson($errno,$msg,$msg);
    }
}
