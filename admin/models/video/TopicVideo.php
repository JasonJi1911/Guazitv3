<?php
namespace admin\models\video;

use common\helpers\RedisKey;
use common\helpers\Tool;

class TopicVideo extends \common\models\video\TopicVideo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['topic_id', 'video_id',  'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['display_order'], 'integer', 'min' => DISPLAY_ORDER_MIN, 'max' => DISPLAY_ORDER_MAX],
            [['video_id', 'display_order'], 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'topic_id' => 'Topic ID',
            'video_id' => '影片',
            'display_order' => '排序',
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

    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }

    public function beforeSave($insert)
    {
        \Yii::warning('video_id:' . $this->video_id);
        if (!$this->video_id) {
            $this->addError('video_id', '影片不能为空');
            return false;
        }
        return parent::beforeSave($insert);
    }

    /**
     * 清理缓存
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        Tool::batchClearCache(RedisKey::topicVideoList($this->topic_id, ''));
        parent::afterSave($insert, $changedAttributes);
    }

}