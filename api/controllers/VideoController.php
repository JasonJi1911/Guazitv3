<?php
namespace api\controllers;

use api\dao\CommonDao;
use api\dao\RecommendDao;
use api\dao\UserDao;
use api\dao\VideoDao;
use api\exceptions\ApiException;
use api\helpers\ErrorCode;
use api\helpers\Common;
use api\logic\ChannelLogic;
use api\logic\CommentLogic;
use api\logic\PayLogic;
use api\logic\UserLogic;
use api\logic\VideoLogic;
use api\logic\AdvertLogic;
use api\models\user\UserRelations;
use api\models\video\Recommend;
use api\models\video\UserWatchLog;
use api\models\advert\AdvertPosition;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use common\models\video\VideoFeed;
use Yii;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

class VideoController extends BaseController
{
    /**
     * 频道栏
     * @return mixed
     */
    public function actionChannels()
    {
        // 筛选字段
        $fields = ['channel_id', 'channel_name','icon','icon_gray'];

        $commonDao = new CommonDao();
        $channelList = $commonDao->videoChannel($fields);
        $data['list'] = [];
//        $data['list'] = $channelList;

        /* 在原频道列表基础上对应加类型 begin */
        $channelLogic = new ChannelLogic();
        $data['channeltags'] = [];
        $VideoDao = new VideoDao();
        foreach ($channelList as $channel) {
            // 获取频道对应的分类数据
            $tagFields = ['cat_id', 'name','channel_id'];
            $channelTags = $channelLogic->channelCategory($channel['channel_id'], $tagFields);
            $channel['tags'] = $channelTags;
            array_push($data['channeltags'], $channel);
            /* 查询每个频道24小时内的更新剧集数 begin */
            //表video 以上架时间为准
            $channelNum = $VideoDao->findVideoNumByChannelId($channel['channel_id']);
            $channel['num'] = $channelNum;
            array_push($data['list'], $channel);
            /* 查询每个频道24小时内的更新剧集数 end */
        }
        /* 在原频道列表基础上对应加类型 end */
        $videoLogic = new VideoLogic();
        $data['hot_word'] =  $videoLogic->searchWord();;

        // 添加热门分类
        array_unshift($data['list'], ['channel_id' => 0, 'channel_name' => '首页']);

        //所有密保问题信息
        $feedbackinfo = $VideoDao->findFeedbackinfo();
        $data['question_info'] = $feedbackinfo['question'];
        $data['country_info'] = $feedbackinfo['country'];

        //登录左侧广告
        if(Yii::$app->common->product == Common::PRODUCT_PC ){
            $advertLogic = new AdvertLogic();
            $advert = $advertLogic->advertByPosition(AdvertPosition::POSITION_VIDEO_LOGIN_PC, '');
            if($advert){
                $data['login_advert'] = $advert;
            }
        }

        return $data;
    }

    /**
     * 首页&频道首页
     * @return array
     * @throws \api\exceptions\InvalidParamException
     */
    public function actionIndex()
    {

        $channelId = $this->getParamOrFail('channel_id');
        $uid = $this->getParam('uid', 0);

        $city = $this->getParam('city');

        $data = [];

        // 获取banner数据
        $bannerFields = ['title','action', 'content', 'image','stitle'];
        $videoDao= new VideoDao();

        $banner = $videoDao->banner($channelId, $bannerFields,$city);
        $data['banner'] = $banner;
        // $channelId == 0 时返回首页数据

        $channelLogic = new ChannelLogic();
        if ($channelId == 0) {
            $channelData = $channelLogic->channelIndexData($city,$uid);
        } else {
            $channelData = $channelLogic->channelLabelData($channelId,$city);
        }

        $data = array_merge($data, $channelData);
        return $data;
    }


    /**
     * 首页&频道首页banner图
     * @return array
     * @throws \api\exceptions\InvalidParamException
     */
    public function actionBanner()
    {

        $channelId = $this->getParamOrFail('channel_id');

        $city = $this->getParam('city');

        $data = [];

        // 获取banner数据
        $bannerFields = ['title','action', 'content', 'image','stitle'];
        $videoDao= new VideoDao();

        $banner = $videoDao->banner($channelId, $bannerFields, $city);
        $data['banner'] = $banner;

        return $data;
    }

