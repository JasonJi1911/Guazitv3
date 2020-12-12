<?php
namespace admin\models\user;

class UserTask extends \common\models\user\UserTask
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'date', 'task_type', 'award', 'task_id', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['expend_no'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'date' => 'Date',
            'task_type' => 'Task Type',
            'award' => 'Award',
            'expend_no' => 'Expend No',
            'task_id' => 'Task ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
