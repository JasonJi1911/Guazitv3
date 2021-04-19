<?php
namespace api\dao;

use api\data\ActiveDataProvider;
use api\models\advert\AdvertPosition;
use api\models\advert\Advert;
use common\helpers\RedisKey;
use common\helpers\RedisStore;
use common\helpers\Tool;
use common\models\IpAddress;
use yii\helpers\ArrayHelper;

class AdvertDao extends BaseDao
{
    private $_fields = ['advert_id', 'ad_title', 'ad_image', 'ad_type', 'ad_skip_url', 'ad_url_type', 'ad_width', 'ad_height', 'position_id', 'city_id'];

    /**
     * 获取所有的广告id位置信息
     * 不传position id返回所有的position id
     * 传了返回这个position id下所有广告id
     * @param $positionId
     * @return array
     */
    public function advertIdByPosition($positionId = '', $city = '')
    {
        $redisStore = new RedisStore();
        // 广告位置key
        $key = RedisKey::advertPosition();
        if ($city) {
            $key = $key.'_'.md5($city);
        }
        
        if ($data = $redisStore->get($key)) {
            $data = json_decode($data, true);
        } else {
            //所有广告位
            $position = AdvertPosition::find()->select('id')->column();
            $citylist = IpAddress::find()->select('id')->andWhere(['city' => $city])->column();
            array_push($citylist, 0);
            //所有广告
            $advert = Advert::find()->select('id,position_id')
                ->where(['position_id' => $position, 'status' => Advert::STATUS_OPEN])
                ->all();

            if ($city)
                $advert = Advert::find()->select('id,position_id')
                    ->where(['position_id' => $position, 'status' => Advert::STATUS_OPEN, 'city_id' => $citylist])
                    ->all();
            //循环把广告id写入到位置数组里
            $data = [];
            foreach ($advert as $item) {
                $data[$item['position_id']][] = $item['id'];
            }
            // 写redis
            $redisStore->setEx($key, json_encode($data, JSON_UNESCAPED_UNICODE));
        }

        //如果传了位置id,表示获取此位置所有广告信息
        if ($positionId) {
            return ArrayHelper::getValue($data, $positionId, []);
        }
        return array_keys($data);
    }

    /**
     * 获取广告信息
     * @param $advertId
     * @return array
     */
    public function advertInfo($advertId)
    {
        $redisStore = new RedisStore();
        $key = RedisKey::advertInfoKey($advertId);

        if ($data = $redisStore->get($key)) {
            $data = json_decode($data, true);
        } else {
            //查询当前位置的广告位信息
            $advert = Advert::findOne(['id' => $advertId]);
            if (!$advert) {
                return [];
            }
            $data = $advert->toArray($this->_fields);
            // 写redis
            $redisStore->setEx($key, json_encode($data));
        }
        return $data;
    }

    /**
     * 批量获取广告信息,不需要排序
     * @param array $advertId
     * @return array
     */
    public function batchAdvertInfo(array $advertId)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Advert::find()
                ->where(['id' => $advertId])
        ]);

        return $dataProvider->toArray($this->_fields);
    }
}
