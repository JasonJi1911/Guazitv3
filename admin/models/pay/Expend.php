<?php
namespace admin\models\pay;

use admin\models\user\User;

class Expend extends \common\models\pay\Expend
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['expend_no', 'uid', 'type'], 'required'],
            [['uid', 'type', 'score', 'from_channel', 'product', 'score_remain', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['expend_no'], 'string', 'max' => 64],
            [['note'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'expend_no' => 'Expend No',
            'uid' => 'Uid',
            'type' => 'Type',
            'score' => 'Score',
            'from_channel' => 'From Channel',
            'product' => 'Product',
            'score_remain' => 'Score Remain',
            'note' => 'Note',
            'ip' => 'Ip',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * 关联用户
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['uid' => 'uid']);
    }
}