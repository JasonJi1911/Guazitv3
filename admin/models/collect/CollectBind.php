<?php
namespace admin\models\collect;

use common\helpers\RedisKey;
use common\helpers\Tool;
use common\models\IpAddress;
use admin\models\video\VideoChannel;

class CollectBind extends \common\models\collect\CollectBind
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type_id','collect_id', 'video_channel', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['type_name'], 'string', 'max' => 50],
            [['type_id', 'type_name', 'collect_id', 'video_channel'], 'required'],
            [['video_channel'],'default','value'=>0]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => '类型id',
            'type_name' => '类型名称',
            'collect_id' => '采集资源id',
            'video_channel' => '绑定频道',
            'channel' => '绑定频道',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     * 关联视频线路
     */
    public function getChannel()
    {
        $videoChannel = VideoChannel::findOne($this->video_channel);
        if ($videoChannel) {
            return $videoChannel->id;
        }

        return '--';
    }
}