<?php
namespace admin\models\video;

use common\helpers\RedisKey;
use common\helpers\Tool;

class VideoSource extends \common\models\video\VideoSource
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'display_order'], 'required'],
            [['display_order', 'created_at'], 'integer'],
            [['name'], 'string', 'max' => 16],
            [['display_order'], 'integer', 'min' => DISPLAY_ORDER_MIN, 'max' => DISPLAY_ORDER_MAX],
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
            'created_at' => 'Created At',
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
}
