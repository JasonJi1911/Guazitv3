<?php
namespace api\models\advert;

use common\models\IpAddress;

class Advert extends \common\models\advert\Advert
{
    public function fields()
    {
        return [
            'advert_id' => 'id',
            'ad_title'  => 'title',
            'ad_image'  => function () {
                return $this->image->toUrl();
            },
            'ad_skip_url' => 'skip_url',
            'ad_url_type' => 'url_type',
            'ad_width'    => 'width',
            'ad_height'   => 'height',
            'ad_type'     => 'ad_type',
            'city_id'         => 'city_id',
            'position_id'     => 'position_id',
        ];
    }

    public static function find()
    {
        return parent::find()->andWhere(['status' => self::STATUS_OPEN])->addOrderBy(['id' => SORT_ASC]);
    }
    
    public function getCity()
    {
        // 一个订单对应一个用户，一对一的关系使用hasOne()关联
        return $this->hasOne(IpAddress::className(), ['id' => 'city_id'])->asArray();
    }
}
