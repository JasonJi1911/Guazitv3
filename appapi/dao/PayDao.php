<?php
namespace appapi\dao;

use appapi\models\pay\Order;
use appapi\services\PayService;
use appapi\data\ActiveDataProvider;
use appapi\exceptions\ApiException;
use appapi\helpers\ErrorCode;
use appapi\models\pay\Goods;
use common\helpers\Tool;

class PayDao extends BaseDao
{
    /**
     * 获取所有商品列表
     * @param $type 类型
     * @return array
     */
    public function goodsList($type)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Goods::find()
                ->andWhere(['type' => $type])
                ->orderBy(['display_order' => SORT_DESC])
        ]);

        return $dataProvider->toArray();
    }
    /*
     * 获取商品列表，需要渠道-app
     */
    public function goodsListBYproduct($type,$product)
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
     * @throws \appapi\exceptions\ApiException
     */
    public function goodsInfo($goodsId) 
    {
        $goods = Goods::findOne($goodsId);
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
            $objOrder->trade_no     = $param["WIDout_trade_no"];//商户订单号
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
            throw new \api\exceptions\ApiException($e->getCode());
            return false;
        }
        return true;
    }

    /*
     * 查询order
     */
    public function findorder($orderid){

        $order = Order::find()->andWhere(['trade_no' => $orderid])->asArray()->one();
        if (!$order) {
            return [];
        }

        return $order;
    }
}
