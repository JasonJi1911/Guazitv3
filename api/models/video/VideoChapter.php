<?php
namespace api\models\video;

use api\models\user\User;
use common\helpers\Tool;

class VideoChapter extends \common\models\video\VideoChapter
{
    public function fields()
    {
        return [
            'chapter_id' => 'id',
            'video_id',
            'title',
            'total_comment',
            'total_views',
            'tag' => function(){
                return $this->play_limit == self::PLAY_LIMIT_FREE ? '' : self::$playLimitMap[$this->play_limit];
            },
            'play_limit',
            'resource_url' => function(){
                return json_decode($this->resource_url, true);
            },
            'duration_time' => function() {
                return date('H:i:s', $this->duration_time);
            },
        ];
    }

    /**
     * 章节评论总数
     * @param $chapterId
     * @return int
     */
    public static function getTotalComment($chapterId)
    {
        $totalComment = Comment::find()
            ->andWhere(['chapter_id' => $chapterId])
            ->joinWith('user')
            ->andWhere([User::tableName().'.status' => User::STATUS_ENABLED])
            ->count();

        return intval($totalComment);
//        return intval(Comment::find()->andWhere(['chapter_id' => $chapterId])->count());
    }
}
