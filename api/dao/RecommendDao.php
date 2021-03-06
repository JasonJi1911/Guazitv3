<?php
namespace api\dao;

use api\data\ActiveDataProvider;
use api\models\video\Recommend;
use api\models\video\Video;
use api\models\video\VideoChapter;
use api\models\video\Actor;
use api\helpers\Common;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use yii\helpers\ArrayHelper;
use Yii;

class RecommendDao extends BaseDao
{
    /**
     * 缓存推荐位
     * @param $recommendId
     * @param array $fields
     * @return array|mixed
     */
    public function getRecommend($recommendId, $fields = [])
    {
        $redis = new RedisStore();
        $key = RedisKey::recommendInfo($recommendId);
        if ($data = $redis->get($key)) {
            $data = json_decode($data, true);
        } else {
            $data = Recommend::findOne(['id' => $recommendId])->toArray();
            $redis->setEx($key, json_encode($data, JSON_UNESCAPED_UNICODE));
        }
        //过滤字段
        if ($fields) {
            $data = $this->filter($data, $fields);
        }
        return $data;
    }

    /**
     * 批量获取推荐位信息
     * @param array $recommendIds
     * @param array $fields
     * @param bool $index
     * @param array $params
     * @return array
     */
    public function batchGetRecommend(array $recommendIds, array $fields = [], $index = false, array $params = [])
    {
        $data  = []; //最终返回的数据
        $noHitKeys  = []; //没有命中缓存的key

        $redis = new RedisStore();
        foreach ($recommendIds as $id) { //遍历查询缓存
            $key = RedisKey::recommendInfo($id);
            if ($recommendInfo = $redis->get($key)) {  //有缓存
                //格式化处理缓存后的数据
                $data[] = json_decode($recommendInfo, true);
            } else {
                $noHitKeys[] = $id;
            }
        }

        //查询所有没有命中的数据
        if ($noHitKeys) {
            $videoDataProvider = new ActiveDataProvider([
                'query' => Recommend::find()
                    ->where(['id' => $noHitKeys])
            ]);
            $recommendInfo = $videoDataProvider->toArray();
            foreach ($recommendInfo as $recommend) { // 缓存数据
                $redis->setEx(RedisKey::recommendInfo($recommend['recommend_id']), json_encode($recommend, JSON_UNESCAPED_UNICODE));
            }
            $data = array_merge($data, $recommendInfo);  //合并所有数据
        }

        //过滤字段
        if ($fields) {
            $data = $this->filter($data, $fields);
        }

        return $data;
    }

    /**
     * 获取频道下的推荐位
     * @param $channelId
     * @param array $fields
     * @return array|mixed
     */
    public function recommendByChannel($channelId, $fields = [])
    {
        $key = RedisKey::channelRecommend($channelId);
        $redis = new RedisStore();

        if ($str = $redis->get($key)) {
            $recommendIds = json_decode($str, true);
        } else {
            $bannerDataProvider = new ActiveDataProvider([
                'query' => Recommend::find()->andWhere(['channel_id' => $channelId]),
            ]);
            $recommendIds = ArrayHelper::getColumn($bannerDataProvider->toArray(['recommend_id']), 'recommend_id');
            $redis->setEx($key, json_encode($recommendIds));
        }
        // 批量获取推荐位信息
        return $this->batchGetRecommend($recommendIds, $fields);
    }

    /**
     * 推荐位缓存影片
     * @param $recommendId
     * @param array $fields
     * @return array|mixed
     */
    public function recommendVideo($recommendId, $fields = [])
    {
        $redisKey = RedisKey::recommendVideo($recommendId);
        $redis = new RedisStore();

         if ($str = $redis->get($redisKey)) {
             $videoIds = json_decode($str, true);

             $videoDao = new VideoDao();
             $data = $videoDao->batchGetVideo($videoIds, $fields, false, ['actors']);
         } else {
            // 查询对象
            $objVideo = Video::find();
            // 获取推荐位信息
            $recommendInfo = $this->getRecommend($recommendId);
            $condition = json_decode($recommendInfo['search'], true);
            // 频道筛选
            $objVideo->andWhere(['channel_id' => $recommendInfo['channel_id']]);

            // 组建筛选条件
            foreach ($condition as $key => $value) {
                // 地区年代筛选
                if ($value['field'] == 'area' || $value['field'] == 'year' || $value['field'] == 'channel_id') {
                    $objVideo->andWhere([$value['field'] => $value['value']]);
                }
                // 标签筛选
                if ($value['field'] == 'tag') {
                    $objVideo->andWhere(['like', 'category_ids', $value['value']]);
                }
            }

            $limitCnt = Yii::$app->common->product == Common::PRODUCT_APP ? 9 : 20;//15:15
            // 根据样式返回数据个数
            $videoDataProvider = new ActiveDataProvider([
                'query' => $objVideo->orderBy('total_views desc')->limit($limitCnt),
            ]);

            $data = $videoDataProvider->toArray($fields);
            foreach ($data as $k=>$dd)
            {
                $objChapters = VideoChapter::find();
                $objChapters->andWhere(['video_id' => $dd['video_id']]);
                $chapters = $objChapters->asArray()->all();
                if (empty($chapters))
                {
                    unset($data[$k]);
                    continue;
                }

                $isvalid = false;
                foreach ($chapters as $cp)
                {
                    $chapterurlArr = json_decode($cp['resource_url'], true);
                    foreach ($chapterurlArr as $val)
                    {
                        if(!empty($val))
                        {
                            $isvalid = true;
                            break;
                        }
                    }
                    if ($isvalid)
                        break;
                }
                if (!$isvalid)
                    unset($data[$k]);
            }

            foreach ($data as &$it)
            {
                $videoDao = new VideoDao();
                $videoInfo = $videoDao->videoInfo($it['video_id'], $fields);
                $actorsId = $videoInfo['actors_id'] ? explode(',', $videoInfo['actors_id']) : [];
                //演员信息，根据type区分演员和导演
                $actorlist = $videoDao->actorsInfo($actorsId);
                $director = $actors = [];
                foreach ($actorlist as &$actor) {  //循环影片所有的演员信息
                    if ($actor['type'] == Actor::TYPE_ACTOR) {
                        $actors[]   = $actor;
                    } else {
                        $director[] = $actor;
                    }
                }
                $it['actors'] = array_values($actors);
                $it['director'] = array_values($director);
                $it['year'] = $videoInfo['year'];
            }

            // 缓存推荐位视频id
            $videoIds = ArrayHelper::getColumn($data, 'video_id');
            $redis->setEx($redisKey, json_encode($videoIds, JSON_UNESCAPED_UNICODE), 600);

        }

        //24小时更新的剧集，不缓存
        if($data){
            foreach ($data as &$it) {
                /* 首页video检查created_at在24小时内为最新 begin */
                $time24 = strtotime("-1 day");//24小时之前的时间戳
                if($it['created_at'] >= $time24){
                    $it['video_newest'] = '1';//是最新
                }else{
                    $it['video_newest'] = '0';
                }
                //查询24小时内更新的集数
                $it['chapter_new_num'] = VideoChapter::find()->andWhere(['video_id' => $it['video_id']])->andWhere(['>=', 'created_at', $time24])->count();
                /* 首页video检查created_at在24小时内为最新 end */
            }
        }

        return $data;
    }
}