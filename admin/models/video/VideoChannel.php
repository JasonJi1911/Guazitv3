<?php
namespace admin\models\video;

use common\helpers\RedisKey;
use common\helpers\Tool;

class VideoChannel extends \common\models\video\VideoChannel
{
    public function getVideo()
    {
        return $this->hasMany(Video::className(), ['channel_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['channel_name', 'display_order'], 'required'],
            [['display_order', 'is_kingkong', 'status', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['channel_name'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 64],
            [['areas'], 'string', 'max' => 256],
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
            'channel_name' => '频道名',
            'icon' => '频道Icon',
            'description' => '描述',
            'areas' => 'Areas',
            'display_order' => '排序',
            'is_kingkong' => 'Is Kingkong',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function beforeSave($insert)
    {
        $areas = \Yii::$app->request->post('ChannelAreas');
        if ($areas) {
            $this->areas = implode(',', $areas);
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        // 清楚缓存
        Tool::batchClearCache(RedisKey::VIDEO_FILTER_LIST);
        Tool::batchClearCache(RedisKey::getApiCacheKey(''));

        parent::afterSave($insert, $changedAttributes);
    }
}