    /**
     * 广告
     * @return array
     * @throws \api\exceptions\InvalidParamException
     */
    public function actionAdvert()
    {

        $page = $this->getParam('page');
        $city = $this->getParam('city');

        $uid = $this->getParam('uid', 0);
        $citycode = $this->getParam('citycode', "");
        $videodao = new VideoDao();
        $citylist = $videodao->findcity($citycode);
        if($citylist){
            $city = $citylist['city_name'];
        }else{
            $city = '';
        }
        // 获取广告
        $advertLogic = new AdvertLogic();
        //        $advert = $advertLogic->advertByPosition(AdvertPosition::POSITION_VIDEO_INDEX);
        $adposition = Yii::$app->common->product == Common::PRODUCT_PC
            ? AdvertPosition::POSITION_VIDEO_INDEX_PC : AdvertPosition::POSITION_VIDEO_INDEX;
        $flashPos = Yii::$app->common->product == Common::PRODUCT_PC
            ? AdvertPosition::POSITION_FLASH_PC : AdvertPosition::POSITION_FLASH_WAP;

        $playbeforePos = Yii::$app->common->product == Common::PRODUCT_PC
            ? AdvertPosition::POSITION_PLAY_BEFORE_PC : AdvertPosition::POSITION_PLAY_BEFORE;
        $videoTopPos = Yii::$app->common->product == Common::PRODUCT_PC
            ? AdvertPosition::POSITION_VIDEO_TOP_PC : AdvertPosition::POSITION_VIDEO_TOP_PC;
        $videoBottomPos = Yii::$app->common->product == Common::PRODUCT_PC
            ? AdvertPosition::POSITION_VIDEO_BOTTOM_PC : AdvertPosition::POSITION_VIDEO_BOTTOM_PC;

        $advertChannel = Yii::$app->common->product == Common::PRODUCT_PC
            ? AdvertPosition::POSITION_VIDEO_CHANNEL_PC1 : AdvertPosition::POSITION_VIDEO_CHANNEL_WAP;

        $advertPlayStop = Yii::$app->common->product == Common::PRODUCT_PC
            ? AdvertPosition::POSITION_PLAY_STOP_PC : AdvertPosition::POSITION_PLAY_STOP_WAP;

        $data = [];
        $data['page'] = $page;
        $data['city'] = $city;

        if ($page == "home") {
            $advert = $advertLogic->advertByPosition($adposition, $city);
            $data['advert'] = $advert;

            $flash = $advertLogic->advertByPosition($flashPos, $city);
            $data['flash'] = $flash;
        } else if($page == "detail"){
            $data['advert'] = [
//                'playbefore' => (object)$advertLogic->advertByPosition($playbeforePos, $city),
                'playtop' => (object)$advertLogic->advertByPosition(AdvertPosition::POSITION_PLAY_STOP, $city),
                'playliketop' => (object)$advertLogic->advertByPosition(AdvertPosition::POSITION_LIKE_TOP, $city),
                'playlikebottom' => (object)$advertLogic->advertByPosition(AdvertPosition::POSITION_LIKE_BOTTOM, $city),
                'videotop' => (object)$advertLogic->advertByPosition($videoTopPos, $city),
                'videobottom' => (object)$advertLogic->advertByPosition($videoBottomPos, $city),
                'videoright' => (object)$advertLogic->advertByPosition(AdvertPosition::POSITION_VIDEO_RIGHT_PC, $city),
                'playstop' => (object)$advertLogic->advertByPosition($advertPlayStop, $city)
            ];
            //2022-04-22尹 播放器广告，会员不加载
            $userdao = new UserDao();
            $vip = $userdao->validuservipPC($uid);
            if(!$vip){// 不是会员，有广告
                $data['advert']['playbefore'] = (object)$advertLogic->advertByPosition($playbeforePos, $city);
            }else{
                $data['advert']['playbefore'] = [];
            }
        }else if($page == "searchresult"){
            $advert = $advertLogic->advertByPosition(AdvertPosition::POSITION_VIDEO_SEARCH_PC, $city);
            $data['advert'] = $advert;
        }else if($page == "list"){
            $advert = $advertLogic->advertByPosition(AdvertPosition::POSITION_VIDEO_LIST_PC, $city);
            $data['advert'] = $advert;
        }else if($page == "channel"){
            $data['advert'] = $advertLogic->advertByPosition($advertChannel, $city);
        }
        return $data;
    }



    /**
     * 视频筛选
     * @return array
     */
    public function actionFilter()
    {
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

        // 筛选项
        $data = [];
        // 当请求为第一页时，返回筛选页头部信息
        if ($page == 1) {
            $videoLogic = new VideoLogic();
            $data = $videoLogic->filterHeader($channelId, $sort, $tag, $area, $year, $type, $playLimit);
        }
        // 根据条件取视频信息
        $videoDao = new VideoDao();
        $video = $videoDao->filterVideoList($channelId, $sort, $tag, $area, $year, $type, $playLimit, $page, $pageSize);

        $data = array_merge($data, $video);
        return $data;
    }

