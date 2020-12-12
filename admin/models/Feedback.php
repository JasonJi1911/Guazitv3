<?php

namespace admin\models;

class Feedback extends \common\models\Feedback
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'source', 'admin_id', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['images', 'contact', 'reply'], 'required'],
            [['content'], 'string', 'max' => 100],
            [['images', 'reply'], 'string', 'max' => 512],
            [['contact'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'uid' => '用户ID',
            'content' => '反馈内容',
            'images' => '反馈截图，json格式',
            'contact' => '联系方式',
            'source' => '来源',
            'reply' => '回复内容',
            'admin_id' => '管理员ID',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'deleted_at' => '删除时间',
        ];
    }


    /**
     * 关联用户
     */
    public function getUser()
    {
        return $this->hasOne(\admin\models\user\User::className(), ['uid' => 'uid']);
    }
}
