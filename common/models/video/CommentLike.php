<?php

namespace common\models\video;

use Yii;

/**
 * This is the model class for table "{{%comment_like}}".
 *
 * @property int $id
 * @property int $uid 用户uid
 * @property int $comment_id 评论id
 * @property int $status 类型 1赞 2取消赞
 * @property int $created_at 创建时间
 */
class CommentLike extends \yii\db\ActiveRecord
{
    const STATUS_YES = 1;
    const STATUS_NO  = 2;

    public static $status = [
        self::STATUS_YES => '已赞',
        self::STATUS_NO  => '取消赞'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%comment_like}}';
    }


}
