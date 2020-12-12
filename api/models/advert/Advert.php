<?php
namespace api\models\advert;

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
            'ad_type'
        ];
    }

    public static function find()
    {
        return parent::find()->andWhere(['status' => self::STATUS_OPEN])->addOrderBy(['id' => SORT_ASC]);
    }
}