    /**
     * 视频筛选
     * @return array
     */
    public function actionFilters()
    {
        $channelId = $this->getParam('channel_id', ''); // 频道
        $sort      = $this->getParam('sort', 'new'); // 排序
        $sorttype  = $this->getParam('sorttype', 'desc'); // 排序高低
        $tag       = $this->getParam('tag', ''); // 标签
        $area      = $this->getParam('area', ''); // 地区
        $year      = $this->getParam('year', ''); // 年代
        $page      = $this->getParam('page_num', DEFAULT_PAGE_NUM); // 页面 当传入1时，返回检索项
        $pageSize  = $this->getParam('page_size', 10);
        $type      = $this->getParam('type', 0); // 类型 当传入1时，位点击分类进入，服务端要返回所有频道筛选项
        $playLimit = $this->getParam('play_limit', '');
        $status    = $this->getParam('status', 0); // 剧集是否完结：全部 / 更新中

        $area      = !empty($area) ? $area : '';
        $year      = !empty($year) ? $year : '';
        $tag       = !empty($tag) ? $tag : '';
        $playLimit = !empty($playLimit) ? $playLimit : '';
        $channelId = !empty($channelId) ? $channelId : '';

        $videoDao = new VideoDao();
        //year==''或0（全部），默认显示最新年份
//        $year = $videoDao->findMaxYear($year);
        // 筛选项
        $data = [];
        // 当请求为第一页时，返回筛选页头部信息
        if ($page == 1) {
            $videoLogic = new VideoLogic();
            $data = $videoLogic->filterHeaders($channelId, $sort, $tag, $area, $year, $type, $playLimit, $status);
        }
        // 根据条件取视频信息
        $video = $videoDao->filterVideoList2($channelId, $sort, $sorttype, $tag, $area, $year, $type, $playLimit, $page, $pageSize, $status);

        $data = array_merge($data, $video);
        return $data;
    }

    /**
     * 离线缓存视频
     */
    public function actionDown()
    {
        $videoId   = $this->getParamOrFail('video_id');  //视频id
        $chapterId = $this->getParamOrFail('chapter_id');  //视频id

        if (!$chapterId) {
            throw new ApiException(ErrorCode::EC_PARAM_INVALID);
        }
        $chapterId = explode(',', $chapterId);
        $videoLogic = new VideoLogic();
        return $videoLogic->down($videoId, $chapterId);
    }

    /**
     * 换一换
     * @return array
     * @throws \api\exceptions\InvalidParamException
     */
    public function actionRefresh()
    {
        $recommendId = $this->getParamOrFail('recommend_id');

        $recommendDao = new RecommendDao();
        $recommendInfo = $recommendDao->getRecommend($recommendId);
        $search = json_decode($recommendInfo['search'], true);

        // 检索
        $where = ['and', ['channel_id' => $recommendInfo['channel_id']]];

        foreach ($search as $item) {
            if ($item['field'] == 'tag') {
                $where[] = ['like', 'category_ids', $item['value']];
            } else {
                $where[] = [$item['field'] => $item['value']];
            }
        }

        // 获取缓存的影视
        $videoDao = new VideoDao();
        $fields = ['video_id', 'video_name', 'score', 'tag', 'flag', 'play_times', 'cover', 'horizontal_cover', 'intro'];

        // return $videoDao->refreshVideo($where, $fields, Recommend::$selectLimit[$recommendInfo['style']]);
        return $videoDao->refreshVideo($where, $fields, 9);
    }

    /**
     * 视频详情
     * @return array
     * @throws ApiException
     * @throws \api\exceptions\InvalidParamException
     */
    public function actionInfo()
    {
        $videoId   = $this->getParamOrFail('video_id');
        $chapterId = $this->getParam('chapter_id');
        $sourceId  = $this->getParam('source_id');

        $city = $this->getParam('city');
        $uid = $this->getParam('uid');
        // 不传入id则设置为空
        $chapterId = $chapterId ? $chapterId : '';

        $videoLogic = new VideoLogic();
        // return $videoLogic->playInfo($videoId, $chapterId, $sourceId);
        return $videoLogic->playInfo($videoId, $chapterId, $sourceId, $city, $uid);
    }

    /*
     * 20220601 尹 局部刷新播放器
     */
    public function actionInfoPart()
    {
        $videoId   = $this->getParamOrFail('video_id');
        $chapterId = $this->getParam('chapter_id');
        $sourceId  = $this->getParam('source_id');

        $city = $this->getParam('city');//城市三字码
        $uid = $this->getParam('uid');
        $last_chapter_id = $this->getParam('last_chapter_id');

        // 不传入id则设置为空
        $chapterId = $chapterId ? $chapterId : '';
        //加载城市
        $videodao = new VideoDao();
        if(!empty($city)){
            $citylist = $videodao->findcity($city);
            if($citylist){
                $city = $citylist['city_name'];
            }else{
                $city = '';
            }
        }

        //jianghu2信息
        $videoLogic = new VideoLogic();
        //$chapterId -- 要跳转的 chapterId
        //$last_chapter_id -- 上次播放的chapterId
        $data = $videoLogic->playInfoPart($videoId, $chapterId, $sourceId, $city, $uid, $last_chapter_id);

        //2022-04-22尹 播放器广告，会员不加载
        $userdao = new UserDao();
        $vip = $userdao->validuservipPC($uid);
        if(!$vip){// 不是会员，有广告
            $data['isvip'] = 0;
        }else{
            $data['isvip'] = 1;
        }
        return $data;
    }

