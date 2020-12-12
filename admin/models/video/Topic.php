<?php
namespace admin\models\video;

use common\helpers\RedisKey;
use common\helpers\Tool;
use common\models\video\TopicVideo;

class Topic extends \common\models\video\Topic
{

    // 专题COVER宽高比
    const TOPIC_COVER_WIDTH  = 250;
    const TOPIC_COVER_HEIGHT = 100;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'display_order'], 'required'],
            [['channel_id', 'is_hot', 'video_num', 'total_views', 'display_order', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['name'], 'string', 'max' => 32],
            [['intro'], 'string', 'max' => 256],
            [['display_order'], 'integer', 'min' => DISPLAY_ORDER_MIN, 'max' => DISPLAY_ORDER_MAX],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel_id' => 'Channel ID',
            'name' => '名称',
            'intro' => '简介',
            'cover' => '封面图',
            'is_hot' => 'Is Hot',
            'video_num' => 'Video Num',
            'total_views' => '总观看数',
            'display_order' => '排序',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }


    public function getChannel()
    {
        return $this->hasOne(VideoChannel::className(), ['id' => 'channel_id']);
    }

    public function beforeSave($insert)
    {
        // 删除缓存
        Tool::batchClearCache(sprintf(RedisKey::TOPIC_LIST, ''));
        
        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        TopicVideo::deleteAll(['topic_id' => $this->id]);
        return parent::beforeDelete();
    }
}
