<?php
namespace admin\models\video;

class CommentLike extends \common\models\video\CommentLike
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid'], 'required'],
            [['uid', 'comment_id', 'status', 'created_at'], 'integer'],
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
            'comment_id' => 'Comment ID',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
}