    /**
     * 我的观影记录
     */
    public function actionUserWatchLog()
    {
        $uid = Yii::$app->user->id;
        if (empty($uid)) {
            return [];
        }
        /** @var UserWatchLog $logInfo */
        $logInfo = UserWatchLog::find()->where(['uid' => $uid])->orderBy('updated_at desc')->one();
        if (empty($logInfo)) {
            return [];
        }
        $arrLogInfo = $logInfo->toArray();
        // 获取影视信息
        $videoDao = new VideoDao();
        $videoInfo = $videoDao->videoInfo($logInfo['video_id'], ['video_id', 'video_name']);
        if (empty($videoInfo)) {
            return [];
        }
        // 获取影视剧集信息
        $videoChapter = $videoDao->videoChapter($logInfo['video_id'], ['chapter_id','title'], true);
        $chapterInfo  = $videoChapter[$logInfo['chapter_id']];
        if (empty($chapterInfo)) {
            return [];
        }

        // 合并数据
        $data = array_merge($arrLogInfo, $videoInfo, $chapterInfo);

        $data['title'] = $videoInfo['video_name'] . ' ' . $chapterInfo['title'] . ' ' . $logInfo['time'];

        return $data;
    }

    /**
     * 购买选项
     * @return array
     * @throws ApiException
     * @throws \api\exceptions\InvalidParamException
     */
    public function actionBuyOption()
    {
        $videoId = $this->getParamOrFail('video_id');
        $videoLogic = new VideoLogic();
        return $videoLogic->buyOption($videoId);
    }

    /**
     * 确认购买
     * @return bool
     * @throws ApiException
     * @throws \api\exceptions\InvalidParamException
     */
    public function actionBuyConfirm()
    {
        $videoId = $this->getParamOrFail('video_id');
        $uid = Yii::$app->user->id;
        // 上锁
        $lockKey = RedisKey::getApiLockKey('video/buy-confirm', ['uid' => $uid, 'video_id' => $videoId]);
        $redis = new RedisStore();
        if ($redis->checkLock($lockKey)) {
            throw new ApiException(ErrorCode::EC_SYSTEM_OPERATING);
        }

        $videoDao = new VideoDao();
        $videoInfo = $videoDao->videoInfo($videoId);
        if (empty($videoInfo)) {
            $redis->releaseLock($lockKey);
            throw new ApiException(ErrorCode::EC_VIDEO_NOT_EXIST);
        }

        $payLogic = new PayLogic();
        $res = $payLogic->consumeCoupon($uid, $videoInfo['total_price'], $videoId);
        // 释放锁
        $redis->releaseLock($lockKey);

        return $res;
    }

    /**
     * 章节目录
     * @return array
     * @throws ApiException
     * @throws \api\exceptions\InvalidParamException
     */
    public function actionChapter()
    {
        $videoId = $this->getParamOrFail('video_id');
        $videoDao = new VideoDao();

        $videoInfo = $videoDao->videoInfo($videoId);

        // 获取影片剧集信息
        $videos = $videoDao->videoChapter($videoId, []);
        if (!$videos) { // 没有剧集抛出异常
            throw new ApiException(ErrorCode::EC_VIDEO_CHAPTER_NOT_EXIST);
        }
        // 格式化章节信息
        foreach ($videos as $key => &$video) {
            $video['cover']         = $videoInfo['cover'];
            //$video['download_name'] = md5($videoInfo['video_name'] . ' ' . $video['title']) . '.' . substr(strrchr($video['resource_url'][$sourceId], '.'), 1);
            $video['mime_type']     = substr(strrchr(reset($video['resource_url']), '.'), 1);
            $video['last_chapter']  = isset($videos[$key-1]) ? $videos[$key-1]['chapter_id'] : 0;
            $video['next_chapter']  = isset($videos[$key+1]) ? $videos[$key+1]['chapter_id'] : 0;
            unset($video['resource_url']); // 安全考虑，删除剧集播放连接，防止全部播放连接一次性全返回
        }

        return $videos;
    }

    /**
     * vip 列表
     * @return array
     */
    public function actionVip()
    {
        $channelId = $this->getParam('channel_id');
        $channelId = $channelId ? $channelId : '';

        $videoLogic = new VideoLogic();
        return $videoLogic->vipList($channelId);
    }

