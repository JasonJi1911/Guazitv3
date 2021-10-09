<?php
namespace admin\models\video;

use common\helpers\RedisKey;
use common\helpers\Tool;
use yii\helpers\ArrayHelper;

class VideoSource extends \common\models\video\VideoSource
{

    public $resource_url;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'display_order'], 'required'],
            [['display_order', 'created_at','play_limit'], 'integer'],
            [['name'], 'string', 'max' => 16],
            [['player'], 'string', 'max' => 2048],
            [['display_order'], 'integer', 'min' => DISPLAY_ORDER_MIN, 'max' => DISPLAY_ORDER_MAX],
            [['resource_url'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '源名称',
            'icon' => 'Icon图标',
            'display_order' => '排序',
            'player' => '播放器地址',
            'created_at' => 'Created At',
            'PlayLimit'=> '是否付费线路',
            'play_limit'=> '是否付费线路'
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (!$insert) {
            // 删除该视频缓存
            Tool::clearCache(RedisKey::videoInfoPrefix(''));
        }
        Tool::clearCache(RedisKey::videoSource());
        parent::afterSave($insert, $changedAttributes);
    }

    public function getPlayLimit()
    {
        return ArrayHelper::getValue(self::$playlimitMap, $this->play_limit);
    }
}
