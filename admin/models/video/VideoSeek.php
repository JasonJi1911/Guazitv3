<?php
namespace admin\models\video;

class VideoSeek extends \common\models\video\VideoSeek
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'channel_id', 'area_id', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['video_name'], 'required'],
            [['year', 'director_name'], 'string', 'max' => 32],
            [['actor_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'video_name' => '影片名称',
            'channel_id' => '频道id',
            'area_id' => '地区id',
            'year' => '年代',
            'director_name' => '导演',
            'actor_name' => '演员',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'deleted_at' => '删除时间',
        ];
    }

    /*
     * 关联频道
     */
    public function getChannel()
    {
        return $this->hasOne(VideoChannel::className(), ['id' => 'channel_id']);
    }

    /*
     * 地区
     */
    public function getAreas()
    {
        return $this->hasOne(VideoArea::className(), ['id' => 'area_id']);
    }

}
