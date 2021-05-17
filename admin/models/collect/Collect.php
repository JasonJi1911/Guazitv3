<?php

namespace admin\models\collect;

use admin\models\collect\CollectBind;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use common\helpers\Tool;
use common\models\IpAddress;
use admin\models\video\VideoSource;
use admin\models\video\Video;
use admin\models\video\VideoCategory;
use admin\models\video\VideoChapter;
use common\models\video\VideoActor;
use admin\models\video\Actor;
use function GuzzleHttp\Psr7\str;
use yii\helpers\ArrayHelper;

class Collect extends \common\models\collect\Collect
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['collect_id', 'collect_type','collect_mid', 'collect_opt', 'collect_filter', 'video_source', 'created_at', 'updated_at', 'deleted_at', 'isdownload'], 'integer'],
            [['collect_name', 'collect_appid', 'collect_appkey'], 'string', 'max' => 30],
            [['collect_url', 'collect_filter_from'], 'string', 'max' => 255],
            [['collect_param'], 'string', 'max' => 100],
            [['collect_name', 'collect_url'], 'required'],
            [['collect_type'],'default','value'=>1]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'collect_id' => 'ID',
            'collect_name' => '采集名称',
            'collect_url' => '采集接口链接',
            'collect_type' => '接口返回数据类型',
            'collect_mid' => '资源类型',
            'collect_appid' => '采集账户',
            'collect_appkey' => '采集秘钥',
            'collect_param' => '采集参数',
            'collect_opt' => '采集数据操作',
            'collect_filter' => '采集数据过滤',
            'collect_filter_from' => '过滤代码',
            'video_source' => '视频线路',
            'videoSource' => '视频线路',
            'isdownload' => '图片下载选项',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     * 关联视频线路
     */
    public function getVideoSource()
    {
        $videoSource = VideoSource::findOne($this->video_source);
        if ($videoSource) {
            return $videoSource->name;
        }

        return '--';
//        return $this->hasOne(IpAddress::className(), ['id' => 'city_id']);
    }

    public function vod($param)
    {
        // dump($param);
        if($param['type'] == '1'){
            return $this->vod_xml($param);
        }
        elseif($param['type'] == '2'){
            return $this->vod_json($param);
        }
        else{
            $data = $this->vod_json($param);

            if($data['code'] == 1){
                return $data;
            }
            else{
                return $this->vod_xml($param);
            }
        }
    }

    public function vod_xml($param,$html='')
    {
        $url_param = [];
        $url_param['ac'] = $param['ac'];
        $url_param['t'] = $param['t'];
        $url_param['pg'] = is_numeric($param['page']) ? $param['page'] : '';
        $url_param['h'] = $param['h'];
        $url_param['ids'] = $param['ids'];
        $url_param['wd'] = $param['wd'];
        if(empty($param['h']) && !empty($param['rday'])){
            $url_param['h'] = $param['rday'];
        }

        if($param['ac']!='list'){
            $url_param['ac'] = 'videolist';
        }

        $url = $param['cjurl'];
        if(strpos($url,'?')===false){
            $url .='?';
        }
        else{
            $url .='&';
        }
        $url .= http_build_query($url_param). base64_decode($param['param']);
        $html = Tool::mac_curl_get($url);

        if(empty($html)){
            return ['code'=>1001, 'msg'=>'连接API资源库失败，通常为服务器网络不稳定或禁用了采集'];
        }

        $xml = @simplexml_load_string($html);
        if(empty($xml)){
            $labelRule = '<pic>'."(.*?)".'</pic>';
            $labelRule = Tool::mac_buildregx($labelRule,"is");
            preg_match_all($labelRule,$html,$tmparr);
            $ec=false;
            foreach($tmparr[1] as $tt){
                if(strpos($tt,'[CDATA')===false){
                    $ec=true;
                    $ne = '<pic>'.'<![CDATA['.$tt .']]>'.'</pic>';
                    $html = str_replace('<pic>'.$tt.'</pic>',$ne,$html);
                }
            }
            if($ec) {
                $xml = @simplexml_load_string($html);
            }
            if(empty($xml)) {
                return ['code' => 1002, 'msg' => 'XML格式不正确，不支持采集'];
            }
        }

        $array_page = [];
        $array_page['page'] = (string)$xml->list->attributes()->page;
        $array_page['pagecount'] = (string)$xml->list->attributes()->pagecount;
        $array_page['pagesize'] = (string)$xml->list->attributes()->pagesize;
        $array_page['recordcount'] = (string)$xml->list->attributes()->recordcount;
        $array_page['url'] = $url;

//        $type_list = model('Type')->getCache('type_list');
//        $bind_list = config('bind');


        $key = 0;
        $array_data = [];
        foreach($xml->list->video as $video){
            $bind_key = $param['cjflag'] .'_'.(string)$video->tid;
//            if($bind_list[$bind_key] >0){
//                $array_data[$key]['type_id'] = $bind_list[$bind_key];
//            }
//            else{
//                $array_data[$key]['type_id'] = 0;
//            }
            $array_data[$key]['vod_id'] = (string)$video->id;
            //$array_data[$key]['type_id'] = (string)$video->tid;
            $array_data[$key]['vod_name'] = (string)$video->name;
            $array_data[$key]['vod_remarks'] = (string)$video->note;
            $array_data[$key]['type_name'] = (string)$video->type;
            $array_data[$key]['vod_pic'] = (string)$video->pic;
            $array_data[$key]['vod_lang'] = (string)$video->lang;
            $array_data[$key]['vod_area'] = (string)$video->area;
            $array_data[$key]['vod_year'] = (string)$video->year;
            $array_data[$key]['vod_serial'] = (string)$video->state;
            $array_data[$key]['vod_actor'] = (string)$video->actor;
            $array_data[$key]['vod_director'] = (string)$video->director;
            $array_data[$key]['vod_content'] = (string)$video->des;

            $array_data[$key]['vod_status'] = 1;
            $array_data[$key]['vod_type'] = $array_data[$key]['list_name'];
            $array_data[$key]['vod_time'] = (string)$video->last;
            $array_data[$key]['vod_total'] = 0;
            $array_data[$key]['vod_isend'] = 1;
            if($array_data[$key]['vod_serial']){
                $array_data[$key]['vod_isend'] = 0;
            }
            //格式化地址与播放器
            $array_from = [];
            $array_url = [];
            $array_server=[];
            $array_note=[];
            //videolist|list播放列表不同
            if($count=count($video->dl->dd)){
                for($i=0; $i<$count; $i++){
                    $array_from[$i] = (string)$video->dl->dd[$i]['flag'];
                    $array_url[$i] = $this->vod_xml_replace((string)$video->dl->dd[$i]);
                    $array_server[$i] = 'no';
                    $array_note[$i] = '';

                }
            }else{
                $array_from[]=(string)$video->dt;
                $array_url[] ='';
                $array_server[]='';
                $array_note[]='';
            }

            if(strpos(base64_decode($param['param']),'ct=1')!==false){
                $array_data[$key]['vod_down_from'] = implode('$$$', $array_from);
                $array_data[$key]['vod_down_url'] = implode('$$$', $array_url);
                $array_data[$key]['vod_down_server'] = implode('$$$', $array_server);
                $array_data[$key]['vod_down_note'] = implode('$$$', $array_note);
            }
            else{
                $array_data[$key]['vod_play_from'] = implode('$$$', $array_from);
                $array_data[$key]['vod_play_url'] = implode('$$$', $array_url);
                $array_data[$key]['vod_play_server'] = implode('$$$', $array_server);
                $array_data[$key]['vod_play_note'] = implode('$$$', $array_note);
            }

            $key++;
        }

        $array_type = [];
        $key=0;
        //分类列表
        if($param['ac'] == 'list'){
            foreach($xml->class->ty as $ty){
                $array_type[$key]['type_id'] = (string)$ty->attributes()->id;
                $array_type[$key]['type_name'] = (string)$ty;
                $key++;
            }
        }

        $res = ['code'=>1, 'msg'=>'xml', 'page'=>$array_page, 'type'=>$array_type, 'data'=>$array_data ];
        return $res;
    }

    public function vod_json($param)
    {
        // dump($param);
        $url_param = [];
        $url_param['ac'] = $param['ac'];
        $url_param['t'] = $param['t'];
        $url_param['pg'] = is_numeric($param['page']) ? $param['page'] : '';
        $url_param['h'] = $param['h'];
        $url_param['ids'] = $param['ids'];
        $url_param['wd'] = $param['wd'];

        if($param['ac']!='list'){
            $url_param['ac'] = 'videolist';
        }

        $url = $param['cjurl'];
        if(strpos($url,'?')===false){
            $url .='?';
        }
        else{
            $url .='&';
        }
        $url .= http_build_query($url_param). base64_decode($param['param']);
        $html = Tool::mac_curl_get($url);

        if(empty($html)){
            return ['code'=>1001, 'msg'=>'连接API资源库失败，通常为服务器网络不稳定或禁用了采集'];
        }

        $json = json_decode($html,true);
        if(!$json){
            return ['code'=>1002, 'msg'=>'JSON格式不正确，不支持采集'];
        }

        $array_page = [];
        $array_page['page'] = $json['page'];
        $array_page['pagecount'] = $json['pagecount'];
        $array_page['pagesize'] = $json['limit'];
        $array_page['recordcount'] = $json['total'];
        $array_page['url'] = $url;

//        $type_list = model('Type')->getCache('type_list');
//        $bind_list = config('bind');

        $key = 0;
        $array_data = [];
        foreach($json['list'] as $key=>$v){
            $array_data[$key] = $v;
//            $bind_key = $param['cjflag'] .'_'.$v['type_id'];
//            if($bind_list[$bind_key] >0){
//                $array_data[$key]['type_id'] = $bind_list[$bind_key];
//            }
//            else{
//                $array_data[$key]['type_id'] = 0;
//            }

            if(!empty($v['dl'])) {
                //格式化地址与播放器
                $array_from = [];
                $array_url = [];
                $array_server = [];
                $array_note = [];
                //videolist|list播放列表不同
                foreach ($v['dl'] as $k2 => $v2) {
                    $array_from[] = $k2;
                    $array_url[] = $v2;
                    $array_server[] = 'no';
                    $array_note[] = '';
                }

                $array_data[$key]['vod_play_from'] = implode('$$$', $array_from);
                $array_data[$key]['vod_play_url'] = implode('$$$', $array_url);
                $array_data[$key]['vod_play_server'] = implode('$$$', $array_server);
                $array_data[$key]['vod_play_note'] = implode('$$$', $array_note);
            }
        }

        $array_type = [];
        $key=0;
        //分类列表
        if($param['ac'] == 'list'){
            foreach($json['class'] as $k=>$v){
                $array_type[$key]['type_id'] = $v['type_id'];
                $array_type[$key]['type_name'] = $v['type_name'];
                $key++;
            }
        }

        $res = ['code'=>1, 'msg'=>'json', 'page'=>$array_page, 'type'=>$array_type, 'data'=>$array_data ];
        return $res;
    }

    public function vod_xml_replace($url)
    {
        $array_url = array();
        $arr_ji = explode('#',str_replace('||','//',$url));
        foreach($arr_ji as $key=>$value){
            $urlji = explode('$',$value);
            if( count($urlji) > 1 ){
                $array_url[$key] = $urlji[0].'$'.trim($urlji[1]);
            }else{
                $array_url[$key] = trim($urlji[0]);
            }
        }
        return implode('#',$array_url);
    }

    public function vod_data($param,$data,$show=1)
    {
        $collectBind = new CollectBind();
        $category = new VideoCategory();
        $type_list = $collectBind::find()->asArray()->all();
        $category_list = $category::find()->asArray()->all();

        $filterStr = '';
        if ($param['filter'] == self::COLLECT_FILTER_NEWUP)
            $filterStr = $param['filter_from'];

//        $filter_arr = explode(',',$config['filter']);
        $retResult = [];
        foreach($data['data'] as $k=>$v) {
            $videoDao = new Video();
            $color = 'f-red';
            $des = '';
            $msg = '';
            $tmp = '';

            $retResult[$k]['color'] = $color;
            $retResult[$k]['des'] = $des;
            $retResult[$k]['msg'] = $msg;
            $retResult[$k]['tmp'] = $tmp;
            $retResult[$k]['vod_name'] = $v['vod_name'];

            foreach ($type_list as $type) {
                if ($type['type_name'] == $v['type_name'])
                    $videoDao->channel_id = $type['video_channel'];
            }

            if (empty($videoDao->channel_id)) {
                $des = '分类未绑定，跳过err';
                $retResult[$k]['des'] = $des;
            } elseif (empty($v['vod_name'])) {
                $des = '数据不完整，跳过err';
                $retResult[$k]['des'] = $des;
            }
//            elseif( mac_array_filter($filter_arr,$v['vod_name']) !==false) {
//                $des = '数据在过滤单中，跳过err';
//            }
            else {
                unset($v['vod_id']);

                foreach ($v as $k2 => $v2) {
                    if (strpos($k2, '_content') === false) {
                        $v[$k2] = strip_tags($v2);
                    }
                }

//                $v['type_id_1'] = intval($type_list[$v['type_id']]['type_pid']);
//                $v['vod_en'] = Pinyin::get($v['vod_name']);
//                $v['vod_letter'] = strtoupper(substr($v['vod_en'],0,1));

                $class = isset($v['vod_class'])?$v['vod_class'] : "";
                $ids = $this->ParseCatogory($category_list, $class, $v['type_name'], $videoDao->channel_id);
                $videoDao->category_ids = $ids?$ids:'0';
                $videoDao->publish_clients = "1,2,3";
                $videoDao->title = $v['vod_name'];
                $videoDao->source = '作品来源';
                $videoDao->type = $videoDao->channel_id == CollectBind::VIDEO_CHANNEL_MOVIE ? 1 : 2;
                $videoDao->area = $this->ParseArea($v['vod_area']);
                $videoDao->year = $this->ParseYear($v['vod_year']);
                $videoDao->description = $v['vod_content']?$v['vod_content']:$v['vod_name'];
                $videoDao->score = floatval($v['vod_score']) * 10;
                $videoDao->horizontal_cover = "http://img.guazitv8.com/video/horizontal_cover/20201016/041f3168d37575bab82f4bb1d97d9fff.gif";
                $videoDao->status = 1;
                $videoDao->is_finished = $v['vod_isend'] == "1" ? $v['vod_isend'] : "2";
                $videoDao->is_sensitive = 1;
                $videoDao->play_limit = 1;
                $videoDao->is_down = 0;
                $videoDao->episode_num = $this->GetEpisodeNum($v['vod_play_url']);
                $videoDao->total_views = 0;
                $videoDao->total_favors = 0;
                $videoDao->total_price = 0;
                $videoDao->issue_date = time();

                $info = $videoDao::find()->andWhere(['title'=>$v['vod_name'], 'status'=>1, 'channel_id'=>$videoDao->channel_id])->asArray()->one();
                if (!$info)
                {
                    if($param['isdownload'] == Collect::COLLECT_DOWNLOAD_YES)
                        $videoDao->cover = $this->ParseVideoCover($v['vod_pic']);
                    else
                        $videoDao->cover = $v['vod_pic'];

                    if(empty($videoDao->cover))
                        $videoDao->cover = "http://img.guazitv8.com/video/default.png";

                    $videoDao->save();
                    if (empty($videoDao->errors))
                    {
                        $this->ParseVideoChapter($videoDao->id, $v['vod_play_from'], $v['vod_play_url'], $param['source'], $videoDao->channel_id, $v['vod_name'], $filterStr);
                        $this->ParseVideoActor($videoDao->id, $v['vod_actor']);
                        $this->ParseVideoActor($videoDao->id, $v['vod_director'], 2);
                        $des = '数据插入成功';
                        $retResult[$k]['des'] = $des;
                        $retResult[$k]['color'] = 'f-red';
                    }
                    else
                    {
                        $des = '数据插入失败';
                        $retResult[$k]['des'] = json_encode($videoDao->errors, JSON_UNESCAPED_UNICODE);
                        $retResult[$k]['color'] = 'f-red';
                    }
                }
                else
                {
                    $updateDao = new video();
                    $updateDao->oldAttributes = $info;
                    $newAttributes = [];
                    if ($videoDao->category_ids != $info['category_ids'])
                    {
                        $oldCatArr = explode(',', $info['category_ids']);
                        $newCatArr = explode(',', $videoDao->category_ids);
                        foreach ($newCatArr as $cat)
                        {
                            if (in_array($cat, $oldCatArr))
                                continue;
                            array_push($oldCatArr, $cat);
                        }
                        $newAttributes['category_ids'] = implode(',', array_unique($oldCatArr));
                    }
                    else
                    {
                        $oldCatArr = explode(',', $info['category_ids']);
                        $newAttributes['category_ids'] = implode(',', array_unique($oldCatArr));
                    }

                    if (strpos($info['cover'], 'video/cover') === false && $param['isdownload'] == Collect::COLLECT_DOWNLOAD_YES)
                    {
                        $localCover = $this->ParseVideoCover($v['vod_pic']);
                        if(!empty($localCover))
                        {
                            $newAttributes['cover'] = $localCover;
                            $des ='更新视频图片成功!!  ';
                        }
                    }

                    $this->ParseVideoChapter($info['id'], $v['vod_play_from'], $v['vod_play_url'], $param['source'], $videoDao->channel_id, $v['vod_name'],$filterStr);
                    if ($videoDao->episode_num > $info['episode_num'])
                        $newAttributes['episode_num'] = $videoDao->episode_num;

                    if ($videoDao->channel_id != CollectBind::VIDEO_CHANNEL_MOVIE)
                        $newAttributes['episode_num'] = VideoChapter::find()->where(['video_id'=>$info['id']])->count();

                    if (!empty($newAttributes))
                    $updateDao->updateAttributes($newAttributes);

                    $this->ParseVideoActor($info['id'], $v['vod_actor']);
                    $this->ParseVideoActor($info['id'], $v['vod_director'], 2);
                    $des = $des.'数据更新成功!!';
                    $retResult[$k]['des'] = $des;
                    $retResult[$k]['color'] = 'f-green';
                }
            }
        }

        return $retResult;
    }

    private function ParseVideoCover($coverSrc)
    {
        if(empty($coverSrc))
            return;

        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4'];

        $tmp = explode('.', $coverSrc);
        $exten = $tmp[count($tmp) - 1];
        if(in_array($exten, $imageExtensions))
            $filename = md5(time().rand(10000, 99999)).'.'.$exten;
        else
            $filename = md5(time().rand(10000, 99999)).'.png';

        $videoPath = '/video/cover/'.date('Ymd');
        $rootPath = dirname(dirname(dirname(__DIR__))) . '/uploads'.$videoPath; //文件存储根路径

        $imFile = Tool::getImage($coverSrc, $rootPath, $filename, 1);
        if(!isset($imFile) || empty($imFile['save_path']))
            return $coverSrc;

        return $videoPath.'/'.$filename;
    }

    private function mac_txt_merge($txt,$str)
    {
        if(empty($str)){
            return $txt;
        }
        if($GLOBALS['config']['collect']['vod']['class_filter'] !='0') {
            if (mb_strlen($str) > 2) {
                $str = str_replace(['片'], [''], $str);
            }
            if (mb_strlen($str) > 2) {
                $str = str_replace(['剧'], [''], $str);
            }
        }
        $txt = $this->mac_format_text($txt);
        $str = $this->mac_format_text($str);
        $arr1 = explode(',',$txt);
        $arr2 = explode(',',$str);
        $arr = array_merge($arr1,$arr2);
        return join(',',array_unique( array_filter($arr)));
    }

    private function mac_format_text($str)
    {
        return str_replace(array('/','，','|','、',' ',',,,'),',',$str);
    }

    private function ParseCatogory($categoryList, $class, $typename, $channel)
    {
        $ids = "";
        if (empty($class) && empty($typename))
            return $ids;

        $classd = $this->mac_txt_merge($class,$typename);
        foreach ($categoryList as $category)
        {
            if ($channel != $category['channel_id'])
                continue;

            if ($category['title'] == $class)
                $ids = empty($ids)? $ids.$category['id'] : $ids.','.$category['id'];

            if ($category['title'] == $typename)
                $ids = empty($ids)? $ids.$category['id'] : $ids.','.$category['id'];
        }

        if (empty($ids))
        {
            if ($channel == CollectBind::VIDEO_CHANNEL_MOVIE)
                $ids = strval(CollectBind::MOVIE_CATE_OTHER);

            if ($channel == CollectBind::VIDEO_CHANNEL_DRAMA)
                $ids = strval(CollectBind::DRAMA_CATE_OTHER);

            if ($channel == CollectBind::VIDEO_CHANNEL_ENTER)
                $ids = strval(CollectBind::ENTER_CATE_OTHER);

            if ($channel == CollectBind::VIDEO_CHANNEL_ANIMATION)
                $ids = strval(CollectBind::ANNI_CATE_OTHER);

            if ($channel == CollectBind::VIDEO_CHANNEL_DOCUMENTARY)
                $ids = strval(CollectBind::DOCU_CATE_OTHER);
        }

        return $ids;
    }

    private function ParseArea($area)
    {
        if ($a= array_search($area, CollectBind::$videoAreas)){
            return $a;
        }

        return CollectBind::AREA_USA;
    }

    private function ParseYear($year)
    {
        if ($a= array_search($year, CollectBind::$videoYears)){
            return $a;
        }

        return CollectBind::YEAREARLY;
    }

    private function GetEpisodeNum($play_url)
    {
        $cj_play_url_arr = explode('$$$',$play_url);
        $episode_num = 0;
        foreach ($cj_play_url_arr as $v2) {
            $urlList = explode('#', $v2);
            $episode_num = count($urlList) > $episode_num? count($urlList) : $episode_num;
        }
        return $episode_num;
    }

    private function ParseVideoChapter($video_id, $play_from, $play_url, $source_id, $channel_id, $video_name, $filterList = '')
    {
        if (!isset($video_id))
            return;

        $titleBak = ['正片', 'HD', '高清', 'HD1080P中字', 'HD高清', 'DVD', 'BD超清中字', 'BD国语超清', '高清国语中文字幕', 'BD', 'BD高清中字', 'HD720P中字', 'BD高清', 'HD国语', '1080P', $video_name ];
//        $videoChapter = new VideoChapter();

        $cj_play_from_arr = explode('$$$',$play_from);
        $cj_play_url_arr = explode('$$$',$play_url);

        $old_chapter_list = VideoChapter::find()->andWhere(['video_id'=>$video_id])->asArray()->all();
        $old_chapter_Arr = array_column($old_chapter_list, 'title');
        $filterArr = explode(',', $this->mac_format_text($filterList));

        foreach ($cj_play_url_arr as $v2)
        {
            $urlList = explode('#',$v2);
            $epiIndex = 1;
            foreach ($urlList as $url)
            {
                $urlArr = explode('$',$url);
                $title = $urlArr[0];
                $liveUrl = $urlArr[1];

                if (!empty($filterArr))
                {
                    $isfilted = false;
                    foreach ($filterArr as $filter)
                    {
                        if(!empty($filter) && strpos($liveUrl, $filter) !== false)
                            $isfilted = true;
                    }
                    if ($isfilted)
                        continue;
                }

                if ($channel_id == CollectBind::VIDEO_CHANNEL_DRAMA
                    || $channel_id == CollectBind::VIDEO_CHANNEL_ANIMATION
                    || $channel_id == CollectBind::VIDEO_CHANNEL_DOCUMENTARY)
                {
                    if (strpos($title,"第0") !== false){
                        $title = str_replace("第0","第",$title);
                    }
                }
                else if ($channel_id == CollectBind::VIDEO_CHANNEL_MOVIE)
                {
                    if (in_array($title, $titleBak)) {
                        $title = "正片";
                    }
                }
                else if ($channel_id == CollectBind::VIDEO_CHANNEL_ENTER)
                {
                    $pattern="/\\d{1,4}((-|\/)\d{1,2}){2}(\s{0,5}\\d{1,2}(\:\d{1,2}){1,2}){0,1}/";
                    preg_match($pattern,$title,$match);

                    if (!empty($match) && !empty($match[0]))
                        $title = str_replace(array('/','-'),'',$match[0]);
                }

                $diplay_order = 0;
                $chapterurlArr = array();
                $foundKey = array_search($title, $old_chapter_Arr);
                if ($foundKey !== false) {
                    $chapter = $old_chapter_list[$foundKey];
                    $chapterid = $chapter['id'];
                    $chapterurl = $chapter['resource_url'];
                    $chapterurlArr = json_decode($chapterurl, true);

                    $chapter_src_url = "";
                    if (isset($chapterurlArr[$source_id])) {
                        $chapter_src_url = $chapterurlArr[$source_id];
                    }

                    if (empty($chapter_src_url) || $liveUrl != $chapter_src_url) {
                        $chapterurlArr[$source_id] = $liveUrl;
                        $diplay_order = $chapter['display_order'];
                    } else
                        continue;
                }
                else{
                    $chapterurlArr[$source_id]= $liveUrl;
                    // $diplay_order = $videoChapter::find()->andWhere(['video_id'=>$video_id])->count();
                    $diplay_order = $epiIndex;
                }

                $newModel = new VideoChapter();
                if ($foundKey !== false)
                {
                    $newModel->oldAttributes = $chapter;
                    $newModel->duration_time =$chapter['duration_time'];
                    $newModel->total_views = $chapter['total_views'];
                    $newModel->total_comment = $chapter['total_comment'];
                    $newModel->display_order =$chapter['display_order'];
                    $newModel->play_limit = $chapter['play_limit'];
                }
                else
                {
                    $newModel->duration_time =0;
                    $newModel->total_views = 0;
                    $newModel->total_comment = 0;
                    $newModel->display_order =$diplay_order;
                    $newModel->play_limit = 1;
                }

                $newModel->video_id =$video_id;
                $newModel->title =$title;
                $newModel->resource_url =json_encode($chapterurlArr);
                try {
                    $newModel->save();
                }
                catch(Exception $ex)
                {

                }
                $epiIndex++;
            }
        }
    }

    private function ParseVideoActor($video_id, $actorSrc, $actorType = 1)
    {
        if (!$video_id || !$actorSrc)
            return;

//        $redis = new RedisStore();
//        $actor_key = 'actor_list';
//        $actor_list  = json_decode($redis->get($actor_key), true);
        $oldVideoActorList = VideoActor::find()->andWhere(['video_id'=>$video_id])->asArray()->all();

        if (!isset($oldVideoActorList))
            return;

//        $actorNameArr = array_column($actor_list, 'actor_name');
        $oldVideoActorArr = array_column($oldVideoActorList, 'actor_id');

        $actorSrcArr = explode(',', str_replace(array('/','，','|','、',' ',',,,'),',',$actorSrc));

        foreach ($actorSrcArr as $actorStr)
        {
            $actor_id = "";
//            $foundKey = array_search($actorStr, $actorNameArr, true);
//            if ($foundKey !== false)
//                $oldActor = $actor_list[$foundKey];

            $oldActor = Actor::find()->andWhere(['actor_name'=>$actorStr, 'type'=>$actorType])->asArray()->one();

            if (!empty($oldActor) && $oldActor['type'] == $actorType)
                $actor_id = $oldActor['actor_id'];
            else{
                $actorDao = new Actor();
                $actorDao->actor_name = $actorStr;
                $actorDao->type = $actorType;
                $actorDao->avatar = "video/actor_avatar/userImg-default.png";
                $actorDao->area_id = 0;
                $actorDao->weight = 1;
                $actorDao->save();
                $actor_id = $actorDao->actor_id;
            }

            if (isset($actor_id))
            {
                $videoActorDao = new VideoActor();
//                $oldVideoActor = VideoActor::find()->andWhere(['video_id'=>$video_id,'actor_id'=>$actor_id])->asArray()->one();
                $foundOld = array_search(strval($actor_id), $oldVideoActorArr);
                if ($foundOld !== false)
                {
                    $oldVideoActor = $oldVideoActorList[$foundOld];
                    $videoActorDao->oldAttributes = $oldVideoActor;
                }
                $videoActorDao->video_id = intval($video_id);
                $videoActorDao->actor_id = $actor_id;
                $videoActorDao->display_order = 10;
                if (!$oldVideoActor)
                    $videoActorDao->insert();

//                if (!isset($foundKey))
//                {
//                    array_merge($actor_list, ['actor_id'=>$actor_id, 'actor_name'=>$actorStr]);
//                    $redis->setEx($actor_key, json_encode($actor_list));
//                }
            }
        }
    }

    public function cancel_source($param,$data)
    {
        $vidArr = array_column($data['data'], 'id');
        $vidStr = implode(',', $vidArr);

        $allChapters = VideoChapter::find()->select(['id','video_id','resource_url'])->where(['video_id'=>$vidArr])->asArray()->all();
        $allChapters = ArrayHelper::index($allChapters, null, 'video_id');

        $retResult = [];
        foreach($data['data'] as $k=>$v) {
            $video_name = $v['title'];
            $video_id = $v['id'];
            $source = $param['source'];
            $color = 'f-red';
            $des = '没有对应线路视频';
            $msg = '';
            $tmp = '';

            $retResult[$k]['color'] = $color;
            $retResult[$k]['des'] = $des;
            $retResult[$k]['msg'] = $msg;
            $retResult[$k]['tmp'] = $tmp;
            $retResult[$k]['vod_name'] = $video_name;

            $chapters = $allChapters[$video_id]; //获取单个视频的所有集数
            if (!isset($chapters) || !is_array($chapters) || count($chapters) <= 0)
                continue;

            foreach ($chapters as $cp)
            {
                $res_url_arr = json_decode($cp['resource_url'], true);
                if (!ArrayHelper::keyExists($source, $res_url_arr, false))
                    continue;

                ArrayHelper::remove($res_url_arr, $source);
                $updateDao = new VideoChapter();
                $updateDao->oldAttributes = $cp;
                $updateDao->updateAttributes(['resource_url' => json_encode($res_url_arr)]);
            }
            $des = '线路清空成功';
            $retResult[$k]['des'] = $des;
            $retResult[$k]['color'] = 'f-green';
        }
        return $retResult;
    }
}