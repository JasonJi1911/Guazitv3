<?php
namespace admin\models\video;

class VideoActor extends \common\models\video\VideoActor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id', 'actor_id', 'display_order', 'created_at'], 'integer'],
            [['display_order'], 'required', 'min' => DISPLAY_ORDER_MIN, 'max' => DISPLAY_ORDER_MAX],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'video_id' => 'Video ID',
            'actor_id' => 'Actor ID',
            'display_order' => 'Display Order',
            'created_at' => 'Created At',
        ];
    }
}