    public function actionFeedBack()
    {
        $video_id = $this->getParam('video_id', "");
        $chapter_id = $this->getParam('chapter_id', "");
        $source_id = $this->getParam('source_id', "");
        $ip = $this->getParam('ip', "");
        $reason = $this->getParam('reason', "");

        $feed_back = new VideoFeed();
        $feed_back->video_id = $video_id;
        $feed_back->chapter_id = $chapter_id;
        $feed_back->source_id = $source_id;
        $feed_back->ip = $ip;
        $feed_back->reason = $reason;

        $info = $feed_back::find()->andWhere(['video_id'=>$video_id, 'chapter_id'=>$chapter_id
            , 'source_id'=>$source_id, 'ip'=>$ip, 'reason'=>$reason])->asArray()->all();

        $result = [];
        if (!$info)
        {
            $feed_back->save();
            $result['status'] = 0;
            $result['message'] = '报错成功';
        }
        else
        {
            $result['status'] = 1;
            $result['message'] = '您已经报错过该视频，请不要重复提交';
        }
        return $result;
    }

    /*
     * 求片-查询频道和地区
     */
    public function actionSeek(){
        $videoDao = new VideoDao();
        $data = $videoDao->findAreasAndChannels();
        return $data;
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
        $video_name    = $this->getParam('video_name',"");
        $channel_id    = $this->getParam('channel_id',0);
        $area_id       = $this->getParam('area_id',0);
        $year          = $this->getParam('year',"");
        $director_name = $this->getParam('director_name',"");
        $actor_name    = $this->getParam('actor_name',"");
        $uid = $this->getParam('uid',0);
        $videoDao = new VideoDao();
        $result = $videoDao->saveSeekInfo($video_name,$channel_id,$area_id,$year,$director_name,$actor_name,$uid);
        return $result;
    }

    /*
     * 查询反馈条件信息
     */
    public function actionFeedbackinfo(){
        $videoDao = new VideoDao();
        $data = $videoDao->findFeedbackinfo();
        return $data;
    }

    /*
     * 保存反馈信息
     */
    public function actionSaveFeedbackinfo(){
        $uid         = $this->getParam('uid',0);
        $country     = $this->getParam('country',0);
        $internets   = $this->getParam('internets',0);
        $systems     = $this->getParam('systems',0);
        $browsers    = $this->getParam('browsers',0);
        $description = $this->getParam('description',"");
        $video_id    = $this->getParam('video_id', 0);
        $chapter_id  = $this->getParam('chapter_id', 0);
        $source_id   = $this->getParam('source_id', 0);
        $videoDao = new VideoDao();
        $result = $videoDao->saveFeedbackinfo($country,$internets,$systems,$browsers,$description,$video_id,$chapter_id,$source_id,$uid);

        return $result;
    }

    /*
     * 获取国家信息
     */
    public function actionGetCountry(){
        $country_code = $this->getParam('country_code',"");
        $country_name = $this->getParam('country_name',"");
        $citycode     = $this->getParam('citycode', "");
        $videoDao = new VideoDao();
        $data = [];
        //查城市
        if(!empty($citycode)){
            $data = $videoDao->findcity($citycode);
        }else{
            $data = $videoDao->findCountryInfo($country_code);
        }

        if(!$data){
            if(PLATFORM=='GZ'){//瓜子城市为空，执行默认城市-澳洲 / 墨尔本
                $data['city_code'] = 'MEL';
                $data['city_name'] = '澳洲';
                if($country_name){
                    $data['country_name'] = $country_name;
                    $data['country_code'] = $country_code;
                }else{
                    $data['country_name'] = "澳洲";
                    $data['country_code'] = "AU";
                }
                $data['imgname'] = "AUgq.png";
            }else if(PLATFORM=='RY'){//如意城市为空，执行默认城市-北美 / 洛杉矶
                $data['city_code'] = 'LAX';
                $data['city_name'] = '北美';
                if($country_name){
                    $data['country_name'] = $country_name;
                    $data['country_code'] = $country_code;
                }else{
                    $data['country_name'] = "美国";
                    $data['country_code'] = "US";
                }
                $data['imgname'] = "USgq.png";
            }
        }
        return $data;
    }
    /*
     * 注册广告商
     */
    public function actionSaveAdcenter(){
        $type = $this->getParam('type', "");
        $realname = $this->getParam('realname', "");
        $telephone = $this->getParam('telephone', "");
        $country = $this->getParam('country', "");
        $address = $this->getParam('address', "");
        $industry = $this->getParam('industry', "");
        $wechatNO = $this->getParam('wechatNO', "");
        $email = $this->getParam('email', "");

        $videoDao = new VideoDao();
        $result = $videoDao->saveAdcenter($type,$realname,$telephone,$country,$address,$industry,$wechatNO,$email);

        return $result;
    }

