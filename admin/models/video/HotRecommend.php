<?php
namespace admin\models\video;

use common\helpers\RedisKey;
use common\helpers\RedisStore;
use common\helpers\Tool;
use yii\helpers\ArrayHelper;

class HotRecommend extends \common\models\video\HotRecommend
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'display_order'], 'required'],
            [['display_order', 'status', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['title'], 'string', 'max' => 36],
            [['display_order'], 'integer', 'min' => DISPLAY_ORDER_MIN, 'max' => DISPLAY_ORDER_MAX],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'recommend_id' => 'Recommend ID',
            'title' => '分类名',
            'display_order' => '排序',
            'status' => '状态',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    public function getActionLabel()
    {
        return ArrayHelper::getValue(self::$statusMap, $this->status);
    }

    public function getHotRecommendList()
    {
        return $this->hasMany(HotRecommendList::className(), ['recommend_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        // 删除缓存
        Tool::clearCache(RedisKey::searchHotWord());
        parent::afterSave($insert, $changedAttributes);
    }
}
