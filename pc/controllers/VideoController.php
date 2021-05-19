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
//        $ip = Tool::getIp();
        $ip = "203.220.95.25";
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

        if(!$data) {
            return $this->redirect('/site/error');
        }
        $view = Yii::$app->view->params['isIndex'] = '1';
        return $this->render('newindex',[
            'data'          => $data,
            'channels'      => $channels,
            'channel_id'    => $channel_id,
            'hotword'       => $hotword,
            'tick'          => $tick,
            'tvpath'        => $version['tvdata'],
            'city'=> $city
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
//        $ip = Tool::getIp();
        $ip = "203.220.95.25";
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
//        $ip = Tool::getIp();
        $ip = "203.220.95.25";
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
//        $ip = Tool::getIp();
        $ip = "203.220.95.25";
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
//        $ip = Tool::getIp();
        $ip = "203.220.95.25";
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

        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');
        $city = "";
        $redis = new RedisStore();
//        $ip = Tool::getIp();
        $ip = "203.220.95.25";
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
        $data = Yii::$app->api->get('/video/info', ['video_id' => $video_id, 'chapter_id'
            => $chapter_id, 'source_id' => $source_id, 'city'=> $city]);

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
        $data['info']['next_chapter'] = ArrayHelper::index($souceVideos, 'chapter_id')[$data['info']['play_chapter_id']]['next_chapter'];
        $data['info']['last_chapter'] = ArrayHelper::index($souceVideos, 'chapter_id')[$data['info']['play_chapter_id']]['last_chapter'];
        return $this->render('newframe', [
            'pageTab'       => $pageTab,
            'data'          => $data,
            'channels'      => $channels,
            'hotword'       => $hot,
            'source_id'     => $source_id,
            'channel_id'    => $channel_id,
            'city'=> $city
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
     * 视频筛选接口new
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


    /**
     * 新搜索结果页
     **/
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
//        $ip = Tool::getIp();
        $ip = "203.220.95.25";
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
}