    /*
     * 我的播放记录
     */
    public function actionWatchlogPc(){
        $uid = $this->getParam('uid', "");
        $videodao = new VideoDao();
        //播放记录
        $result = $videodao->finduserwatchLog($uid,'');
        return $result;
    }
    /*
     * 删除播放记录
     */
    public function actionRemoveWatchlog(){
        $uid = $this->getParam('uid', "");
        $logId = $this->getParam('logid', "");
        $videodao = new VideoDao();
        $result = $videodao->delWatchLogByuidPC($uid,$logId);
        return $result;
    }
    /*
     * 添加播放记录
     */
    public function actionAddWatchlog(){
        $uid = $this->getParam('uid', 0);
        $video_id = $this->getParam('video_id', 0);
        $chapter_id = $this->getParam('chapter_id', 0);
        $watchTime = $this->getParam('watchTime', 0);
        $totalTime = $this->getParam('totalTime', 0);

        $videodao = new VideoDao();
        $result = $videodao->addWatchLogPC($uid, $video_id, $chapter_id, $watchTime,$totalTime);
        return $result;
    }
    /*
     * 搜索播放记录
     */
    public function actionSearchWatchlog(){
        $uid = $this->getParam('uid', 0);
        $searchword = $this->getParam('searchword', "");
        $channel_id = $this->getParam('channel_id', 0);
        $page_num = $this->getParam('page_num', 1);
        $videodao = new VideoDao();
        $result = $videodao->finduserwatchLog($uid, $searchword,$page_num,$channel_id);
        return $result;
    }

    /*
     * 我的收藏(PC)
     */
    public function actionFavoritePc(){
        $uid = $this->getParam('uid', "");
        $videodao = new VideoDao();
        //收藏
        $result = $videodao->findVideoFavorite($uid);
        return $result;
    }
    /*
     * 收藏条件查询(PC)
     */
    public function actionSearchFavorite(){
        $uid = $this->getParam('uid', 0);
        $searchword  = $this->getParam('searchword', "");
        $order       = $this->getParam('order', "");
        $channel     = $this->getParam('channel', 0);
        $is_finished = $this->getParam('is_finished', 0);
        $page_num = $this->getParam('page_num', 1);

        $videodao = new VideoDao();
        $result = $videodao->findVideoFavoriteBycondition($uid,$searchword,$order,$channel,$is_finished,$page_num);
        return $result;
    }
    /*
     * 收藏(wap)
     */
    public function actionFavoriteWap(){
        $uid = $this->getParam('uid', 0);
        $page_num = $this->getParam('page_num', 1);

        $videodao = new VideoDao();
        $result = $videodao->findVideoFavoriteWap($uid,$page_num);
        return $result;
    }
    /*
     * 收藏 / 取消收藏
     */
    public function actionChangeFavorite(){
        $uid = $this->getParam('uid', "");
        $videoid  = $this->getParam('videoid', "");
        $videodao = new VideoDao();
        $result = $videodao->favVideoPC($uid,$videoid);
        return $result;
    }

    /*
     * 提交影片评论
     */
    public function actionSendComment()
    {
        $uid = $this->getParam('uid', 0);
        $videoId    = $this->getParam('video_id');
        $chapterId  = $this->getParam('chapter_id');
        $content    = trim($this->getParam('content'));
        $commentPid = $this->getParam('pid', 0);

        $commentLogic = new CommentLogic();
        $res = $commentLogic->postCommentPC($uid, $content, $videoId, $chapterId, $commentPid);
        if($res['is_review']==-1){
            $r['display'] = 0;
            $r['data']    = [];
            $r['message'] = '您的操作过于频繁，请稍后重试';
        }else{
            $r['display'] = $res['is_review'] ? 1 : 0;
            $r['data']    = $res['data'];
            $r['message'] = $res['is_review'] ? '评论成功' : '评论成功,等待审核';
        }

        return $r;
    }


    /*
     * 加载评论列表
     */
    public function actionCommentMore(){
        $video_id = $this->getParam('video_id', 0);
        $chapter_id = $this->getParam('chapter_id', 0);
        $order = $this->getParam('order', 0);
        $page_num = $this->getParam('page_num', 1);
        $page_num = $page_num+1;//取下一页

        $commentLogic = new CommentLogic();
//        $commentList  = $commentLogic->commentList($videoId, $chapterId, 1);
        if($order=='replynum'){//热门评论
            $commentList  = $commentLogic->commentListPCByReply($video_id, $chapter_id, $page_num);
            $data['comments'] = $commentList;
        }else{//全部评论
            $commentList  = $commentLogic->commentListPC($video_id, $chapter_id, $page_num);
            $data['comments'] = $commentList['list'];
            $data['total_page'] = $commentList['total_page'];
            $data['total_comment'] = $commentList['total_comment'];
        }
        return $data;
    }
    /*
     * 加载回复列表
     */
    public function actionReplyMore(){
//        $video_id = $this->getParam('video_id', 0);
//        $channel_id = $this->getParam('channel_id', 0);
        $pid = $this->getParam('pid', 0);
        $page_num = $this->getParam('page_num', 1);
        $page_num = $page_num+1;//取下一页

        $commentLogic = new CommentLogic();
//        $commentList  = $commentLogic->commentList($videoId, $chapterId, 1);
        $replylist  = $commentLogic->getReplyMorePC($pid, $page_num);

        return $replylist;
    }
    /*
     * 右上角通知-收藏
     */
    public function actionFavoriteNew(){
        $uid = $this->getParam('uid', "");
        $videodao = new VideoDao();
        //收藏
        $result = $videodao->findVideoFavoriteNew($uid);
        return $result;
    }

