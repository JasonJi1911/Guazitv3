<?php
namespace admin\models\user;

use admin\models\Admin;

class CancelAccountLog extends \common\models\user\CancelAccountLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'status', 'admin_id', 'extract_at', 'created_at', 'updated_at'], 'integer'],
            [['remark'], 'string', 'max' => 255],
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
            'status' => 'Status',
            'remark' => '备注',
            'admin_id' => 'Admin ID',
            'extract_at' => '审核时间',
            'created_at' => '提交时间',
            'updated_at' => 'Updated At',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['uid' => 'uid']);
    }

    public function getAdmin()
    {
        return $this->hasOne(Admin::className(), ['id' => 'admin_id']);
    }
}