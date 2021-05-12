<?php

namespace common\models\channel;

use Yii;

class ChannelVideo extends \xiang\db\ActiveRecord{
        // 渠道类型
        const OS_TYPE_APP = 1;
        const OS_TYPE_PC = 3;
        const OS_TYPE_TV = 2;

        public static $osType = [
            self::OS_TYPE_APP => '手机端',
            self::OS_TYPE_PC => 'PC端',
            self::OS_TYPE_TV => 'TV端',
        ];

    public function attributeLabels(){
        return [
            'sid' => '线路',
            'display_order' => '排序',
            'id' => 'id',
            'os_type' => '播放渠道',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }   

   public static function tableName()
    {
        return '{{%channel_video}}';
    }
}