<?php
namespace page\controllers;

use admin\models\collect\CollectBind;
use admin\models\video\VideoChannel;
use admin\widgets\MyArrayDataProvider;
use common\models\advert\Advert;
use Yii;
use yii\helpers\Url;
use common\helpers\Tool;
use yii\web\Controller;
use admin\models\collect\Collect;
use common\models\video\Actor;
use common\models\video\Video;
use common\helpers\RedisStore;
use api\dao\CommonDao;
use mysqli;

class CollectController extends Controller
{
    public function actionTiming()
    {
        $param = [];
        $param['collect_id'] = Yii::$app->request->get('collect_id');
        if(empty($param['collect_id']))
            return '没有collect_id';

        $collecM = Collect::find()->andWhere(['collect_id'=>$param['collect_id']])->one();

        if (!$collecM->attributes)
            return '没有采集资源';

        $param['ac'] = 'cj';
        $param['cjflag'] = md5($collecM->collect_url);
        $param['cjurl'] = $collecM->collect_url;
        $param['h'] = '24';
        $param['t'] = '';
        $param['ids'] = '';
        $param['wd'] = '';
        $param['type'] = $collecM->collect_type;
        $param['mid'] = $collecM->collect_mid;
        $param['param'] = $collecM->collect_param;
//        $param['collect_id'] = $collecM->collect_id;
        $param['page'] = 1;
        $param['source'] = $collecM->video_source;

        $param['filter'] = $collecM->collect_filter;
        $param['filter_from'] = $collecM->collect_filter_from;
        $param['isdownload'] = $collecM->isdownload;

        $collectModel = new Collect();
        $res = $collectModel->vod($param);
        if($res['code']>1){
            return '没有数据';
        }
        echo(intval($res['page']['pagecount']));
        for ($i = 1; $i<=intval($res['page']['pagecount']);$i++)
        {
            $param['page'] = $i;
            if ($param['mid'] == '' || $param['mid'] == '1') {
                $this->vod($param);
                echo($i);
            }
        }
    }

    private function vod($param)
    {
//         if($param['ac'] != 'list'){
//             $redis = new RedisStore();
//             $catchKey = 'collect_break_vod_'.$param['collect_id'].'_'.$param['h'];
// //            $catch = Url::to('collect/api', $param);
//             $catch = $redis->get($catchKey);
//             if (isset($catch) && !isset($param['page']))
//             {
//                 $temp = json_decode($catch, true);
//                 $param = $temp;
//             }else{
//                 $redis->setEx($catchKey, json_encode($param, JSON_UNESCAPED_UNICODE));
//             }
//         }
        $collectModel = new Collect();
        $res = $collectModel->vod($param);
        if($res['code']>1){
            return '没有数据';
        }

        $result = $collectModel->vod_data($param,$res );
        return $result;
    }

    public function actionRunClick()
    {
        $advertId = Yii::$app->request->get('advert_id');

        if (!isset($advertId))
        {
            echo '没有advertId';
            return;
        }

        $adverMo = Advert::find()->andWhere(['id'=>$advertId])->one();

        if (!isset($adverMo))
        {
            echo '广告不存在';
            return;
        }

        $adUrl = $adverMo->skip_url;

        echo $adUrl;

        $count = rand(1,10);
        $count = Yii::$app->request->get('count', $count);

        for ($i = 0; $i < $count; $i++) {
            // code...
            $proxyUrl = "http://tiqu.linksocket.com:81/abroad?num=1&type=2&lb=1&sb=0&flow=1&regions=au&port=1&n=0";
            $getData = Tool::httpGet($proxyUrl);
            $proxyData = json_decode($getData['data']);

            echo $getData['data'];

            if ($proxyData->success != true || count($proxyData->data) <= 0) {
                $data["status"] = 500;
                $data["msg"] = "动态IP失效";
                echo Tool::responseJson(0, '操作成功', $data);
                continue;
            }

            $proxyResult = Tool::httpGetProxy($adUrl,  $proxyData->data[0]->ip, $proxyData->data[0]->port);
            echo($i);
            sleep(1);
        }
    }

