<?php

namespace admin\models\video;

class VideoUpdate extends \common\models\video\VideoUpdate
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id','week','display_order'], 'required'],
            [['video_id','video_update_title_id', 'channel_id', 'week', 'display_order', 'status', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['title'], 'string', 'min' => 0, 'max' => 32],
            [['stitle'], 'string', 'min' => 0, 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'video_id'=>'影片',
            'video_update_title_id'=>'更新位',
            'channel_id' => '频道',
            'week'=>'更新时间',
            'title'=>'标题',
            'stitle'=>'副标题',
            'display_order' => '排序',
            'status'=> '状态',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * 关联更新位
     */
    public function getVideoUpdateTitle()
    {
        return $this->hasOne(VideoUpdateTitle::className(), ['id' => 'video_update_title_id']);
    }

    /**
     * 关联频道
     */
    public function getChannel()
    {
        return $this->hasOne(VideoChannel::className(), ['id' => 'channel_id']);
    }

    /**
     * 关联影片
     */
    public function getVideo()
    {
        return $this->hasOne(Video::className(),['id' => 'video_id']);
    }
}
