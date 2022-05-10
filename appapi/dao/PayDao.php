<?php
namespace apinew\dao;

use apinew\data\ActiveDataProvider;
use apinew\exceptions\ApiException;
use apinew\helpers\ErrorCode;
use apinew\models\pay\Goods;

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

    /**
     * 商品详情
     * @param $goodsId
     * @return array
     * @throws \apinew\exceptions\ApiException
     */
    public function goodsInfo($goodsId) 
    {
        $goods = Goods::findOne($goodsId);
        if (!$goods) {
            throw new ApiException(ErrorCode::EC_GOODS_INVALID);
        }
        
        return $goods->toArray();
    }
}
