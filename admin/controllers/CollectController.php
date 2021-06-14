<?php

namespace admin\controllers;

use admin\models\collect\CollectBind;
use admin\models\video\Video;
use admin\models\video\VideoChannel;
use admin\widgets\MyArrayDataProvider;
use Yii;
use yii\db\Query;
use yii\helpers\Url;
use common\helpers\Tool;
use yii\web\Controller;
use admin\models\collect\Collect;
use common\models\video\Actor;
use common\helpers\RedisStore;

class CollectController extends BaseController
{
    public $name = '采集';

    public $modelClass = 'admin\models\collect\Collect';
    public $searchModelClass = 'admin\models\video\search\CollectSearch';

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $collect_id = Yii::$app->request->get('collect_id');

        $actions = parent::actions();

        $actions['create']['redirect'] = ['index', 'collect_id' => $collect_id];
        $actions['update']['redirect'] = ['index', 'collect_id' => $collect_id];

        return $actions;
    }

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
                return $this->vod($param);
            }
        }
    }

    public function actionButtons()
    {
        $positionId = Yii::$app->request->get('position_id');
        return [
            [
                'label'   => '新增采集',
                'url'     => ['create', 'position_id' => $positionId],
                'options' => ['class' => 'btn green'],
            ],
        ];
    }

    public function actionApi()
    {
        $param = [];
        $param['ac'] = Yii::$app->request->get('ac');
        $param['cjflag'] = Yii::$app->request->get('cjflag');
        $param['cjurl'] = Yii::$app->request->get('cjurl');
        $param['h'] = Yii::$app->request->get('h');
        $param['t'] = Yii::$app->request->get('t');
        $param['ids'] = Yii::$app->request->get('ids');
        $param['wd'] = Yii::$app->request->get('wd');
        $param['type'] = Yii::$app->request->get('type');
        $param['mid'] = Yii::$app->request->get('mid');
        $param['param'] = Yii::$app->request->get('param');
        $param['collect_id'] = Yii::$app->request->get('collect_id');
        $param['page'] = Yii::$app->request->get('page');
        $param['source'] = Yii::$app->request->get('source');

        $param['filter'] = Yii::$app->request->get('filter');
        $param['filter_from'] = Yii::$app->request->get('filter_from');
        $param['isdownload'] = Yii::$app->request->get('isdownload');

        //分类
//        $type_list = model('Type')->getCache('type_list');
//        $this->assign('type_list', $type_list);

//        $redis = new RedisStore();
//        $actor_key = 'actor_list';
//        $catch = $redis->get($actor_key);
//        if (!isset($catch))
//        {
//            $actor_list = Actor::find()->asArray()->all();
//            $redis->setEx($actor_key, json_encode($actor_list, JSON_UNESCAPED_UNICODE));
//        }

        if ($param['mid'] == '' || $param['mid'] == '1') {
            return $this->vod($param);
        } elseif ($param['mid'] == '2') {
            return $this->art($param);
        } elseif ($param['mid'] == '8') {
            return $this->actor($param);
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
            return '数据中断';
        }

        if($param['ac'] == 'list'){
            $provider = new MyArrayDataProvider([
                'allModels' => $res['data'],
                'totalCount' => $res['page']['recordcount'],
                'pagination' =>[
                    'pagesize'=> $res['page']['pagesize'],
                ]
            ]);

            $collectBindModel = new CollectBind();
            $a = CollectBind::tableName();
            $bindArr = $collectBindModel::find()
                ->select("$a.*, b.channel_name")
                ->leftJoin(VideoChannel::tableName().' b', $a.'.video_channel=b.id')
                ->andWhere(['collect_id' => $param['collect_id']])
                ->asArray()
                ->all();

            foreach ($res['type'] as $k=>&$v)
            {
                if (count($bindArr) <= 0)
                    break;

                foreach ($bindArr as $i=>$bind)
                {
                    if ($bind['type_id'] != $v['type_id'] || $bind['type_name'] != $v['type_name'])
                        continue;

                    if (isset($bind)){
                        $v['video_channel'] = $bind['video_channel'];
                        $v['channel_name'] = $bind['channel_name'];
                    }
                }
            }

            return $this->render('_list', ['collect_id'=>$param['collect_id'], 'data' => $res, 'dataProvider'=>$provider]);
        }

        $result = $collectModel->vod_data($param,$res );
        return $this->render('_reading', ['data' => $res, 'messages' => $result, 'param'=>$param]);

    }

    public function actionBind()
    {
        $channel_id = Yii::$app->request->get('channelid');
        $collect_id = Yii::$app->request->get('collectid');
        $type_id = Yii::$app->request->get('typeid');
        $type_name = Yii::$app->request->get('typename');

        $collectBindModel = new CollectBind();
        $collectBindModel->video_channel = $channel_id;
        $collectBindModel->collect_id = $collect_id;
        $collectBindModel->type_id = $type_id;
        $collectBindModel->type_name = $type_name;

        $collectBindModel->save();

        if (isset($collectBindModel->id))
        {
            $channel = VideoChannel::findOne(['id'=>$channel_id]);
            if ($channel) {
                return Tool::responseJson(0, '', ['channelName' => $channel->channel_name]);
            }
            else{
                return Tool::responseJson(2, '非法频道');
            }
        }
        else
        {
            return Tool::responseJson(1, '类型绑定失败');
        }
    }

    public function actionCancelAll()
    {
        $param = [];
        $param['cjflag'] = Yii::$app->request->get('cjflag');
        $param['page'] = Yii::$app->request->get('page');
        $param['source'] = Yii::$app->request->get('source');

        if (!isset($param['page']))
            $param['page'] = 1;

        $videoCount = (new \yii\db\Query())
            ->from(Video::tableName())
            ->count();

        $recordcount = $videoCount;
        $page = $param['page'];
        $pagesize = 30;
        $pagecount = intval(ceil(($videoCount / $pagesize)));

        $array_page = [];
        $array_page['page'] = $page;
        $array_page['pagecount'] = $pagecount;
        $array_page['pagesize'] = $pagesize;
        $array_page['recordcount'] = $recordcount;

        $array_data = (new \yii\db\Query())
            ->from(Video::tableName())->select(['id','title'])->limit($pagesize)->offset(($page-1)*$pagesize)->all();
        $res = ['code'=>1, 'msg'=>'json', 'page'=>$array_page, 'data'=>$array_data ];
        $collectModel = new Collect();
        $result = $collectModel->cancel_source($param,$res );
        return $this->render('_cancelSource', ['data' => $res, 'messages' => $result, 'param'=>$param]);
    }
}