    public function actionGetSong()
    {
        $res['vod_key'] = Yii::$app->request->post('vod_key', '');
        $res['vod_name'] = Yii::$app->request->post('vod_name', '');
        $res['vod_en'] = Yii::$app->request->post('vod_en', '');
        $res['vod_letter'] = Yii::$app->request->post('vod_letter', '');
        $res['vod_chapter'] = Yii::$app->request->post('vod_chapter', '');
        $res['vod_play_url'] = Yii::$app->request->post('vod_play_url', '');
        $res['outdir'] = Yii::$app->request->post('outdir', '');

        $mysql_conf = array(
            'user' => 'beiwo2',
            'password' => 'WLP274fMZrJJ8r6j',
            'port' => 3306,
            'host' => '127.0.0.1',
            'db' => 'beiwo2',
            'charset' => 'utf8'
        );

        $conn = new mysqli($mysql_conf['host'], $mysql_conf['user'], $mysql_conf['password'], $mysql_conf['db'], $mysql_conf['port']);
        // 检测连接
        if ($conn->connect_error) {
            echo("连接失败: " . $conn->connect_error);
        }

        // $area_list = $conn->query("SELECT * FROM sf_video_area")->fetch_assoc();

        $param['isdownload'] = Collect::COLLECT_DOWNLOAD_NO;
        $sql = "SELECT * FROM vod_Play_720 where final_title=".$res['vod_key'];
        $db_result = $conn->query($sql);
        $ifvodItem = $db_result->fetch_assoc();
        if($ifvodItem)
        {
            $upSql = "UPDATE vod_Play_720 set dir='".$res['outdir']."' where final_title=".$res['vod_key'];
            $ss = $conn->query($upSql);
            $ifvodItem['vod_play_url'] = $res['vod_play_url'];
            $ifvodItem['vod_play_url'] = $ifvodItem['chapter_name']. "$" . explode("$", $res['vod_play_url'])[1];
            $collectModel = new Collect();
            $param['source'] = 1;
            $result = $collectModel->vod_ifvoddata($param, $ifvodItem);
        }

        $sql = "SELECT * FROM vod_Play_1080 where final_title=".$res['vod_key'];
        $db_result = $conn->query($sql);
        $ifvodItem = $db_result->fetch_assoc();
        if($ifvodItem)
        {
            $upSql = "UPDATE vod_Play_1080 set dir='".$res['outdir']."' where final_title=".$res['vod_key'];
            $ss = $conn->query($upSql);
            $ifvodItem['vod_play_url'] = $res['vod_play_url'];
            $ifvodItem['vod_play_url'] = $ifvodItem['chapter_name']. "$" . explode("$", $res['vod_play_url'])[1];
            $collectModel = new Collect();
            $param['source'] = 10;
            $result = $collectModel->vod_ifvoddata($param, $ifvodItem);
        }

        $sql = "SELECT * FROM vod_Play_480 where final_title=".$res['vod_key'];
        $db_result = $conn->query($sql);
        $ifvodItem = $db_result->fetch_assoc();
        if($ifvodItem)
        {
            $upSql = "UPDATE vod_Play_480 set dir='".$res['outdir']."' where final_title=".$res['vod_key'];
            $ss = $conn->query($upSql);
            $ifvodItem['vod_play_url'] = $res['vod_play_url'];
            $ifvodItem['vod_play_url'] = $ifvodItem['chapter_name']. "$" . explode("$", $res['vod_play_url'])[1];
            $collectModel = new Collect();
            $param['source'] = 20;
            $result = $collectModel->vod_ifvoddata($param, $ifvodItem);
        }
        $result['ss'] = $ss;

        // $conn->close();
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
//        return Tool::responseJson(0, '操作成功', $param);
    }

    public function actionPushSong()
    {
        $res['vod_key'] = Yii::$app->request->post('vod_key', '');
        $res['vod_name'] = Yii::$app->request->post('vod_name', '');
        $res['vod_en'] = Yii::$app->request->post('vod_en', '');
        $res['vod_letter'] = Yii::$app->request->post('vod_letter', '');
        $res['vod_chapter'] = Yii::$app->request->post('vod_chapter', '');
        $res['vod_play_url'] = Yii::$app->request->post('vod_play_url', '');
        $res['outdir'] = Yii::$app->request->post('outdir', '');
        $quality = Yii::$app->request->post('quality', '');

        $mysql_conf = array(
            'user' => 'beiwo2',
            'password' => 'WLP274fMZrJJ8r6j',
            'port' => 3306,
            'host' => '127.0.0.1',
            'db' => 'beiwo2',
            'charset' => 'utf8'
        );

        $conn = new mysqli($mysql_conf['host'], $mysql_conf['user'], $mysql_conf['password'], $mysql_conf['db'], $mysql_conf['port']);
        // 检测连接
        if ($conn->connect_error) {
            echo("连接失败: " . $conn->connect_error);
        }

        // $area_list = $conn->query("SELECT * FROM sf_video_area")->fetch_assoc();

        $param['isdownload'] = Collect::COLLECT_DOWNLOAD_NO;
        $sql = "SELECT * FROM vod_Play_720 where final_title=".$res['vod_key'];
        $db_result = $conn->query($sql);
        $ifvodItem = $db_result->fetch_assoc();
        if($ifvodItem && $quality == '720P')
        {
            $upSql = "UPDATE vod_Play_720 set dir='".$res['outdir']."' where final_title=".$res['vod_key'];
            $ss = $conn->query($upSql);
            $ifvodItem['vod_play_url'] = $res['vod_play_url'];
            $ifvodItem['vod_play_url'] = $ifvodItem['chapter_name']. "$" . explode("$", $res['vod_play_url'])[1];
            $collectModel = new Collect();
            $param['source'] = 1;
            $result = $collectModel->vod_ifvoddata($param, $ifvodItem);
        }
        elseif($ifvodItem && $quality == '480P')
        {
            $ifvodItem['vod_play_url'] = $res['vod_play_url'];
            $ifvodItem['vod_play_url'] = $ifvodItem['chapter_name']. "$" . explode("$", $res['vod_play_url'])[1];
            $collectModel1 = new Collect();
            $param['source'] = 20;
            $result = $collectModel1->vod_ifvoddata($param, $ifvodItem);
        }
        $result['ss'] = $ss;
        $result['sk'] = $ifvodItem;

        // $conn->close();
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
//        return Tool::responseJson(0, '操作成功', $param);
    }
}
