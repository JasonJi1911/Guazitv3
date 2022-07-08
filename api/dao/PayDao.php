<?php
namespace api\dao;

use api\data\ActiveDataProvider;
use api\exceptions\ApiException;
use api\helpers\ErrorCode;
use api\models\pay\Goods;
use api\models\pay\Order;
use api\models\pay\PayErrorLog;
use api\models\user\UserMessage;
use api\services\PayService;
use common\helpers\Tool;

class PayDao extends BaseDao
{
    /**
     * 获取所有商品列表
     * @param $type 类型
     * @return array
     * 20220701 新增渠道
     */
    public function goodsList($type,$product)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Goods::find()
                ->andWhere(['type' => $type])
                ->andWhere(['product' => $product])
                ->orderBy(['display_order' => SORT_DESC])
        ]);

        return $dataProvider->toArray();
    }

    /**
     * 商品详情
     * @param $goodsId
     * @return array
     * @throws \api\exceptions\ApiException
     */
    public function goodsInfo($goodsId) 
    {
        $goods = Goods::findOne(['id' => $goodsId]);
        if (!$goods) {
            throw new ApiException(ErrorCode::EC_GOODS_INVALID);
        }
        
        return $goods->toArray();
    }

    //下单
    public function createorder($arrGoodsInfo,$param){
        // 检查是否到已达到限购次数
        $objPayService = new PayService();
        $objPayService->_checkUserLimit($arrGoodsInfo, $param['uid']);

        $payChannel = 0;//支付方式
        if($param['type']=='alipay'){
            $payChannel = Order::PAY_CHANNEL_ALIPAY;
        }else if($param['type']=='wxpay'){
            $payChannel = Order::PAY_CHANNEL_WXPAY;
        }

        try {
            $ip = Tool::getIp();

            $objOrder = new Order();
//            $objOrder->trade_no     = $param["trade_no"];
            $objOrder->trade_no = $param["WIDout_trade_no"];//商户订单号
            $objOrder->original_fee = $arrGoodsInfo['original_price'];
            $objOrder->total_fee    = $arrGoodsInfo['current_price'];
            $objOrder->pay_channel  = $payChannel;
            $objOrder->from_channel = $param['from_channel'];
            $objOrder->goods_id     = $arrGoodsInfo['goods_id'];
            $objOrder->value        = $arrGoodsInfo['content'];//天数
            $objOrder->type         = $arrGoodsInfo['type'];
            $objOrder->uid          = $param['uid'];
            $objOrder->from_uid     = $param['uid'];
            $objOrder->status       = Order::STATUS_DEFAULT;
            $objOrder->note         = Order::$payChannels[$payChannel] . '购买会员';
            $objOrder->ip           = $ip;
            $objOrder->created_at   = time();

            if (!$objOrder->insert()) {
                throw new \Exception(json_encode($objOrder->errors, JSON_UNESCAPED_UNICODE));
                return false;
            }
        } catch(\Exception $e) {
            \Yii::warning("uid:{$param['uid']} create order failed - exception: " . $e->getMessage() ,'CREATE_ORDER_FAILED');
            throw new ApiException($e->getCode());
            return false;
        }
        return true;
    }
}
