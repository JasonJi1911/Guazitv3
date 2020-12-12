<?php
namespace admin\models\video;


class Comment extends \common\models\video\Comment
{

    public static function find()
    {
        return parent::find()->addOrderBy(['created_at' => SORT_DESC]);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'video_id', 'chapter_id'], 'required'],
            [['uid', 'video_id', 'chapter_id', 'pid', 'likes_num', 'source', 'status', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['content'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '用户',
            'video_id' => '影视',
            'chapter_id' => 'Chapter ID',
            'pid' => 'Pid',
            'content' => '内容',
            'likes_num' => '点赞数',
            'source' => '来源',
            'status' => '审核状态',
            'created_at' => '提交时间',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     *  关联用户
     */
    public function getUser()
    {
        return $this->hasOne(\admin\models\user\User::className(), ['uid' => 'uid']);
    }

    /**
     * 关联剧集
     */
    public function getVideoChapter()
    {
        return $this->hasOne(VideoChapter::className(), ['id' => 'video_id']);
    }


    /**
     * 关联影片
     */
    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['id' => 'video_id']);
    }

}