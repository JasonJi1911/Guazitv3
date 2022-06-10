<?php
namespace appapi\dao;

use appapi\data\ActiveDataProvider;
use appapi\exceptions\ApiException;
use appapi\helpers\ErrorCode;
use appapi\models\pay\Goods;

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
}
