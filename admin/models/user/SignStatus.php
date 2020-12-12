<?php
namespace admin\models\user;

class SignStatus extends \common\models\user\SignStatus
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'sign_days', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['uid'], 'unique'],
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
            'sign_days' => 'Sign Days',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
