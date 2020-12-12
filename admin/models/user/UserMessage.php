<?php
namespace admin\models\user;

class UserMessage extends \common\models\user\UserMessage
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'type', 'created_at'], 'integer'],
            [['type', 'content', 'uid'], 'required'],
            [['content'], 'string', 'max' => 2048],
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->uid) {
            $user = User::findOne(['uid' => $this->uid]);
            if (empty($user)) {
                $this->addError('uid', '用户不存在');
                return false;
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '用户',
            'type' => '消息类型',
            'content' => '消息内容',
            'created_at' => '创建时间   ',
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
