<?php
namespace admin\models\user;

use common\helpers\RedisKey;
use common\helpers\Tool;
use yii\helpers\ArrayHelper;

class TaskInfo extends \common\models\user\TaskInfo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['award_num', 'limit_num'], 'required'],
            [['award_num', 'award_type', 'task_type', 'limit_num', 'status', 'display_order', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['title'], 'string', 'max' => 256],
            [['desc'], 'string', 'max' => 1024],
            [['task_action'], 'string', 'max' => 128],
            [['limit_num'], 'integer','min' => 1]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '任务标题',
            'icon' => '任务icon',
            'desc' => '任务描述',
            'award_num' => '奖励',
            'award_type' => '奖励类型',
            'task_type' => '任务类型，0：新手任务,1：每日任务',
            'task_action' => '任务动作',
            'limit_num' => '完成次数限制',
            'status' => '状态',
            'display_order' => '排序',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
    
    public function getAwardTypeLabel()
    {
        return ArrayHelper::getValue(self::$awardTypeMap, $this->award_type);
    }

    public function getTaskTypeLabel()
    {
        return ArrayHelper::getValue(self::$typeMap, $this->task_type);
    }

    public function afterSave($insert, $changedAttributes)
    {
        $key = RedisKey::taskInfo();
        Tool::clearCache($key);
        
        parent::afterSave($insert, $changedAttributes);
    }
}
