<?php
namespace page\controllers;

use admin\models\collect\CollectBind;
use admin\models\video\VideoChannel;
use admin\widgets\MyArrayDataProvider;
use Yii;
use yii\helpers\Url;
use common\helpers\Tool;
use yii\web\Controller;
use admin\models\collect\Collect;
use common\models\video\Actor;
use common\helpers\RedisStore;
use api\dao\CommonDao;

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

        for ($i = 1; $i<=intval($res['page']['pagecount']);$i++)
        {
            $param['page'] = $i;
            if ($param['mid'] == '' || $param['mid'] == '1') {
                $this->vod($param);
            }
        }
    }

    private function vod($param)
    {
        if($param['ac'] != 'list'){
            $redis = new RedisStore();
            $catchKey = 'collect_break_vod_'.$param['collect_id'].'_'.$param['h'];
//            $catch = Url::to('collect/api', $param);
            $catch = $redis->get($catchKey);
            if (isset($catch) && !isset($param['page']))
            {
                $temp = json_decode($catch, true);
                $param = $temp;
            }else{
                $redis->setEx($catchKey, json_encode($param, JSON_UNESCAPED_UNICODE));
            }
        }
        $collectModel = new Collect();
        $res = $collectModel->vod($param);
        if($res['code']>1){
            return '没有数据';
        }

        $result = $collectModel->vod_data($param,$res );
        return $result;
    }
}
