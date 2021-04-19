<?php

namespace admin\models\channel;



class ChannelVideo extends \common\models\channel\ChannelVideo {

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sid' => '渠道源id',
            'os_type' => '端类型',
            'created_at' => '创建时间',
            'display_order'=>'sort',
            'updated_at' => 'Updated At',
            
        ];
    }


}