    /*
     * 删除右上角导航收藏消息
     */
    public function actionRemoveFmes(){
        $uid = $this->getParam('uid', "");
        $videodao = new VideoDao();
        $data = $videodao->modifyFavoriteTime($uid);

        return $data;
    }
    /*
     * 根据uid和videoId查收藏
     */
    public function actionUserFavorite(){
        $uid = $this->getParam('uid', "");
        $videoId = $this->getParam('videoId', "");
        $videodao = new VideoDao();
        $data = $videodao->findFavoriteByVideoid($uid,$videoId);

        return $data;
    }
    /*
     * 根据chapterId查线路
     */
    public function actionChapterSources(){
        $uid = $this->getParam('uid', "");
        $chapterId = $this->getParam('chapterId', "");
        $videologic = new VideoLogic();
        $data = $videologic->findSourceByChapterId($uid,$chapterId);
        return $data;
    }

    /*
     * 三字码查city
     */
    public function actionCityInfo(){
        $citycode = $this->getParam('citycode', "");
        $videodao = new VideoDao();
        $city = $videodao->findcity($citycode);
        return $city;
    }

    /*
     * 首页预告
     */
    public function actionTrailer(){
        $channelId = $this->getParam('channel_id', 0);
        $videologic = new VideoLogic();
        $data = $videologic->getTrailerInfo($channelId);
        return $data;
    }

    /*
     * 更新列表
     */
    public function actionVideoUpdate(){
        $channelId = $this->getParam('channel_id', 0);
        $week = $this->getParam('week', "");
        $videologic = new VideoLogic();
        $data = $videologic->getVideoUpdateInfo($channelId,$week);
        return $data;
    }
    /*
     * 瓜子tv展示亿忆分类信息帖子广告接口
     */
    public function actionAdverty(){
        $citycode = $this->getParam('citycode', 0);
        $advertlogic = new AdvertLogic();
        $data = $advertlogic->getAdYY($citycode);
        return $data;
    }
    /*
     * 加载上次播放时间
     */
    public function actionLastPlayinfo(){
        $uid = $this->getParam('uid', 0);
        $video_id = $this->getParam('video_id', 0);
        $chapter_id = $this->getParam('chapter_id', '');
        $videologic = new VideoLogic();
        $data = $videologic->lastPlayInfo($video_id,$chapter_id,$uid);
        if($data['lastPlayTime']){
            $hour = floor($data['lastPlayTime']/3600);
            $second = $data['lastPlayTime']%3600;//除去整小时之后剩余的时间
            $minute = floor($second/60);
            $second = $second%60;//除去整分钟之后剩余的时间
            if($hour<10){
                $data['playtime'] .= '0';
            }
            $data['playtime'] .= $hour.':';
            if($minute<10){
                $data['playtime'] .= '0';
            }
            $data['playtime'] .= $minute.':';
            if($second<10){
                $data['playtime'] .= '0';
            }
            $data['playtime'] .= $second;
        }
        return $data;
    }

    /*
     * 局部刷新获取新闻接口
     */
    public function actionGetNews(){
        $amount = $this->getParam('amount', 0);
        $videologic = new VideoLogic();
        $data = $videologic->getNewsList($amount);
        return $data;
    }

    //加载个人中心信息
    public function actionPersonal(){
        $uid = $this->getParam('uid', "");
        //个人中心信息
        $videodao = new VideoDao();
        $userdao = new UserDao();
        //播放记录
        $data['watchlog'] = $videodao->finduserwatchLog($uid,'');
        //收藏
        $data['favorite'] = $videodao->findVideoFavorite($uid);
        //消息-我发表的（包括我回复的）
        $data['comment'] = $userdao->commentListPC($uid);
        //消息-回复我的（pid==uid）
        $data['reply'] = $userdao->replyListPC($uid);
        //消息-系统信息
        $data['system_message'] = $userdao->messagePC($uid);
        //关注
        $data['follow'] = $userdao->findRelationsByCondition($uid,UserRelations::TYPE_FOLLOW,'time','');
        //黑名单
        $data['blacklist'] = $userdao->findRelationsByCondition($uid,UserRelations::TYPE_BLACKLIST,'time','');
        //粉丝
        $data['fans'] = $userdao->findFansByCondition($uid,'time','');
        //用户信息
        $data['user'] = $userdao->finduserByuid($uid);
        //用户vip信息
        $vip = $userdao->validuservipPC($uid);
        if($vip){
            $data['vip'] = $vip;
            $data['isvip'] = 1;
            $data['desc'] = '会员到期时间' . date('Y-m-d', $vip['end_time']);
        }else{
            $data['isvip'] = 0;
            $data['desc'] = '您还不是vip用户';
        }

        return $data;
    }

