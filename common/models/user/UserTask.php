<?php

namespace common\models\user;

use Yii;

/**
 * This is the model class for table "{{%user_task}}".
 *
 * @property int $id
 * @property int $uid 用户uid
 * @property int $date 日期
 * @property int $task_type 任务类型
 * @property int $award 奖励积分数
 * @property string $expend_no 关联单号
 * @property int $task_id 任务id
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
class UserTask extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_task}}';
    }


}
