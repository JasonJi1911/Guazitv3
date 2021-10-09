<?php
namespace api\models\video;

class VideoFeedcountry extends \common\models\video\VideoFeedcountry
{
    public function fields()
    {
        return [
            'country_id'    => 'id',
            'country_code',
            'country_name',
            'imgname',
            'display_order',
            'mobile_areacode'
        ];
    }

    public static function find()
    {
        return parent::find()->addOrderBy(['display_order' => SORT_ASC]);
    }
}