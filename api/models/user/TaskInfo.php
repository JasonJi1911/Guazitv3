<?php
namespace api\models\user;

class TaskInfo extends \common\models\user\TaskInfo
{
    public function fields()
    {
        return [
            'task_id' => 'id',
            'title',
            'icon' => function(){
                return $this->icon->toUrl();
            },
            'desc',
            'award_num',
            'task_type',
            'limit_num'
        ];
    }

    // 过滤非法数据
    public static function find()
    {
        return parent::find()->andWhere(['status' => self::STATUS_ENABLED]);
    }
}
