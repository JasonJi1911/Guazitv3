<?php
namespace admin\models\stat;

use admin\models\video\Video;

class VideoStat extends \common\models\stat\VideoStat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'year_month', 'video_id'], 'required'],
            [['date', 'year_month', 'video_id', 'favors', 'play_num', 'visit_num', 'pay_user', 'pay_num', 'total_income', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['date', 'video_id'], 'unique', 'targetAttribute' => ['date', 'video_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'date'         => '日期',
            'year_month'   => 'Year Month',
            'video_id'     => 'Video ID',
            'favors'       => '收藏数',
            'play_num'     => '播放量（PV）',
            'visit_num'    => '访客量（UV）',
            'pay_user'     => '购买人数',
            'pay_num'      => '购买次数',
            'total_income' => '总收入',
            'created_at'   => 'Created At',
            'updated_at'   => 'Updated At',
            'deleted_at'   => 'Deleted At',
        ];
    }

    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['id' => 'video_id']);
    }
}