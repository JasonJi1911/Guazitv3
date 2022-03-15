<?php

namespace admin\models\video;

class Trailer extends \common\models\video\Trailer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id', 'display_order'], 'required'],
            [['online_time'], 'datetime', 'timestampAttribute' => 'online_time'],
            [['video_id','trailer_title_id', 'display_order', 'status', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
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
            'trailer_title_id'=>'预告位',
            'title'=>'上线时间',//此列改为显示上线时间，可编辑文本
            'stitle'=>'副标题',
            'online_time'=>'上线时间',
            'display_order' => '排序',
            'status'=> '状态',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
//    public function beforeSave($insert)
//    {
//        return parent::beforeSave($insert);
//    }
//
//    public function afterSave($insert, $changedAttributes)
//    {
//        parent::afterSave($insert, $changedAttributes);
//    }

    /**
     * 关联预告位
     */
    public function getTrailerTitle()
    {
        return $this->hasOne(TrailerTitle::className(), ['id' => 'trailer_title_id']);
    }

    /**
     * 关联影片
     */
    public function getVideo()
    {
        return $this->hasOne(Video::className(),['id' => 'video_id']);
    }
}