<?php
namespace admin\models\user;

class UserVip extends \common\models\user\UserVip
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'start_time', 'continue_time', 'end_time', 'status', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['uid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'start_time' => 'Start Time',
            'continue_time' => 'Continue Time',
            'end_time' => 'End Time',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
