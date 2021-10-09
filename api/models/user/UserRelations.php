<?php
namespace api\models\user;

class UserRelations extends \common\models\user\UserRelations
{

    public function fields()
    {
        return [
            'uid' ,
            'other_uid',
            'type',
            'status'
        ];
    }

    /**
     * 关联用户
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['uid' => 'uid']);
    }


    /**
     * 关联用户
     */
    public function getOther()
    {
        return $this->hasOne(User::className(), ['other_uid' => 'uid']);
    }
}