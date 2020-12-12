<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "sf_user_watch_log".
 *
 * @property string $id
 * @property int $uid 用户id
 * @property int $video_id 系列id
 * @property int $chapter_id 视频id
 * @property int $time 时间
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class UserWatchLog extends \xiang\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_watch_log}}';
    }


}
