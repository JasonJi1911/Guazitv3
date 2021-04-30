<?php
namespace api\dao;

use api\data\ActiveDataProvider;
use api\models\apps\AppsMarketChannel;
use api\models\apps\PushPassageway;
use api\models\Domain;
use api\models\video\VideoArea;
use api\models\video\VideoCategory;
use api\models\video\VideoChannel;
use api\models\video\VideoSource;
use api\models\video\VideoYear;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use yii\helpers\ArrayHelper;
use Yii;
use common\models\channel\ChannelVideo;

/**
 * 公共dao
 * Class CommonDao
 * @package api\dao
 */
class CommonDao extends BaseDao
{
    /**
     * 市场渠道
     */
    public function marketChannelId()
    {
        $key = RedisKey::marketChannel();
        $redis = new RedisStore();
        
        if ($data = $redis->get($key)) {
            return json_decode($data, true);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => AppsMarketChannel::find()
        ]);
        $data = $dataProvider->toArray();
        $data = ArrayHelper::map($data, 'key', 'id');
        $redis->setEx($key, json_encode($data, JSON_UNESCAPED_UNICODE));
        return $data;
    }

    /**
     * 频道缓存信息
     * @param array $fields
     * @param bool $index
     * @return array|mixed
     */
    public function videoChannel($fields = [], $index = false)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => VideoChannel::find()->andWhere(['is_kingkong'=> 1])
        ]);
        $data = $dataProvider->toArray();

        // 过滤字段
        if ($fields) {
            $data = $this->filter($data, $fields);
        }
        // 重组数据
        if ($index) {
            return ArrayHelper::index($data, 'channel_id');
        }
        return $data;
    }

    /**
     * 返回所有地域信息
     * @param bool $index
     * @return array
     */
    public function videoAreas($index = false)
    {
        $key = RedisKey::videoArea();
        $redis = new RedisStore();

        if ($str = $redis->get($key)) {
            $data = json_decode($str, true);
        } else {
            $bannerDataProvider = new ActiveDataProvider([
                'query' => VideoArea::find()
            ]);
            $data = $bannerDataProvider->toArray();
            $redis->set($key, json_encode($data));
        }
        
        if ($index) {
            return ArrayHelper::index($data, 'area_id');
        }

        return $data;
    }

    /**
     * 缓存年代信息,所有地方均用此处的年代信息,不需要键值对二次获取
     * @param bool $index
     * @return array
     */
    public function videoYears($index = false)
    {
        $key = RedisKey::videoYear();
        $redis = new RedisStore();

        if ($str = $redis->get($key)) {
            $data = json_decode($str, true);
        } else {
            $bannerDataProvider = new ActiveDataProvider([
                'query' => VideoYear::find(),
            ]);
            $data = $bannerDataProvider->toArray();
            $redis->set($key, json_encode($data));
        }

        if ($index) {
            return ArrayHelper::index($data, 'year_id');
        }

        return $data;
    }

    /**
     * 获取所有的分类信息
     * @param bool $index
     * @return array|mixed
     */
    public function videoCategory($index = false)
    {
        $key = RedisKey::videoCategory();
        $redis = new RedisStore();

        if ($str = $redis->get($key)) {
            $data = json_decode($str, true);
        } else {
            $dataProvider = new ActiveDataProvider([
                'query' => VideoCategory::find(),
            ]);
            $data = $dataProvider->toArray();
            $redis->set($key, json_encode($data, JSON_UNESCAPED_UNICODE));
        }
        if ($index) {
            return ArrayHelper::index($data, 'cat_id');
        }

        return $data;
    }

    /**
     * 缓存视频源,返回以source_id为key的二维数组
     * @return array
     */
    public function videoSource($product){
        
        $product=Yii::$app->common->product < 3 ?1:Yii::$app->common->product;
        if(Yii::$app->common->marketChannel == 'tv'){
            $product= 2;
        }
        $redis = new RedisStore();
        $key = RedisKey::videoShannelSource($product);
        
        // if($product ==0){
        //     $key = RedisKey::videoSource();
        // }
        if ($str = $redis->get($key)) {
            $data = json_decode($str, true);
        } else {
                $data = (new \yii\db\Query())
                ->select('v.id as source_id,v.name,v.icon,v.player')
                ->from(ChannelVideo::tableName().'as c')
                ->leftJoin(VideoSource::tableName().'as v','v.id=c.sid')
                ->where(['c.os_type'=>$product])
                ->andWhere(['v.created_at' => 0])
                ->orderBy('c.display_order desc')
                ->all();
                if(empty($data)){
                    $dataProvider = new ActiveDataProvider([
                        'query' => VideoSource::find()
                    ]);
                    $data = $dataProvider->toArray();
                }
            $redis->set($key, json_encode($data));
        }
        //$redis->del($key);
        return ArrayHelper::index($data, 'source_id');
    }

    /**
     * 推送通道
     */
    public function pushPassageway()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => PushPassageway::find()
        ]);
        
        return $dataProvider->toArray();
    }

    /**
     * 获取域名
     * @param $type
     * @return array
     */
    public function domain($type)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Domain::find()
                ->where(['type' => $type])
        ]);

        return  array_column($dataProvider->toArray(), 'content');
    }
}
