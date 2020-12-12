<?php
namespace admin\models\video;

class VideoFavorite extends \common\models\video\VideoFavorite
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'video_id', 'status', 'created_at'], 'integer'],
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
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}