    //右上角信息
    public function actionUserall(){
        $uid = $this->getParam('uid', "");
        $videodao = new VideoDao();
        $userdao = new UserDao();
        //用户信息
        $data = [];
        $data['user'] = $userdao->finduserByuid($uid);
        //用户vip信息
        $vip = $userdao->validuservipPC($uid);
        if($vip){
            $data['vip'] = $vip;
            $data['isvip'] = 1;
        }

        //播放记录
        $data['watchlog'] = $videodao->finduserwatchLog($uid,'');
        //收藏
        $data['favorite'] = $videodao->findVideoFavorite($uid);
        //消息
        $data['message'] = $userdao->messagePC($uid);

        $userlogic = new UserLogic();
        $pay = $userlogic->vipInfoWap($uid);

        $data = array_merge($data, $pay);
        return $data;
    }

    /*
     * 彩虹易支付异步回调
     * @return string
     */
    public function actionNewNotify()
    {
        $param = [];
        $param['pid'] = $this->getParam('pid', "");
        $param['trade_no'] = $this->getParam('trade_no', "");
        $param['out_trade_no'] = $this->getParam('out_trade_no', "");
        $param['type'] = $this->getParam('type', "");
        $param['name'] = $this->getParam('name', "");
        $param['money'] = $this->getParam('money', "");
        $param['trade_status'] = $this->getParam('trade_status', "");
        $param['pay_sign'] = $this->getParam('pay_sign', "");
        $param['sign_type'] = $this->getParam('sign_type', "");

        $payLogic = new PayLogic();
        $result = $payLogic->newNotifyurl($param);

        return $result;
    }


    /*
     * 提交订单
     */
    public function actionCreateOrder(){
        $param = [];
        $param['WIDout_trade_no'] = $this->getParam('WIDout_trade_no', 0);
        $param['uid'] = $this->getParam('uid', "");
        $param['WIDsubject'] = $this->getParam('WIDsubject', "");
        $param['WIDtotal_fee'] = $this->getParam('WIDtotal_fee', "");
        $param['type'] = $this->getParam('type', "");
        $param['goodsId'] = $this->getParam('goodsId', "");

        $paylogic = new PayLogic();
        $data = $paylogic->commitOrder($param);

        return $data;
    }
    /*
     * 提交订单(二维码下单)
     */
    public function actionCreateOrderQrcode(){
        $param = [];
        $param['WIDout_trade_no'] = $this->getParam('WIDout_trade_no', 0);
        $param['uid'] = $this->getParam('uid', "");
        $param['WIDsubject'] = $this->getParam('WIDsubject', "");
        $param['WIDtotal_fee'] = $this->getParam('WIDtotal_fee', "");
        $param['type'] = $this->getParam('type', "");
        $param['goodsId'] = $this->getParam('goodsId', "");

        $paylogic = new PayLogic();
        $result = $paylogic->getQrcode($param);

        return $result;
    }

    public function actionPaySign(){
        $param = [];
        $param['pid'] = $this->getParam('pid', "");
        $param['type'] = $this->getParam('type', "");
        $param['out_trade_no'] = $this->getParam('out_trade_no', "");
        $param['notify_url'] = $this->getParam('notify_url', "");
        $param['name'] = $this->getParam('name', "");
        $param['money'] = $this->getParam('money', "");
        $param['pay_sign'] = $this->getParam('pay_sign', "");
        $param['sign_type'] = "MD5";

        $paylogic = new PayLogic();
        $data = $paylogic->getSign($param);
        return $data;
    }

    public function actionVipWap(){
        $uid = $this->getParam('uid', "");

        $userlogic = new UserLogic();
        $data = $userlogic->vipInfoWap($uid);
        $data['uid'] = $uid;

        return $data;
    }

    /*
     * 定时查询vip信息
     */
    public function actionVipInfo(){
        $uid = $this->getParam('uid', "");
        //用户vip信息
        $userdao = new UserDao();
        $vip = $userdao->validuservipPC($uid);
        if($vip){//有效会员
            $vip['isvip'] = 1;
            $vip['desc'] = '会员到期时间' . date('Y-m-d', $vip['end_time']);
        }else{
            $vip['isvip'] = 0;
            $vip['desc'] = '您还不是vip用户';
        }
        return $vip;
    }
}
