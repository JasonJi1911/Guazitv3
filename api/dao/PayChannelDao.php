<?php
namespace api\dao;
use api\data\ActiveDataProvider;
use api\models\pay\PayChannel;
use common\helpers\RedisKey;
use common\helpers\RedisStore;

/**
 * 支付渠道
 */
class PayChannelDao
{
    /**
     * 取支付通道信息
     * @param null $price
     * @return array|mixed
     */
    public function getPayChannel($price=null) {

        $key = RedisKey::getPayChannelKey();

        $redisStore = new RedisStore();
        //取缓存
        if ($strChannel = $redisStore->get($key)) {
            $arrChannel = json_decode($strChannel, true);
        }

        if (empty($arrChannel)) {
            //查询所有开启的支付通道
            $dataProvider = new ActiveDataProvider([
                'query' => PayChannel::find()->andWhere(['is_channel' => PayChannel::IS_CHANNEL_YES]),
            ]);
            
            $arrChannel = $dataProvider->toArray();

            $redisStore->setEx($key, json_encode($arrChannel));
        }

        if (!$price) {
            return $arrChannel;
        }

        foreach ($arrChannel as $k => $info) {
            if ($info['min_price'] && $price < $info['min_price']) {
                unset($arrChannel[$k]);
                continue;
            }

            if ($info['max_price'] && $price > $info['max_price']) {
                unset($arrChannel[$k]);
            }
        }

        return $arrChannel;
    }

}
