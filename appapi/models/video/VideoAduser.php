<?php
namespace appapi\models\video;

class VideoAduser extends \common\models\video\VideoAduser
{
    public function fields()
    {
        return [
            'aduser_id' => 'id',
            'type',
            'realname',
            'telephone',
            'country',
            'address',
            'industry',
            'wechatNO',
            'email'
        ];
    }

    public static function find()
    {
        return parent::find()->addOrderBy(['created_at' => SORT_DESC]);
    }
}