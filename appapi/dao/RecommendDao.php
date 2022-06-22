<?php
namespace appapi\dao;

use appapi\data\ActiveDataProvider;
use appapi\models\video\Recommend;
use appapi\models\video\Video;
use appapi\models\video\VideoChapter;
use appapi\helpers\Common;
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
        $redisKey = $redisKey.'_'.Yii::$app->common->product;
        $redis = new RedisStore();

        if ($str = $redis->get($redisKey)) {
            $videoIds = json_decode($str, true);

            $videoDao = new VideoDao();
            $data = $videoDao->batchGetVideo($videoIds, $fields, false, ['actors']);
            // $data = json_decode($str, true);
        } else {
        // {
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

            $limitCnt = Yii::$app->common->product == Common::PRODUCT_APP ? 15 : 15;
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
                $actors = $videoDao->actorsInfo($actorsId);
                $it['actors'] = array_values($actors);
                $it['year'] = $videoInfo['year'];
            }

            // 缓存推荐位视频id
            $videoIds = ArrayHelper::getColumn($data, 'video_id');
            $redis->setEx($redisKey, json_encode($videoIds, JSON_UNESCAPED_UNICODE), 600);
        }

        return $data;
    }
}