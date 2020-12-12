<?php

namespace xiang\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * 软删除行为
 */
class SoftDeleteBehavior extends Behavior
{
    /**
     * @var string the attribute that will receive timestamp value
     */
    public $deletedAtAttribute = 'deleted_at';

    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_DELETE => 'softDelete',
        ];
    }

    /**
     * 软删除
     * @param Event $event
     */
    public function softDelete($event)
    {
        // 设置时间戳
        $this->owner->setAttribute($this->deletedAtAttribute, time());
        $this->owner->save(false);
        
        // 阻止真删除
        $event->isValid = false;
    }

    /**
     * 强制删除
     */
    public function forceDelete()
    {
        // 解除行为绑定
        $this->detach();
        // 执行删除操作
        $this->owner->delete();
    }
}
