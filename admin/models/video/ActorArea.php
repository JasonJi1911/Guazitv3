<?php
namespace admin\models\video;

use common\helpers\RedisKey;
use common\helpers\Tool;

class ActorArea extends \common\models\video\ActorArea
{
    public function getActor()
    {
        return $this->hasMany(Actor::className(), ['area_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['area', 'display_order'], 'required'],
            [['display_order', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['area'], 'string', 'max' => 256],
            [['display_order'], 'integer', 'min' => DISPLAY_ORDER_MIN, 'max' => DISPLAY_ORDER_MAX],
//            [['area'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'area' => '地区',
            'display_order' => '排序',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function beforeSave($insert)
    {
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $key = RedisKey::actorArea();
        Tool::clearCache($key);
        // 清理此地域下的所有演员缓存
        Tool::batchClearCache(sprintf(RedisKey::AREA_ACTOR, ''));

        parent::afterSave($insert, $changedAttributes);
    }
}
