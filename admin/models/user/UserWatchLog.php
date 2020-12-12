<?php
namespace admin\models\user;

use admin\models\user\User;
use admin\models\video\Video;
use admin\models\video\VideoChapter;

class UserWatchLog extends \common\models\user\UserWatchLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'video_id', 'chapter_id', 'time', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'video_id' => 'Video ID',
            'chapter_id' => 'Chapter ID',
            'time' => 'Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }


    /**
     * 获取影片
     */
    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['id' => 'video_id']);
    }

    /**
     * 关联用户
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['uid' => 'uid']);
    }

    /**
     * 关联剧集
     */
    public function getChapter()
    {
        return $this->hasOne(VideoChapter::className(), ['id' => 'chapter_id']);
    }

}