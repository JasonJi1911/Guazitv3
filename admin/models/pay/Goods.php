<?php
namespace admin\models\pay;

class Goods extends \common\models\pay\Goods
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'price', 'limit_num', 'content', 'display_order', 'tag'], 'required'],
            [['price', 'original_price', 'giving', 'content', 'type', 'tag', 'limit_num', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['title'], 'string', 'max' => 32],
            [['icon', 'apple_id'], 'string', 'max' => 64],
            [['desc'], 'string', 'max' => 512],
            [['display_order'], 'integer', 'min' => DISPLAY_ORDER_MIN, 'max' => DISPLAY_ORDER_MAX],
            [['price'], 'integer', 'min' => 1]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '商品id',
            'title' => '商品名称',
            'desc' => '商品描述',
            'icon' => '商品icon',
            'price' => '商品价格 单位：分',
            'original_price' => '商品原价 单位：分',
            'giving' => '赠送卡券数',
            'content' => '商品内容 ',
            'type' => '商品类型 1充值 2包月',
            'apple_id' => '对应苹果商店商品id',
            'tag' => '标签',
            'limit_num' => '限购（0-不限购，大于0为限购次数）',
            'display_order' => '排序',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'deleted_at' => '删除时间',
        ];
    }
}
