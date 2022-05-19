<?php
namespace wap\controllers;

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

class VideoController extends BaseController
{
    /**
     * 视频首页
     */
    public function actionIndex()
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
            $redis->setEx(md5($ip."_city"), $city, 3600*24*30);
        }
        else {
            $city = $cityCache;
        }
        //请求首页信息
        $data = Yii::$app->api->get('/video/index', ['channel_id' => $channel_id, 'city'=> $city]);
        
        //请求频道、搜索信息
        $channels = Yii::$app->api->get('/video/channels');

        //新片预告
        $trailer = Yii::$app->api->get('/video/trailer', ['channel_id' => $channel_id]);
        if($trailer){
            $data['trailer'] = $trailer;
        }
        if(!$data) {
            return $this->redirect('/site/error');
        }

        return $this->render('index',[
            'data'          => $data,
            'channels'      => $channels,
            'channel_id'    => $channel_id
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
        $data['random'] = rand(10000, 99999);

        return Tool::responseJson(0, '操作成功', $data);
    }

    /**
     * 搜索页
     */
    public function actionSearch()
    {
        //搜索首页信息
        $data = Yii::$app->api->get('/search/hot-word');

        return $this->render('search', [
            'data' => $data
        ]);
    }

    /**
     * 搜索结果页
     */
    public function actionSearchResult()
    {
        //获取搜索关键字、频道
        $keyword = Yii::$app->request->get('keyword');

        //搜索首页信息
        $data = Yii::$app->api->get('/search/result', ['keyword' => $keyword]);

        return $this->render('search-result', [
            'data'      => $data,
            'keyword'   => $keyword
        ]);
    }

    /**
     * 根据频道、关键字进行搜索
     */
    public function actionSearchResultMore()
    {
        //获取搜索关键字、频道
        $keyword = Yii::$app->request->get('keyword');
        $channel_id = Yii::$app->request->get('channel_id', 1);

        //搜索首页信息
        $data = Yii::$app->api->get('/search/result', ['keyword' => $keyword, 'channel_id' => $channel_id]);

        return Tool::responseJson(0, '操作成功', $data);
    }

    /**
     * 视频播放详情页
     */
    public function actionDetail()
    {
        $uid = Yii::$app->user->id;
        //获取影片系列、剧集、源信息
        $video_id = Yii::$app->request->get('video_id', 0);
        $chapter_id = Yii::$app->request->get('chapter_id', '');
        $source_id = Yii::$app->request->get('source_id', '');

        $city = "";
        $redis = new RedisStore();
        $ip = Tool::getIp();
        $cityCache=$redis->get(md5($ip."_city"));
        if (empty($cityCache)) {
            $ipAddress = Tool::getIpAddressFromStack($ip);
            $city = $ipAddress['city'];
            $redis->setEx(md5($ip."_city"), $city, 3600*24*30);
        }
        else {
            $city = $cityCache;
        }
        //请求视频信息
        $info = Yii::$app->api->get('/video/info', ['video_id' => $video_id
            , 'chapter_id' => $chapter_id, 'source_id' => $source_id, 'city'=> $city, 'uid'=> $uid]);

        if(!$info) {
            return $this->redirect('/site/error');
        }

        return $this->render('detail', [
            'info'      => $info,
            'source_id' => $source_id
        ]);
    }

    /**
     * 视频列表页
     */
    public function actionList()
    {
        //获取影片系列、剧集、源信息
        $channel_id = Yii::$app->request->get('channel_id', 0);
        $tag = Yii::$app->request->get('tag', '');

        //请求影片筛选信息
        $info = Yii::$app->api->get('/video/filter', ['channel_id' => $channel_id, 'tag' => $tag, 'page_size' => 12]);

        //请求热门搜索信息
        $hot = Yii::$app->api->get('/search/hot-word');

        return $this->render('list', [
            'info'          => $info,
            'channel_id'    => $channel_id,
            'tag'           => $tag,
            'hot'           => $hot
        ]);
    }

    /**
     * 换一换
     */
    public function actionRefresh()
    {
        //获取频道、标签信息
        $recommend_id = Yii::$app->request->get('recommend_id', 0);

        //请求换一换信息信息
        $data = Yii::$app->api->get('/video/refresh', ['recommend_id' => $recommend_id]);

        return Tool::responseJson(0, '操作成功', $data);
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
        $page_num = Yii::$app->request->get('page_num', 1);

        //请求影片筛选信息
        $data = Yii::$app->api->get('/video/filter', ['channel_id' => $channel_id, 'tag' => $tag, 'sort' => $sort, 'area' => $area, 'year' => $year, 'page_num' => $page_num, 'page_size' => 12]);


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

        return $this->render('map',[
            'pageTab'       => $pageTab,
            'channels'      => $channels,
            'hotword'       => $hotword
        ]);
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
//        $citylist = Yii::$app->api->get('/video/city-info', ['citycode' => $citycode]);
//
//        if($citylist){
//            $city = $citylist['city_name'];
//        }else{
//            $city = '';
//        }

//        $citycode = 'SYD';
        //查广告
        $data = Yii::$app->api->get('/video/advert', ['page' => $page, 'city'=> '','citycode' => $citycode, 'uid' => $uid]);
//        if($advert){
//            $data['advert'] = $advert['advert'];
//        }

        //查线路
//        if($chapterId!=0){
//            $sources = Yii::$app->api->get('/video/chapter-sources',['uid'=>$uid,'chapterId'=>$chapterId,]);
//            if($sources){
//                $data['sources'] = $sources;
//            }
//        }
        if($data){
            $errno = 0;
        }else{
            $errno = -1;
        }
        return TOOL::responseJson($errno,"操作成功",$data);
    }
    /*
     * 加载评论列表
     */
    public function actionCommentMore(){
        $video_id = Yii::$app->request->get('video_id', 0);
        $chapter_id = Yii::$app->request->get('chapter_id', 0);
        $page_num = Yii::$app->request->get('page_num', 1);
        $order = 'time';

        $data = Yii::$app->api->get('/video/comment-more', ['video_id' => $video_id, 'chapter_id' => $chapter_id, 'page_num' => $page_num, 'order' => $order]);

        return $this->renderPartial('commentmore', ['data' => $data]);
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
     * 我的
     */
    public function actionPersonal(){
        $pageTab = "personal";

        $uid = Yii::$app->user->id;
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
        return $this->render('personal',[
            'pageTab'       => $pageTab,
            'data'      => $data,
        ]);
    }

    /*
     * 登录页
     */
    public function actionLogin(){
        $pageTab = "login";
        //国家
        $feedback = Yii::$app->api->get('/video/feedbackinfo');
        $countrys = [];
        if(isset($feedback['country'])){
            $countrys = $feedback['country'];
        }
        return $this->render('login',[
            'pageTab'       => $pageTab,
//            'data'      => $data,
            'countrys'      => $countrys,
        ]);
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
     * 个人资料页
     */
    public function actionUser(){
        $pageTab = "user";
        $uid = Yii::$app->user->id;
        //用户信息
        $data = Yii::$app->api->get('/user/userinfo',['uid'=>$uid]);

        return $this->render('user',[
            'pageTab'       => $pageTab,
            'data'      => $data,
        ]);
    }
    /*
     * 绑定手机页
     */
    public function actionBindMobile(){
        $pageTab = "bindmobile";
        $mtab = Yii::$app->request->get('mtab', "bind");

        $data = [];
        if($mtab=="modify"){
            $data['title'] = "修改手机号";
        }else{
            $data['title'] = "绑定手机号";
        }
        //国家
        $feedback = Yii::$app->api->get('/video/feedbackinfo');
        if(isset($feedback['country'])){
            $data['country'] = $feedback['country'];
        }
        return $this->render('bindmobile',[
            'pageTab' => $pageTab,
            'data'    => $data,
        ]);
    }
    /*
     * 修改个人资料
     */
    public function actionModifyUserinfo(){
        $uid = Yii::$app->user->id;

//        $nickname = Yii::$app->request->get('nickname', "");
//        $gender   = Yii::$app->request->get('gender', "");
        $mobile_areacode = Yii::$app->request->get('mobile_areacode', "");
        $mobile   = Yii::$app->request->get('mobile', "");//手机
        $flag     = Yii::$app->request->get('flag',"");//修改项
        $flag_value = Yii::$app->request->get('flag_value',"");//修改值
        $code     = Yii::$app->request->get('code', "");

        $result = Yii::$app->api->get('/user/modify-userinfo',['uid'=>$uid,'flag'=>$flag,'flag_value'=>$flag_value,
            'mobile_areacode'=>$mobile_areacode,'mobile'=>$mobile,'code'=>$code,]);

        return TOOL::responseJson($result['errno'],'操作成功',$result);
    }
    /*
     * 浏览记录页（播放记录）
     */
    public function actionWatchLog(){
        $pageTab = "watchlog";
        $uid = Yii::$app->user->id;
        $bottom  = Yii::$app->request->get('bottom', "");
        if(empty($uid)){
            return $this->redirect('/video/login');
        }

        $data = Yii::$app->api->get('/video/watchlog-pc',['uid'=>$uid]);
        return $this->render('watchlog',[
            'pageTab' => $pageTab,
            'data'    => $data,
            'bottom'  => $bottom,
        ]);
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
     * 删除播放记录
     */
    public function actionRemoveWatchlog(){
        $uid = Yii::$app->user->id;
        $logId = Yii::$app->request->get('logid', "");//多个id,以逗号(,)拼接
        $result = Yii::$app->api->get('/video/remove-watchlog',['uid'=>$uid,'logid'=>$logId]);
        return TOOL::responseJson(0,"操作成功",$result);
    }
    /*
     * 下拉翻页播放记录
     */
    public function actionWatchlogMore(){
        $uid = Yii::$app->user->id;
        $page_num = Yii::$app->request->get('page_num', 1);
        $timetitle = Yii::$app->request->get('timetitle', "");
        $tab = Yii::$app->request->get('tab', "");

        $data = Yii::$app->api->get('/video/search-watchlog',['uid'=>$uid,'page_num'=>$page_num]);
        return $this->renderPartial('watchlogmore', ['data' => $data,'timetitle'=>$timetitle,'tab'=>$tab]);
    }
    /*
     * 我的评论页
     */
    public function actionMyComment(){
        $pageTab = "mycomment";
        $uid = Yii::$app->user->id;
        if(empty($uid)){
            return $this->redirect('/video/login');
        }

        $data = Yii::$app->api->get('/user/comment-wap',['uid'=>$uid,'page_num'=>1]);
        return $this->render('mycomment',[
            'pageTab' => $pageTab,
            'data'    => $data,
        ]);
    }
    /*
     * 下拉翻页我的评论
     */
    public function actionMycommentMore(){
        $uid = Yii::$app->user->id;
        $page_num = Yii::$app->request->get('page_num', 1);
        $data = Yii::$app->api->get('/user/comment-wap',['uid'=>$uid,'page_num'=>$page_num]);
        return $this->renderPartial('mycommentmore', ['data' => $data]);
    }
    /*
     * 加载回复列表
     */
    public function actionReplyMore(){
        $pid = Yii::$app->request->get('pid', -1);
        $page_num = Yii::$app->request->get('page_num', 0);

        $data = Yii::$app->api->get('/video/reply-more', ['pid' => $pid,'page_num'=>$page_num]);
        if($data){
            $errno = 0;
        }else{
            $errno = -1;
        }
        return TOOL::responseJson($errno,"操作成功",$data);
    }
    /*
     * 我的收藏页
     */
    public function actionFavorite(){
        $pageTab = "favorite";
        $uid = Yii::$app->user->id;
        $bottom  = Yii::$app->request->get('bottom', "");
        if(empty($uid)){
            return $this->redirect('/video/login');
        }
        $data = [];
        $data = Yii::$app->api->get('/video/favorite-wap',['uid'=>$uid,'page_num'=>1]);
        return $this->render('favorite',[
            'pageTab' => $pageTab,
            'data'    => $data,
            'bottom'  => $bottom,
        ]);
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
    /*
     * 下拉翻页我的收藏
     */
    public function actionFavoriteMore(){
        $uid = Yii::$app->user->id;
        $page_num = Yii::$app->request->get('page_num', 1);
        $timetitle = Yii::$app->request->get('timetitle', "");
        $tab = Yii::$app->request->get('tab', "");
        //收藏
        $data = Yii::$app->api->get('/video/favorite-wap',['uid'=>$uid,'page_num'=>$page_num]);
        return $this->renderPartial('favoritemore', ['data' => $data,'timetitle'=>$timetitle,'tab'=>$tab]);
    }
    /*
     * 商务合作页
     */
    public function actionCooperation(){
        $pageTab = "cooperation";

        $data = Yii::$app->api->get('/service/about');//接口不可动，涉及app
        return $this->render('cooperation',[
            'pageTab' => $pageTab,
            'data'    => $data,
        ]);
    }
    /*
     * 设置页
     */
    public function actionSet(){
        $pageTab = "set";
        $uid = Yii::$app->user->id;

        $data = [];
        //用户信息
        if($uid){
            $data['login_show'] = '';
        }else {
            $data['login_show'] = 'display:none';
        }
        return $this->render('set',[
            'pageTab' => $pageTab,
            'data'    => $data,
        ]);
    }
    /*
     * 关于我们
     */
    public function actionAboutus(){
        $pageTab = "aboutus";

        $data = Yii::$app->api->get('/service/about');
        return $this->render('aboutus',[
            'pageTab' => $pageTab,
            'data'    => $data,
        ]);
    }
    /*
     * 软件许可及服务协议
     */
    public function actionAgreement(){
        $pageTab = "agreement";
        $data = Yii::$app->api->get('/service/about');
        return $this->render('agreement',[
            'pageTab' => $pageTab,
            'data'    => $data,
        ]);
    }
    /*
     * 隐私政策
     */
    public function actionPrivacy(){
        $pageTab = "privacy";
        $data = Yii::$app->api->get('/service/about');
        return $this->render('privacy',[
            'pageTab' => $pageTab,
            'data'    => $data,
        ]);
    }

    /*
     * 分类
     */
    public function actionListall()
    {
        //请求影片筛选信息,默认channel_id=2即连续剧
        $channel_id = 2;
        $info = Yii::$app->api->get('/video/filters', ['channel_id' => $channel_id, 'tag' => '', 'sort' => 'hot', 'sorttype' => 'desc', 'area' => '',
            'play_limit' => '', 'year' => '', 'page_num' => 1, 'page_size' =>12 ,'type' => 1, 'status' => 0]);

        //请求热门搜索信息
        $hot = Yii::$app->api->get('/search/hot-word');

        return $this->render('listall', [
            'info' => $info,
            'hot'  => $hot,
            'channel_id' =>$channel_id,
        ]);
    }

    /*
     * 加载分类条件
     */
    public function actionRefreshCates()
    {
        //获取影片系列、剧集、源信息
        $channel_id = Yii::$app->request->get('channel_id', 0);
        $sort = Yii::$app->request->get('sort', '');
//        $sorttype = Yii::$app->request->get('sorttype', 'desc');//排序高低
        $tag = Yii::$app->request->get('tag', '');
        $area = Yii::$app->request->get('area', '');
        $year = Yii::$app->request->get('year', '');
        $play_limit = Yii::$app->request->get('play_limit', '');
        $page_num = Yii::$app->request->get('page_num', 1);
        $page_size = Yii::$app->request->get('page_size', 12);
        $status = Yii::$app->request->get('status', 0); // 剧集是否完结：全部 / 更新中

        //请求影片筛选信息
        $data = Yii::$app->api->get('/video/filters', ['channel_id' => $channel_id, 'tag' => $tag, 'sort' => $sort, 'sorttype' => 'desc', 'area' => $area,
            'play_limit' => $play_limit, 'year' => $year, 'page_num' => $page_num, 'page_size' =>$page_size ,'type' => 1, 'status' => $status]);

        return Tool::responseJson(0, '操作成功', $data);
    }
}
