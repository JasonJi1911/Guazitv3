<?php

namespace admin\models\video;

class VideoUpdateTitle extends \common\models\video\VideoUpdateTitle
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'display_order'], 'required'],
            [['channel_id', 'display_order', 'status', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['title'], 'string', 'min' => 0, 'max' => 32],
            [['content'], 'string', 'min' => 0, 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel_id'=>'频道',
            'title'=>'标题',
            'content'=>'描述',
            'display_order' => '排序',
            'status'=> '状态',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    public function beforeSave($insert)
    {
        if ($this->channel_id == null) {
            $this->channel_id = 0;
        }

        return parent::beforeSave($insert);
    }

    public function getChannel()
    {
        return $this->hasOne(VideoChannel::className(), ['id' => 'channel_id']);
    }
}
