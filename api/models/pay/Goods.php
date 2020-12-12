<?php
namespace api\models\pay;

use yii\helpers\ArrayHelper;

class Goods extends \common\models\pay\Goods
{
    public function fields()
    {
        return [
            'goods_id' => 'id',
            'title',
            'desc',
            'current_price' => 'price',
            'original_price',
            'content',
            'giving',
            'type',
            'apple_id',
            'tag' => function() {
                return ArrayHelper::getValue(self::$tagMap, $this->tag, '');
            },
            'limit_num'
        ];
    }
}
