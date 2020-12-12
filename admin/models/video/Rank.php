<?php
namespace admin\models\video;

class Rank extends \common\models\video\Rank
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'display_order', 'status'], 'required'],
            [['channel_id', 'status',  'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['title'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 64],
            [['display_order'], 'integer', 'min' => DISPLAY_ORDER_MIN, 'max' => DISPLAY_ORDER_MAX],
            ['channel_id', 'unique', 'targetAttribute' => ['channel_id'], 'message' => '该频道已经存在'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel_id' => '频道',
            'title' => '标题',
            'status' => '当前状态',
            'description' => '描述',
            'display_order' => '排序',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * 获取管理影视剧集
     */
    public function getRankVideos()
    {
        return $this->hasMany(RankVideo::className(), ['rank_id' => 'id']);
    }

    public function getVideoNum()
    {
        return $this->getRankVideos()->count();
    }

    public function getChannel()
    {
        return $this->hasOne(VideoChannel::className(), ['id' => 'channel_id']);
    }
}
