<?php
namespace api\models\video;

class CommentLike extends \common\models\video\CommentLike
{
    public function fields()
    {
        return  [
            'comment_id' ,
            'status'
        ];
    }
}