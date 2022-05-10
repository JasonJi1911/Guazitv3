<?php
namespace apinew\models\video;

class VideoFeedbackinfo extends \common\models\video\VideoFeedbackinfo
{
    public function fields()
    {
        return [
            'id',
            'message',
            'type'
        ];
    }

//    public static function find()
//    {
//        return parent::find()->addOrderBy(['created_at' => SORT_DESC]);
//    }
}