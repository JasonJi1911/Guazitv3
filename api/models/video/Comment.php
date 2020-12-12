<?php
namespace api\models\video;

use api\models\user\User;
use common\helpers\Tool;

class Comment extends \common\models\video\Comment
{
    public function fields()
    {
        return [
            'comment_id' => 'id',
            'uid',
            'video_id',
            'chapter_id',
            'pid',
            'content',
            'source',
            'created_at',
            'time_flag' => function($model){
                return !empty($model->created_at) ? Tool::timeFormat($model->created_at) : '';
            },
        ];
    }

    public static function find()
    {
        return parent::find()
            ->andWhere([self::tableName() . '.status' => self::STATUS_EXAMINE_YES])
            ->addOrderBy([self::tableName() . '.created_at' => SORT_DESC]);
    }

    /**
     * 关联用户
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['uid' => 'uid']);
    }

}
